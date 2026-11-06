# InfinityFree Deployment Context

This project is a PHP portfolio that can be hosted on InfinityFree without a
database. It uses PHP files, JSON data, static assets, and a writable JSONL
file for contact messages.

## Requirements

- An active InfinityFree hosting account and website
- PHP 8.x enabled in the InfinityFree control panel
- InfinityFree File Manager or an FTP client such as FileZilla
- The FTP hostname, username, and password from InfinityFree

No MySQL database or server-side Python installation is required.

## First deployment

1. Activate an InfinityFree site and note its domain or subdomain.
2. Open **Control Panel > FTP Accounts** and copy the FTP connection details.
3. Connect with FileZilla or open InfinityFree File Manager.
4. Open the remote `htdocs` directory.
5. Upload the **contents** of this project directory:

   `C:\xampp\htdocs\portfolio-Hansel\PortfolioXamp`

6. Do not upload the outer `PortfolioXamp` folder itself. The remote structure
   must start like this:

   ```text
   htdocs/
   ├── index.php
   ├── config.php
   ├── api/
   ├── assets/
   ├── data/
   ├── includes/
   ├── projects/
   └── widgets/
   ```

7. Open the website URL and confirm that the homepage loads.

## Files to exclude

Do not upload these items:

- `.git/`
- `practice/`
- Local-only configuration files such as `config.local.php`

The `practice/` directory is not needed by the live portfolio.

## Important files

- `config.php`: portfolio name, biography, links, email, experience, and
  achievements
- `data/projects.json`: project cards and project links
- `assets/style.css`: site styling
- `assets/app.js`: browser-side behavior
- `widgets/`: interactive project widgets
- `projects/password-checker/main.py`: source loaded by the browser-based
  password checker
- `data/messages.jsonl`: contact form submissions

## Updating the deployed portfolio

It is safe to deploy the portfolio first and update it later.

1. Make changes locally in XAMPP.
2. Test the changes at `http://localhost/PortfolioXamp/`.
3. Back up the remote `data/messages.jsonl` file before overwriting files.
4. Upload the changed files into the matching locations under remote `htdocs`.
5. Overwrite the old files when the FTP client asks.
6. Hard-refresh the website if the old version is cached.

Examples:

- Content update: upload `config.php`
- New or changed project: upload `data/projects.json`
- Styling update: upload `assets/style.css`
- JavaScript update: upload `assets/app.js`
- New widget: upload its files inside `widgets/`

Do not delete `data/messages.jsonl` during an update because it contains
contact submissions.

## Contact form storage

The contact form appends messages to:

```text
data/messages.jsonl
```

The existing `data/.htaccess` file blocks direct web access to the data
directory. Keep this file when uploading the project.

After deployment, submit a test message. If the form reports that it cannot
save the message, verify that `data/messages.jsonl` exists and is writable in
InfinityFree File Manager.

## Password checker

InfinityFree does not need to run Python. The password checker runs Python in
the visitor's browser through Pyodide loaded from a CDN.

Keep this file on the server:

```text
projects/password-checker/main.py
```

Visitors need an internet connection for the Pyodide CDN to load. The Python
file is downloadable by anyone who knows its URL, so do not put secrets in it.

## Verification checklist

After the first deployment or an update, verify:

- The homepage loads at the website root
- CSS, JavaScript, and images load correctly
- The Projects section appears
- Project repository and live-demo links work
- The password checker opens and runs
- The contact form accepts a valid message
- An invalid email or short message is rejected
- The website still uses HTTPS

If a change does not appear immediately, perform a hard refresh or open the
site in a private browser window.

## Common deployment mistakes

- Uploading `PortfolioXamp` inside `htdocs` instead of uploading its contents
- Omitting the `api/`, `data/`, `projects/`, or `widgets/` directories
- Forgetting `projects/password-checker/main.py`
- Deleting `data/messages.jsonl` while updating files
- Uploading `.git/` or the local `practice/` directory
- Using a PHP version older than PHP 8.x
