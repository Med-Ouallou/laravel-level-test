# Player Management System

This project is a Laravel-based application for managing football players and their teams. It features a robust administrator dashboard with AJAX-powered interactions for a seamless user experience.

## Project Structure

The project follows the standard Laravel MVC (Model-View-Controller) architecture, with an additional **Service layer** to maintain clean controllers.

- **Models**: Located in `app/Models/`.
  - `Player`: Stores player info (name, score, image).
  - `Team`: Stores football teams categorized by type (Club/Country).
  - `User`: Manages administrative access.
- **Controllers**: Located in `app/Http/Controllers/`.
  - `AdminController`: The core of the admin panel. Handles searching, creating, editing, and deleting players.
- **Services**: Located in `app/Services/`.
  - `PlayerService`: Centralizes complex logic like image uploading and synchronizing many-to-many relationships (Player-Team).
- **Views**: Located in `resources/views/`.
  - Uses Tailwind CSS and Preline UI for a modern look.
  - `admin/players/index.blade.php`: The main dashboard.
  - `admin/players/partials/table.blade.php`: A fragment for AJAX table updates.

## Key Functions & Technical Details

### 1. AJAX Player Search
- **Where to look**: `AdminController@indexPlayers` & `resources/views/admin/players/index.blade.php`.
- **How it works**: As you type in the search bar, a JavaScript `input` event listener sends an asynchronous request to the server. The controller returns only the table HTML (the partial view), which JavaScript then injects into the list.

### 2. Add Player (Modal + AJAX)
- **Where to look**: `AdminController@storePlayer` & `PlayerService@store`.
- **How it works**: Players are added via a "pop-up" modal. The form is sent using `Axios`. If validation passes, the `PlayerService` saves the player and assigns teams. The UI refreshes instantly without a full page reload.

### 3. Image Upload Handling
- **Where to look**: `PlayerService@store`.
- **How it works**: Images are processed using Laravel's file storage. The service saves files to `storage/app/public/players` and stores a URL-friendly path in the database.
- **Important**: We ran `php artisan storage:link` to make these files accessible to the public browser.

### 4. Grouped Team Selection (Checkboxes)
- **Where to look**: `admin/players/index.blade.php` (Modal) and `edit.blade.php`.
- **How it works**: Teams are displayed as checkboxes grouped by their type (Clubs vs. Countries). This allows a player to belong to multiple teams easily (e.g., Messi belongs to Barcelona and the Argentine National Team).

### 5. Database Seeding from CSV
- **Where to look**: `database/seeders/PlayerSeeder.php` & `database/data/`.
- **How it works**: The system automatically populates itself using CSV data. The `PlayerSeeder` is advanced enough to parse multiple team names separated by a pipe (`|`) and link them to the player.

## Setup Instructions

1. **Install Dependencies**:
   ```bash
   composer install
   npm install
   ```
2. **Setup Environment**: Copy `.env.example` to `.env` and set your database.
3. **Migrate & Seed**:
   ```bash
   php artisan migrate --seed
   ```
4. **Link Storage**:
   ```bash
   php artisan storage:link
   ```
5. **Run the App**:
   ```bash
   php artisan serve
   npm run dev
   ```
