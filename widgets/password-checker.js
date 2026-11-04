// The scoring runs in PHP (api/password.php). This file only sends the text and draws the result.
export function mount(root) {
  const input = root.querySelector('[data-input]');
  const toggle = root.querySelector('[data-toggle]');
  const result = root.querySelector('[data-result]');
  const verdict = root.querySelector('[data-verdict]');
  const score = root.querySelector('[data-score]');
  const bar = root.querySelector('[data-bar]');
  const stats = root.querySelector('[data-stats]');
  const checks = root.querySelector('[data-checks]');
  let timer, seq = 0;

  toggle.addEventListener('click', () => {
    const show = input.type === 'password';
    input.type = show ? 'text' : 'password';
    toggle.textContent = show ? 'Hide' : 'Show';
    toggle.setAttribute('aria-pressed', String(show));
  });

  async function run() {
    const mine = ++seq;
    if (!input.value) { result.hidden = true; return; }
    try {
      const body = new FormData();
      body.append('password', input.value);
      const r = await fetch('api/password.php', { method: 'POST', body });
      if (!r.ok) throw new Error(r.status);
      const d = await r.json();
      if (mine !== seq) return;                       // ignore stale responses
      result.hidden = false;
      const tier = d.verdict.toLowerCase().replace(' ', '-');
      result.dataset.tier = tier;
      verdict.textContent = d.verdict;
      score.textContent = `${d.score} / ${d.max}`;
      const pct = Math.round((d.score / d.max) * 100);
      bar.style.width = `${pct}%`;
      bar.parentElement.setAttribute('aria-valuenow', pct);
      stats.textContent = `${d.length} characters · ${d.entropy} bits of entropy` + (d.common ? ' · on the common-password list' : '');
      checks.replaceChildren(...d.checks.map(c => {
        const li = document.createElement('li');
        li.className = c.ok ? 'ok' : 'no';
        li.textContent = `${c.ok ? '✓' : '✗'} ${c.label}`;
        return li;
      }));
    } catch {
      result.hidden = false;
      verdict.textContent = 'Could not reach the server.';
    }
  }
  input.addEventListener('input', () => { clearTimeout(timer); timer = setTimeout(run, 200); });
}
