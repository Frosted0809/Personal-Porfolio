# Hansel Protacio, PHP Portfolio

Run: copy this folder to `C:\xampp\htdocs\PortfolioXamp`, start Apache in XAMPP, open http://localhost/PortfolioXamp/

No MySQL needed: contact messages are saved to `data/messages.jsonl` (blocked from the web by `data/.htaccess`).

## Edit your content
- `config.php`: name, bio, links, experience cards, certificates
- `data/projects.json`: project cards (types: `link`, `embed`, `php`)
- `widgets/`: your demo widgets (`name.php` fragment + optional `name.js` with `export function mount(root)`). Copy `_template.*` to start.
- Projects section stays hidden until `data/projects.json` has at least one project.
- `practice/php-basics.php`: your original PHP practice notes
