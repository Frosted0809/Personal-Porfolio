// Runs the ORIGINAL Python file (projects/password-checker/main.py) in the browser with Pyodide.
// The file is not modified: main() reads a password with input() and prints, and we feed it and capture it.
const PYODIDE = 'https://cdn.jsdelivr.net/pyodide/v0.26.4/full/';
const MAIN_PY = 'projects/password-checker/main.py';
let engine;                                          // shared, so Python loads only once

function loadEngine() {
  if (!engine) {
    engine = (async () => {
      await new Promise((ok, fail) => {
        const s = document.createElement('script');
        s.src = PYODIDE + 'pyodide.js';
        s.onload = ok;
        s.onerror = () => fail(new Error('Could not load Pyodide'));
        document.head.append(s);
      });
      const py = await window.loadPyodide({ indexURL: PYODIDE });
      const res = await fetch(MAIN_PY);
      if (!res.ok) throw new Error(`main.py returned ${res.status}`);
      py.FS.writeFile('/main.py', await res.text());
      return py;
    })();
    engine.catch(() => { engine = null; });          // allow a retry after a failure
  }
  return engine;
}

function runMain(py, password) {
  const lines = [];
  let fed = false;
  py.setStdin({ stdin: () => (fed ? undefined : ((fed = true), password)) });
  py.setStdout({ batched: line => lines.push(line) });
  py.runPython("import runpy\nrunpy.run_path('/main.py', run_name='__main__')");
  return lines;
}

export function mount(root) {
  const input = root.querySelector('[data-input]');
  const toggle = root.querySelector('[data-toggle]');
  const status = root.querySelector('[data-status]');
  const term = root.querySelector('[data-term]');
  const barWrap = root.querySelector('[data-barwrap]');
  const bar = root.querySelector('[data-bar]');
  const widget = root.querySelector('.pwc');
  let timer, started = false;

  toggle.addEventListener('click', () => {
    const show = input.type === 'password';
    input.type = show ? 'text' : 'password';
    toggle.textContent = show ? 'Hide' : 'Show';
    toggle.setAttribute('aria-pressed', String(show));
  });

  async function run() {
    if (!input.value) { term.hidden = true; barWrap.hidden = true; return; }
    try {
      const py = await loadEngine();
      status.textContent = 'Python is ready.';
      const lines = runMain(py, input.value);
      const shown = input.type === 'password' ? '•'.repeat(input.value.length) : input.value;
      term.textContent = lines.map(l => (l.startsWith('Enter Password:') ? l + shown : l)).join('\n');
      term.hidden = false;
      const score = Number((lines.find(l => l.startsWith('score:')) || '').match(/\d+/)?.[0] || 0);
      const verdict = ((lines.find(l => l.startsWith('Verdict:')) || '').split(':')[1] || '').trim().toLowerCase();
      widget.dataset.tier = verdict;
      bar.style.width = `${Math.min(score, 100)}%`;
      barWrap.hidden = false;
    } catch (err) {
      console.error(err);
      status.textContent = "Couldn't start Python. Check your connection and try again.";
    }
  }

  async function start() {
    if (started) return;
    started = true;
    status.textContent = 'Starting Python…';
    try { await loadEngine(); status.textContent = 'Python is ready.'; if (input.value) run(); }
    catch (err) { console.error(err); started = false; status.textContent = "Couldn't start Python. Click the box to try again."; }
  }

  input.addEventListener('focus', start);
  input.addEventListener('input', () => { start(); clearTimeout(timer); timer = setTimeout(run, 250); });
}
