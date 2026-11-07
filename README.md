# made by Hansel Protacio, PHP Portfolio

Local Run: copy this folder to `C:\xampp\htdocs\PortfolioXamp`, start Apache in XAMPP, open http://localhost/PortfolioXamp/

No MySQL needed. The Contact section just shows the email set in `config.php` (`'email'`).

## Edit your content
- `config.php`: name, bio, links, experience cards, certificates
- `data/projects.json`: project cards (types: `link`, `embed`, `php`)
- `widgets/`: demo widgets (`name.php` fragment + optional `name.js` with `export function mount(root)`). Copy `_template.*` to start.
- Projects section stays hidden until `data/projects.json` has at least one project.
- `projects/`: files your demos need (e.g. the Python checker)
- `DEPLOY.md`: how to put the site online
- `practice/php-basics.php`: your original PHP practice notes
