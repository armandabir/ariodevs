# Copilot instructions: Laravel/PHP and React/JavaScript

This repository uses Laravel 13 with PHP 8.3 or newer for backend work and React with JavaScript/JSX for frontend work. Confirm the project's Laravel 13 and PHP constraints, architecture, and installed tools before applying version-specific APIs or commands.

## Cost-conscious workflow
- Prefer the lowest-cost model in the current Copilot model picker that can reliably handle the task. Use a stronger model for difficult cross-stack debugging, security-sensitive changes, broad refactors, or architecture decisions. Model names and premium request costs change; do not hardcode them.
- Use one clear objective per Agent run. Inspect relevant code and configuration first; give a brief plan for non-trivial changes.
- Make the smallest complete change in the correct layer. Avoid unrelated refactors and new dependencies unless needed and explained.
- Run the narrowest relevant check first. Verify commands from `composer.json`, `package.json`, and project configuration. Report failures before retrying with a changed approach.
- Summarize behavior changed, files touched, checks actually run, and remaining uncertainty.

## Laravel/PHP backend
- Check `composer.json` and `composer.lock` for Laravel 13 and PHP constraints, then inspect route groups, middleware, controllers, Form Requests, policies, models, migrations, resources, and neighboring tests before editing. Laravel 13 requires PHP 8.3 and currently documents compatibility with PHP 8.3–8.5; stay within the documented range and the repository's Composer constraints. Keep the PHP runtime and dependencies patched; changing Laravel alone does not fix PHP vulnerabilities.
- Follow this repository's Laravel 13 conventions; use Laravel 13 APIs and configuration, and do not copy patterns from older versions without checking compatibility. Validate input and enforce authorization server-side, constrain mass assignment, and preserve API response/error conventions.
- Consider transactions for multi-step writes, query count for Eloquent relationships, pagination for large result sets, and reversible migrations when applicable.
- Add focused tests for relevant success, invalid input, unauthenticated/unauthorized behavior, and boundary cases using the existing framework and fixtures.

## Node.js and React/JavaScript frontend
- Check `package.json`, lockfile, `.nvmrc`/`.node-version`, Node `engines`, package-manager scripts, app framework, route/data-fetching/state patterns, Tailwind CSS setup/version, CSS Modules processing, and nearby components/tests before editing. Use a supported, patched Node.js LTS compatible with the project; preserve its package manager and lockfile.
- Tailwind CSS is required for styling. Every React component must have its own colocated CSS Module (for example, `Button.jsx` and `Button.module.css`). Import the module into the component and define local styles there using Tailwind utilities, preferably composed with `@apply` when the configured Tailwind pipeline supports it.
- Keep component styles out of global stylesheets, inline style objects, and long utility-class strings in JSX. Limit global CSS to Tailwind directives, resets, tokens, and truly global rules.
- Verify the installed Tailwind version and that the build pipeline processes CSS Modules and Tailwind directives together. If the current setup does not support the required pattern, explain the needed configuration and make the smallest compatible setup change.
- Write plain JavaScript and JSX. Do not introduce TypeScript, type annotations, interfaces, or `.ts`/`.tsx` files. Follow existing JavaScript conventions and use PropTypes only if the repository already uses them. Reuse local components and avoid unnecessary dependencies.
- Keep state close to its consumers and effects only for external synchronization. Handle loading, error, empty, and success states where relevant.
- Use semantic HTML, keyboard-operable controls, accessible names, and associated form labels/errors. Test user-visible behavior with the project's existing tools.
For Node runtime, dependency, package scripts, or security work, use the `nodejs-development` skill. For React UI work, use `react-feature`; Node.js powers its build, test, and Tailwind/CSS Modules toolchain.

## Cross-stack changes
- Keep contracts consistent across Laravel and React: request/response fields, validation errors, authentication/authorization assumptions, and loading/error states.
- Update both sides only when the requested behavior crosses the API boundary. Prefer existing API response contracts, Laravel resources, or shared schemas if the project already has them.
- Do not expose secrets, bypass backend authorization with frontend checks, or claim verification that was not run.












