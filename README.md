# Royal Frost

Corporate website for Royal Frost, a general supplies, contracting, and trading and export company based in Cairo, Egypt. The site is bilingual (English and Arabic, with full right-to-left support) and includes an admin dashboard for editing all text and images without touching code.

The design comes from the Royal Frost Figma file and covers four pages: Home, About Us, Services, and Contact.

## Features

- Four pages: Home, About Us, Services, Contact
- English (default) and Arabic, each on its own URL (`/en/...` and `/ar/...`), with a language switcher in the header and footer
- Arabic pages render right to left, with mirrored layout and arrows
- Responsive layout for desktop, tablet, and mobile, including a mobile menu
- Hover effects on buttons, cards, images, navigation, tabs, and form fields
- Scroll-reveal animations that respect the reduced-motion setting
- Contact form with validation, a spam honeypot, rate limiting, and email delivery
- Admin dashboard at `/admin` for editing text in both languages and replacing images
- Uploaded images are resized and converted to WebP automatically
- Self-hosted fonts, so the site makes no third-party requests

## Tech stack

- Laravel 13 (PHP 8.3 or newer)
- Blade templates
- Tailwind CSS 4 with Vite
- Filament 5 for the admin dashboard
- SQLite by default (MySQL also works)

## Requirements

- PHP 8.3 or newer with the `intl`, `gd`, `exif`, `zip`, and `pdo` extensions
- Composer
- Node.js and npm (needed only to build the CSS and JavaScript)

## Local setup

```bash
composer install
npm install

cp .env.example .env
php artisan key:generate

php artisan migrate
npm run build
```

Create an admin account:

```bash
php artisan make:filament-user
```

Run the site:

```bash
php artisan serve
```

With Laravel Herd, the project is served automatically at `http://royal_frost.test`. Set `APP_URL` in `.env` to match the address you use.

For front-end development with live reload, run `npm run dev` in a second terminal.

## Pages and URLs

| Page | English | Arabic |
| --- | --- | --- |
| Home | `/en` | `/ar` |
| About Us | `/en/about` | `/ar/about` |
| Services | `/en/services` | `/ar/services` |
| Contact | `/en/contact` | `/ar/contact` |
| Admin dashboard | `/admin` | |

The root address `/` redirects to `/en`.

## Admin dashboard

Log in at `/admin` with the account created by `make:filament-user`. The sidebar group "Website content" contains:

- **Home page, About page, Services page, Contact page**: every text on the page, with an English tab and an Arabic tab
- **Header, footer and SEO**: navigation labels, footer text, contact details, and the page title and description used by search engines
- **Images**: an upload slot for every photo on the site, grouped by page

Changes go live as soon as they are saved. Only edited values are stored, so any text left untouched keeps its default from the language files. Lists that are tied to a layout or an image, such as the service cards and the case studies, can be edited but not added to or removed. Chips, tags, and regions can be added and removed.

To go back to an original image, clear its slot and save.

## How content is organised

- Default text lives in `lang/en/site.php` and `lang/ar/site.php`
- Edits made in the dashboard are stored in the `site_contents` table and merged over the defaults in `app/Support/Content.php`
- Replacement images are stored in `public/uploads/site` and tracked in the `site_images` table
- Views read images through the `site_image()` helper, which returns the uploaded replacement or the original from `public/images`

To add a new editable text, add it to both language files. It appears in the dashboard automatically.

## Contact form

Submissions are validated and emailed to the address in `CONTACT_TO`. Configure mail in `.env`:

```env
CONTACT_TO=info@yourdomain.com

MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="Royal Frost"
```

While `MAIL_MAILER=log` is set, messages are written to `storage/logs/laravel.log` instead of being sent.

## Project structure

```
app/
  Filament/Pages/       Admin pages (content editors and image manager)
  Http/Controllers/     PageController, ContactController
  Http/Middleware/      SetLocale (language from the URL)
  Models/               SiteContent, SiteImage
  Support/              Content (text merging), ImageOptimizer
  helpers.php           site_image() helper
lang/                   Default text, English and Arabic
resources/
  css/app.css           Design tokens, fonts, shared styles
  js/app.js             Menu, tabs, scroll reveal
  views/
    components/         Reusable Blade components
    layouts/ partials/  Page shell, header, footer
    pages/ sections/    The four pages and their sections
public/
  images/ icons/        Original design assets
  uploads/              Images uploaded from the dashboard
```

## Deploying to shared hosting (GoDaddy)

Shared hosting usually has no Node.js, so build the assets on your own machine first.

1. Run `composer install --no-dev --optimize-autoloader` and `npm run build` locally.
2. Upload the whole project, including `vendor/` and `public/build/`.
3. In the hosting control panel, select PHP 8.3 or newer.
4. Point the domain's document root at the `public` folder. If that is not possible, move the contents of `public` into `public_html` and update the paths in `index.php`.
5. Create a `.env` file on the server with at least:

   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://yourdomain.com
   ```

   Add the database settings (`DB_*`) and the mail settings shown above.
6. Run `php artisan migrate --force` and `php artisan make:filament-user`. If the host has no terminal, ask a developer to run them once or use the host's SSH or cron tools.
7. Make `storage/`, `bootstrap/cache/`, and `public/uploads/` writable (permissions 755 or 775).
8. If large image uploads fail, raise `upload_max_filesize` and `post_max_size` in the PHP settings.

Uploads are written directly to `public/uploads`, so no `storage:link` symlink is required.

## Useful commands

```bash
php artisan optimize:clear     # clear config, route, view, and application caches
npm run build                  # build production CSS and JavaScript
npm run dev                    # development server with live reload
```

If an edit made in the dashboard does not appear on the site, run `php artisan optimize:clear`.

## License

This is proprietary software built for Royal Frost. All rights reserved.
