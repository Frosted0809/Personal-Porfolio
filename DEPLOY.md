# Deploying (InfinityFree or any PHP host)

1. Create a hosting account and note your FTP details (host, username, password).
2. Upload everything inside the deploy folder into the host's `htdocs` folder (the contents, not the folder itself).
3. Open your site URL and check: the page, the Projects card, Live Demo, and the Contact email link.

Notes
- Python is NOT needed on the host. The Password Checker runs `projects/password-checker/main.py` in the visitor's browser (Pyodide from cdn.jsdelivr.net), so visitors need internet.
- `main.py` has to be downloadable so the browser can run it. Anyone who knows its URL can read it.
- Don't upload: `.git`, `practice/`, any `config.local.php`.
