/* ---------- nav (mobile menu) ---------- */
const toggle = document.getElementById('menu-toggle');
const navLinks = document.getElementById('nav-links');
toggle?.addEventListener('click', () => {
  const open = navLinks.classList.toggle('active');
  toggle.setAttribute('aria-expanded', open);
});
navLinks?.addEventListener('click', e => { if (e.target.closest('a')) { navLinks.classList.remove('active'); toggle.setAttribute('aria-expanded', 'false'); } });

/* ---------- certificate lightbox ---------- */
const box = document.getElementById('lightbox');
document.querySelectorAll('.ach__thumb').forEach(b => b.addEventListener('click', () => {
  const img = box.querySelector('img');
  img.src = b.dataset.full; img.alt = b.dataset.alt;
  box.showModal();
}));
box?.addEventListener('click', e => { if (e.target === box || e.target.closest('.lightbox__close')) box.close(); });

/* ---------- helpers ---------- */
const h = (tag, cls, text) => {
  const n = document.createElement(tag);
  if (cls) n.className = cls;
  if (text != null) n.textContent = text;
  return n;
};
async function getJSON(url) {
  const r = await fetch(url, { headers: { Accept: 'application/json' } });
  if (!r.ok) throw new Error(`${url} returned ${r.status}`);
  return r.json();
}

/* ---------- projects: async cards ---------- */
const grid = document.getElementById('grid');
const projects = new WeakMap();

function skeleton() {
  const c = h('article', 'card');
  c.append(h('div', 'sk sk--title'), h('div', 'sk sk--line'), h('div', 'sk sk--body'));
  return c;
}

function buildCard(p) {
  const card = h('article', `card card--${p.size}`);
  const head = h('header');
  head.append(h('h3', null, p.title), h('p', null, p.description));
  card.append(head);
  if (p.type === 'embed' || p.type === 'php') {
    const body = h('div', `card__body${p.type === 'php' ? ' card__body--inline' : ''}`);
    body.append(h('p', 'pending', 'Loads when you scroll here'));
    card.append(body);
  }
  const foot = h('footer');
  const tags = h('ul', 'tags');
  p.tags.forEach(t => tags.append(h('li', null, t)));
  const links = h('span', 'links');
  for (const [label, href] of [['Open live', p.live], ['Source', p.repo]]) {
    if (!href) continue;
    const a = h('a', null, label);
    a.href = href; a.target = '_blank'; a.rel = 'noopener';
    links.append(a);
  }
  foot.append(tags, links);
  card.append(foot);
  projects.set(card, p);
  return card;
}

function showError(body, message, retry) {
  const box = h('div', 'error');
  const btn = h('button', null, 'Try again');
  btn.type = 'button';
  btn.addEventListener('click', retry);
  box.append(h('p', null, message), btn);
  body.replaceChildren(box);
}

// Each card loads on its own, so one broken project never blocks the rest.
async function hydrate(card) {
  const p = projects.get(card);
  const body = card.querySelector('.card__body');
  if (!p || !body) return;
  const retry = () => { body.replaceChildren(h('p', 'pending', 'Loading…')); hydrate(card); };
  try {
    if (p.type === 'embed' && p.embed) {
      const f = h('iframe');
      f.title = p.title;
      f.setAttribute('sandbox', 'allow-scripts allow-forms');
      f.addEventListener('load', () => body.querySelector('.pending')?.remove());
      f.src = p.embed;
      body.replaceChildren(h('p', 'pending', 'Loading…'), f);
    } else if (p.type === 'php') {
      const res = await fetch(`api/widget.php?id=${encodeURIComponent(p.id)}`);
      if (!res.ok) throw new Error(`widget ${res.status}`);
      body.innerHTML = await res.text();          // trusted: written on this server
      if (p.module) (await import(new URL(p.module, document.baseURI))).mount?.(body);
    }
  } catch (err) {
    console.error(p.id, err);
    showError(body, `Couldn't load ${p.title}.`, retry);
  }
}

const observer = new IntersectionObserver(entries => {
  for (const en of entries) {
    if (!en.isIntersecting) continue;
    observer.unobserve(en.target);
    hydrate(en.target);
  }
}, { rootMargin: '200px' });

async function initProjects() {
  if (!grid) return;
  grid.setAttribute('aria-busy', 'true');
  grid.replaceChildren(skeleton(), skeleton(), skeleton());
  try {
    const { projects: list } = await getJSON(grid.dataset.endpoint);
    grid.replaceChildren();
    if (!list.length) { grid.append(h('p', 'muted', 'No projects yet.')); return; }
    for (const p of list) { const c = buildCard(p); grid.append(c); observer.observe(c); }
  } catch (err) {
    console.error(err);
    const wrap = h('div', 'error');
    const btn = h('button', null, 'Try again');
    btn.type = 'button'; btn.addEventListener('click', initProjects);
    wrap.append(h('p', null, "Couldn't load projects."), btn);
    grid.replaceChildren(wrap);
  } finally {
    grid.removeAttribute('aria-busy');
  }
}
initProjects();

/* ---------- contact form: async submit, PHP validates ---------- */
const form = document.getElementById('contact-form');
const status = document.getElementById('form-status');
form?.addEventListener('submit', async e => {
  e.preventDefault();
  status.classList.remove('is-error');
  status.textContent = 'Sending…';
  try {
    const r = await fetch(form.action, { method: 'POST', body: new FormData(form), headers: { 'X-Requested-With': 'fetch' } });
    const data = await r.json();
    status.textContent = data.message;
    status.classList.toggle('is-error', !data.ok);
    if (data.ok) form.reset();
  } catch {
    status.textContent = 'Network error. Please try again.';
    status.classList.add('is-error');
  }
});
