# Deploy GMAC to Hostinger

Upload either the GitHub repo or the local zip, then point the site at Laravel’s `public` folder.

## What to upload

- **GitHub:** `https://github.com/sammyniyo/gmac` (`main`). Vite assets are already in `public/build`.
- **Local zip:** `.deploy/gmac-hostinger.zip` (includes `vendor` + built assets). Do not upload `.deploy` secrets or `__gmac_setup.php`.

## Hostinger

1. PHP **8.2+** (8.3 is fine). Git deploy needs `proc_open` enabled — in hPanel → Advanced → PHP Configuration, remove `proc_open` and `popen` from `disable_functions`.
2. Extract the project into `domains/gmac.coffee/public_html`.
3. Copy `deploy/public_html.htaccess` to `public_html/.htaccess` so `/` serves `public/`.
   Or in hPanel set the document root to `public_html/public`.
4. Copy `.env.hostinger.example` to `.env`.
5. If you have SSH:

```bash
bash deploy/hostinger-setup.sh
```

   Without SSH, in hPanel Terminal run the same script, or:

```bash
php artisan key:generate --force
php artisan migrate --force --seed
php artisan config:cache
```

6. Make these writable: `storage/`, `bootstrap/cache/`, `database/`, `public/storage/`.
7. Do **not** run `php artisan storage:link` — Hostinger blocks `symlink()`. `.env` already uses `FILESYSTEM_PUBLIC_ROOT=public/storage`.

## After go-live

- Admin: `https://gmac.coffee/login` — `admin@gmac.coffee` / `password`. Change that password.
- Delete any leftover `default.php`, `gmac-release.zip`, `gmac.aa`, or `__gmac_setup.php` in `public_html`.
- English URLs have no `/en` prefix (`/history`, `/team`).
- SMTP is `info@gmac.coffee` via `smtp.hostinger.com:465`. Put the mailbox password in `.env` as `MAIL_PASSWORD`, then `php artisan config:clear`.

## MySQL later

Create a database in hPanel, then in `.env` set `DB_CONNECTION=mysql` and the `DB_*` values. Use `127.0.0.1` as the host from the site itself. Run `php artisan migrate --force --seed` again on an empty database.
