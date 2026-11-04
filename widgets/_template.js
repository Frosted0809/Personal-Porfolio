// Optional. Same name as the .php file (my-app.js). Runs after the fragment is loaded.
export function mount(root) {
  const out = root.querySelector('[data-out]');
  root.querySelector('[data-btn]').addEventListener('click', () => { out.textContent = 'It works.'; });
}
