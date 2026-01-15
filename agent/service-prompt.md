# Service Strategy (Business Logic)
This document outlines the business logic encapsulated within the application's services.

## 1. PlayerService (`App\Services\PlayerService`)
Inherits from `BaseService`. Handles all complex CRUD operations for players, including media management and relationships.

### `getPlayers(?string $search, ?int $teamId, ?int $perPage)`
- Retrieves paginated players.
- **Filtering**: Search by term (`search`) on: `name`, `content`, or owner's name (`user.name`).
- **Team Filtering**: Filter by `teamId` via the `teams` relation.
- **Eager Loading**: `user`, `teams`.

### `getPlayer(int $id)`
- Retrieves a player by ID with its relations (`user`, `teams`).
- Throws an exception if not found (`findOrFail`).

### `createPlayer(array $data)`
- Persists a new player in the database.
- **Fields**: `name`, `content`, `user_id` (Auth or fallback), `image`.
- **Relationships**: Synchronizes teams (`team_ids`).

### `createPlayerWithImage(array $data, $imageFile)`
- Wrapper for `createPlayer`.
- If `$imageFile` is present: uploads the file to `public/players` and adds the path to the dataset.

### `updatePlayer(int $id, array $data)`
- Updates an existing player.
- Only updates the `image` if provided in `$data`.
- Syncs teams if `team_ids` is present.

### `updatePlayerWithImage(int $id, array $data, $imageFile)`
- Wrapper for `updatePlayer`.
- If a new `$imageFile` is provided: deletes the old image (if it exists) and uploads the new one.

### `deletePlayer(int $id)`
- Detaches team relationships (`detach`).
- Removes the player record from the database.

### `deletePlayerWithImage(int $id)`
- Wrapper for `deletePlayer`.
- Deletes the associated image file from public storage before removing the database record.

---

## 2. TeamService (`App\Services\TeamService`)
Inherits from `BaseService`.

### `getAllTeams()`
- Retrieves all teams from the database (`Team::all()`).
