# Deployment notes (Laravel Cloud)

## Required

- Set `APP_URL` to your `https://...laravel.cloud` URL.
- Use a shared session driver (recommended): `SESSION_DRIVER=database` (or `redis`).
- Run migrations (creates the `sessions` table used by `SESSION_DRIVER=database`):
  - `php artisan migrate --force`

## After each deploy

- Clear caches:
  - `php artisan optimize:clear`
- Build frontend assets (if your pipeline doesn’t do it):
  - `npm ci`
  - `npm run build`

