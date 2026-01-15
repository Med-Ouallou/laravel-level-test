# Technologies & Specifications for Laravel Project

## Technologies Used
- **Database**: MySQL.
- **Framework**: Laravel 12.

## Architecture
- **Pattern**: MVC with Service Layer (N-Tiers).
- **Models**: Data representation (Note, Category, User).
- **Services**: Centralized business logic (NoteService, CategoryService, BaseService).
- **Controllers**: Request/response management only, no business logic.

## Frontend
- **Tailwind CSS**: v4.0.0 (via Vite).
- **Preline UI**: UI Components.
- **Lucide**: Icons.
- **Blade**: Templates and components.

## Interactivity
- **AJAX**: Asynchronous requests for dynamic interactions (e.g., opening/closing modals, form submission).

## Features & Specifications
- **Media Management**: Image upload and storage for notes.
- **Internationalization (i18n)**: Support FR/EN (`lang/fr.json`, `lang/en.json`).

## Tests & Quality
- **Automated Tests**: `php artisan test`.
- **Test Data**: Complete Seeders (UserSeeder, CategorySeeder, NoteSeeder).
- **Test Strategy**: Use seeded data to validate business logic (NoteService, CategoryService) without creating ad-hoc data.

## Code Conventions
- **Language**: English for all code (classes, variables, comments).
