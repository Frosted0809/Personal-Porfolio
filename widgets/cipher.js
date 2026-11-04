// The actual cipher runs in PHP: this file only sends text to api/cipher.php.
export function mount(root) {
  const text = root.querySelector('[data-text]');
  const shift = root.querySelector('[data-shift]');
  const out = root.querySelector('[data-out]');
  let timer;

  async function call(s) {
    const body = new FormData();
    body.append('text', text.value);
    body.append('shift', s);
    const r = await fetch('api/cipher.php', { method: 'POST', body });
    if (!r.ok) throw new Error(r.status);
    return r.json();
  }
  async function run() {
    if (!text.value.trim()) { out.textContent = 'Result appears here.'; return; }
    try { out.textContent = (await call(shift.value || 0)).result; }
    catch { out.textContent = 'Could not reach the server.'; }
  }
  const schedule = () => { clearTimeout(timer); timer = setTimeout(run, 250); };
  text.addEventListener('input', schedule);
  shift.addEventListener('input', schedule);

  root.querySelector('[data-all]').addEventListener('click', async () => {
    if (!text.value.trim()) return;
    try {
      const { all } = await call('all');
      out.replaceChildren(...all.map(({ shift: n, text: t }) => {
        const line = document.createElement('div');
        line.textContent = `${String(n).padStart(2, '0')}: ${t}`;
        return line;
      }));
    } catch { out.textContent = 'Could not reach the server.'; }
  });
}
