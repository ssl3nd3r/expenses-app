
# Expenses Module for Laravel

## Overview
This project is a modular Expenses management API built using Laravel and the nwidart/laravel-modules package. It provides endpoints for creating, listing, updating, showing, and deleting expenses, with features such as resource formatting, event handling, notifications, and auto-generated API documentation using Scribe.

### Structure & Decisions
- **Modular Design:** All expense-related logic is encapsulated in the `Modules/Expenses` directory using the nwidart/laravel-modules package for separation of concerns and scalability.
- **Service Layer:** Business logic is handled in a dedicated service class (`ExpenseService`) to keep controllers thin and maintainable.
- **Repository Pattern:** Data access is abstracted for easier testing and future flexibility.
- **Resource & ResourceCollection:** API responses are formatted using Laravel resources for consistency.
- **Events & Notifications:** Creating an expense dispatches an event and sends a notification, demonstrating Laravel's event-driven capabilities.
- **Factory & Seeder:** Factories and seeders are used for generating realistic test data.
- **API Documentation:** Scribe is used for auto-generating OpenAPI/Swagger docs and a Postman collection, leveraging PHPDoc comments and validation rules.

### Setup Instructions
1. **Clone the repository**
2. **Install dependencies:**
   ```bash
   composer install
   ```
3. **Copy and configure your environment:**
   ```bash
   cp .env.example .env
   # Edit .env for your DB and mail settings
   ```
4. **Run migrations:**
   ```bash
   php artisan migrate
   ```
5. **Seed the database (optional):**
   ```bash
   php artisan module:seed Expenses
   ```
6. **Generate API documentation:**
   ```bash
   php artisan scribe:generate
   ```
7. **Serve the application:**
   ```bash
   php artisan serve
   ```
8. **View API docs:**
   - Visit [http://localhost:8000/docs](http://localhost:8000/docs)
   - Postman collection: `storage/app/private/scribe/collection.json`
   - OpenAPI spec: `storage/app/private/scribe/openapi.yaml`

### Assumptions Made
- The Expenses module is self-contained and does not depend on other modules.
- Expense categories are free-form strings (not a separate table).
- Authentication is not enforced on the Expenses endpoints by default, but can be added as needed.
- Notifications are sent to the currently authenticated user (if available) (I've used mailtrap.io for testing).
- The database is set up and accessible as configured in `.env`.

### Time Spent
- **Initial module setup, migrations, and model:** ~1 hour
- **Service, repository, controller, and resources:** ~1 hour
- **Events, notifications, and listeners:** ~45 minutes
- **Factory, seeder, and feature tests:** ~45 minutes
- **Scribe setup and documentation:** ~30 minutes
- **Debugging, config, and polish:** ~30 minutes

**Total:** ~4.5 hours
