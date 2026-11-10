# AI Instructions for ArioDevs

## Purpose

This file provides project-wide guidance for AI assistants working on the ArioDevs website and Laravel application.

## Project Structure

- Repository root: `F:/xampp/htdocs/ariodevs/server/public_html`
- Laravel application: `portfolio/laravel`
- Backend: Laravel 9.x, PHP constraint `^8.0.2`
- Frontend: React with JavaScript/JSX, bundled through the Laravel frontend toolchain
- Database: configured through Laravel `.env`; inspect the active connection before database work
- Main backend directories: `app/`, `config/`, `database/`, `routes/`, `resources/views/`
- Main frontend directories: `resources/js/`, `resources/css/`

## General Rules

1. Inspect the relevant existing files before editing.
2. Make the smallest complete change that solves the request.
3. Preserve existing behavior, routes, response shapes, styling, and naming conventions unless the user explicitly requests a breaking change.
4. Do not create duplicate models, controllers, tables, components, or configuration entries when an existing implementation can be extended.
5. Do not modify unrelated user changes or revert dirty working-tree changes.
6. Do not commit secrets, API tokens, passwords, private keys, or production data.
7. Never print secret values from `.env`; only report whether a value is configured or its length.
8. Use Windows paths for shell commands. Use forward slashes only in Markdown links.
9. Do not add dependencies unless an existing dependency cannot solve the requirement.
10. Keep comments short and only add them where the code is not self-explanatory.

## Laravel and PHP

- Confirm the installed Laravel and PHP versions from `composer.json`, `composer.lock`, and the available runtime before using version-specific APIs.
- This project currently targets Laravel 9 conventions. Do not upgrade Laravel or PHP as part of an unrelated task.
- Inspect routes, middleware, controllers, Form Requests, models, migrations, resources, and neighboring tests before changing backend behavior.
- Validate all external input server-side.
- Enforce authentication and authorization in middleware, policies, gates, or controllers; never rely on frontend checks alone.
- Use validated data for persistence and preserve model `$fillable` protections.
- Use transactions for multi-step writes where partial completion would be incorrect.
- Preserve existing API response formats and HTTP status conventions.
- Add reversible migrations for schema changes and inspect the real table structure first.
- Avoid N+1 queries and unbounded queries on public or administrative pages.
- Do not expose secrets or internal fields through public API responses.
- For URL fetching, consider SSRF protection, allowed schemes, DNS resolution, redirects, timeouts, response size limits, and rate limiting.

### Publication domain rules

- Reuse `App\\Models\\Publication` and the existing `publications` table.
- Preserve the React publication contract: `title`, `venue`, `category`, `desc`, `url`, `icon`, and `delay`.
- The public publication API is consumed by the existing React component; do not change that component merely to fit a backend response.
- Keep publication import authentication configured through `services.publication_import.token` and `.env` variable `PUBLICATION_IMPORT_TOKEN`.
- Protect publication administration routes with the existing publication-admin middleware.
- Confirm destructive publication actions before submitting them in views.

## React and Frontend

- Use plain JavaScript and JSX. Do not introduce TypeScript unless explicitly requested.
- Inspect `package.json`, build scripts, CSS setup, and nearby components before editing.
- Preserve existing component structure, props, translation behavior, animations, and responsive behavior.
- Do not rewrite finalized components when a backend or localized fix is sufficient.
- Use semantic HTML, accessible labels, keyboard-operable controls, and safe external-link attributes.
- Keep component-specific styles in the established colocated stylesheet/module pattern.
- Handle loading, error, empty, and success states for API-backed UI where relevant.
- Do not place secrets in frontend code or expose private API tokens through Vite variables.

## Dashboard and Administration

- Keep dashboard navigation consistent across dashboard, contact-request, and publication administration views.
- Reuse `resources/views/users/partials/sidebar.blade.php` instead of duplicating navigation markup.
- Preserve active navigation state and route names when adding dashboard pages.
- Protect mutating actions with CSRF tokens and the appropriate authentication middleware.

## Data and Testing

- Do not insert fake or test records into a production database unless the user explicitly requests it.
- If test data is requested, label it clearly and report the exact record created.
- Prefer focused tests for the changed behavior before running a full suite.
- Check commands in `composer.json` and `package.json` before choosing validation commands.
- Typical Laravel checks:
  - `php -l path\\to\\file.php`
  - `php artisan route:list`
  - `php artisan view:cache`
  - `php artisan test --filter=RelevantTest`
  - `vendor\\bin\\pint --test` when configured
- Verify API changes with realistic requests and inspect both HTTP responses and persisted database records.
- For visual changes, load the local site in a browser and inspect the affected page at desktop and mobile widths when practical.

## Git and Safety

- Inspect `git status --short` before editing.
- Do not use destructive commands such as `git reset --hard` or `git checkout --` unless explicitly approved.
- Do not amend commits unless explicitly requested.
- Keep commits focused and include the repository's required co-author trailer when creating commits.
- Report files changed, checks run, failures, and remaining uncertainty concisely.

## Completion Checklist

Before finishing a task:

- Confirm the requested behavior is implemented.
- Confirm existing contracts and frontend behavior remain compatible.
- Run the narrowest relevant validation.
- Check for accidental secret exposure.
- Check the final diff and working-tree status.
- Mention any unverified assumptions or environment limitations.
