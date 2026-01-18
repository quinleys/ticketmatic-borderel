# Ticketmatic Borderel

Laravel 12 + Livewire app that builds a borderel (sales by price type and totals) from Ticketmatic data. Developed on macOS with Herd.

## Requirements
- PHP 8.4+ with Composer 2
- Node.js 20+ with npm
- Ticketmatic credentials: `TICKETMATIC_API_URL`, `TICKETMATIC_API_ACCOUNT_NAME`, `TICKETMATIC_API_ACCESS_KEY`, `TICKETMATIC_API_SECRET_KEY`
- No database required

## Setup
1) Copy env and configure it:
   ```bash
   cp .env.example .env
   ```
   Fill the Ticketmatic keys and adjust `APP_URL` if needed. Sessions use files; queues run sync by default.
2) Install dependencies and build assets:
   ```bash
   composer install
   php artisan key:generate
   npm install
   npm run build
   ```

## Running locally
- Full stack (PHP server, queue listener, logs, Vite):
  ```bash
  composer run dev
  ```
- Or run the pieces yourself:
  ```bash
  php artisan serve
  npm run dev
  ```

## Tests and quality
- Run tests: `php artisan test --compact`
- Format PHP: `vendor/bin/pint --dirty`

## Production build
- Build assets: `npm run build`
- Optional cache warmup:
  ```bash
  php artisan config:clear route:clear view:clear
  php artisan config:cache route:cache view:cache
  ```

## How it works
- Ticketmatic SDK usage:
  - `Events::getlist` to list events
  - `Events::get` for a specific event
  - `Tools::queries` for aggregated sales (gross + fees per price type)
- `TicketmaticClient` wraps the SDK to expose only what is needed.
- `BorderelService` applies cost rules per price type and builds DTOs.
- Cost rules live in `config/borderel.php`.
- Livewire components render the DTOs for the UI.

## Project structure (key files)
- `app/Services/Ticketmatic/TicketmaticClient.php` — Ticketmatic wrapper.
- `app/Services/Borderel/BorderelService.php` — borderel business logic.
- `app/DTOs/Borderel/*` — transport objects for the UI.
- `app/Livewire/EventsList.php` and `app/Livewire/BorderelDetail.php` — pages/components.
- `config/borderel.php` — per-price-type cost percentages.

## Configuration notes
- Ensure all Ticketmatic env vars are set; `TICKETMATIC_API_URL` must match the target environment.
- If you change the queue driver, start the worker for that driver (current default is sync).
- Adjust `APP_URL` to match your local host (Herd uses `.test` by default).

## Possible next steps
- Add pagination and filtering on event listings.
- Extract repeated UI pieces into Blade components and add currency formatting helpers.
- Add feature tests around the borderel flow (including error handling for Ticketmatic outages).
- Add CI to run `php artisan test --compact` and `vendor/bin/pint --dirty`.
- Consider auth/authorization if exposing beyond internal use.
