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

/* ---------- projects: cards like my first portfolio, demo opens in a dialog ---------- */
const grid = document.getElementById('grid');
const demo = document.getElementById('demo');
const demoTitle = demo?.querySelector('[data-demo-title]');
const demoBody = demo?.querySelector('[data-demo-body]');

function skeleton() {
  const c = h('article', 'project-card');
  c.append(h('div', 'sk sk--icon'), h('div', 'sk sk--title'), h('div', 'sk sk--line'));
  return c;
}

function linkBtn(label, href) {
  const a = h('a', 'btn', label);
  a.href = href; a.target = '_blank'; a.rel = 'noopener';
  return a;
}

function buildCard(p) {
  const card = h('article', 'project-card');
  if (p.image) {
    const img = h('img');
    img.src = p.image; img.alt = ''; img.loading = 'lazy';
    card.append(img);
  } else {
    const ic = h('div', 'project-card__icon');
    ic.append(h('i', p.icon || 'fa-solid fa-code'));
    card.append(ic);
  }
  card.append(h('h3', null, p.title), h('p', null, p.description));
  const tags = h('ul', 'tags');
  p.tags.forEach(t => tags.append(h('li', null, t)));
  card.append(tags);

  const actions = h('div', 'btn-group');
  if (p.type === 'php' || p.type === 'embed') {
    const b = h('button', 'btn', 'Live Demo');
    b.type = 'button';
    b.addEventListener('click', () => openDemo(p));
    actions.append(b);
  } else if (p.live) {
    actions.append(linkBtn('Live Demo', p.live));
  }
  if (p.repo) actions.append(linkBtn('Github Repo', p.repo));
  card.append(actions);
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

// The demo loads only when someone clicks Live Demo.
async function loadDemo(p) {
  const retry = () => { demoBody.replaceChildren(h('p', 'pending', 'Loading…')); loadDemo(p); };
  try {
    if (p.type === 'embed' && p.embed) {
      const f = h('iframe');
      f.title = p.title;
      f.setAttribute('sandbox', 'allow-scripts allow-forms');
      f.src = p.embed;
      demoBody.replaceChildren(f);
    } else if (p.type === 'php') {
      const res = await fetch(`api/widget.php?id=${encodeURIComponent(p.id)}`);
      if (!res.ok) throw new Error(`widget ${res.status}`);
      demoBody.innerHTML = await res.text();          // trusted: written on this server
      if (p.module) (await import(new URL(p.module, document.baseURI))).mount?.(demoBody);
    }
  } catch (err) {
    console.error(p.id, err);
    showError(demoBody, `Couldn't load ${p.title}.`, retry);
  }
}

function openDemo(p) {
  demoTitle.textContent = p.title;
  demoBody.replaceChildren(h('p', 'pending', 'Loading…'));
  demo.showModal();
  loadDemo(p);
}
demo?.addEventListener('click', e => { if (e.target === demo || e.target.closest('[data-demo-close]')) demo.close(); });
demo?.addEventListener('close', () => demoBody.replaceChildren());

async function initProjects() {
  if (!grid) return;
  grid.setAttribute('aria-busy', 'true');
  grid.replaceChildren(skeleton(), skeleton(), skeleton());
  try {
    const { projects: list } = await getJSON(grid.dataset.endpoint);
    grid.replaceChildren(...list.map(buildCard));
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

/* ---------- contact: copy email ---------- */
document.querySelectorAll('[data-copy]').forEach(btn => btn.addEventListener('click', async () => {
  const note = document.querySelector('[data-copy-status]');
  try { await navigator.clipboard.writeText(btn.dataset.copy); note.textContent = 'Email copied.'; }
  catch { note.textContent = 'Could not copy. Select the email above instead.'; }
}));
