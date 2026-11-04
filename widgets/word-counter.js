export function mount(root) {
  const input = root.querySelector('textarea');
  const words = root.querySelector('[data-words]');
  const chars = root.querySelector('[data-chars]');
  input.addEventListener('input', () => {
    const t = input.value.trim();
    words.textContent = t ? t.split(/\s+/).length : 0;
    chars.textContent = input.value.length;
  });
}
