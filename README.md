# Mobi Starter Theme

A lean WordPress starter that focuses on multilingual readiness, Advanced Custom Fields (ACF) integrations, and performance cleanups—leaving all front-end markup and styles for the project layer.

## Features
- Translation-ready by default with helpers that detect Polylang/WPML locales and expose them to theme logic.
- Automatic creation of locale-specific ACF options pages so global settings can be translated per language.
- Minimal templates with action hooks instead of markup, allowing each project to implement its own structure.
- Cache-busting helper for assets and opt-in enqueue logic so only the files you add are loaded.
- WordPress head cleanup routines that remove emojis, unused embeds, block styles, and other unnecessary requests.

## File Structure
- `style.css` – Theme metadata only; add project styles as required.
- `assets/` – Empty scaffolding for future CSS/JS. Files are only enqueued when present.
- `inc/i18n.php` – Locale detection, translation helpers, and ACF localisation settings.
- `inc/setup.php` – Theme supports, menus, and ACF option page registration.
- `inc/enqueue.php` – Handles stylesheet/script loading with cache-busting versions.
- `inc/cleanup.php` – Performance and cleanup tweaks (emoji removal, block CSS dequeue, etc.).
- Templates (`header.php`, `footer.php`, `index.php`) – Output the essentials and expose hooks for custom structures.

## Multilingual Workflow
1. Install your preferred multilingual plugin (Polylang or WPML). The theme will detect active locales automatically.
2. Extend `mobi_available_locales` if you need to register additional locales manually.
3. Use the generated locale-specific ACF options pages to store translatable global settings.
4. Hook into `mobi_before_loop`, `mobi_before_entry`, `mobi_after_entry`, `mobi_after_loop`, or `mobi_no_results` to render custom markup per language if required.

## Recommended Enhancements
- Generate a `.pot` file in `languages/` to translate theme strings in GlotPress or Poedit.
- Add PHPCS with WordPress coding standards to your CI pipeline for consistent code quality.
- Wire up a build tool (Vite, Laravel Mix, etc.) to compile and version project-specific CSS/JS when you add design work.
- Register custom image sizes in `inc/setup.php` and integrate a CDN or optimisation plugin for responsive imagery.
