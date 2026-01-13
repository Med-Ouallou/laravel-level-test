<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\PlayerService;
use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PlayerServiceTest extends TestCase
{
    protected PlayerService $playerService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->playerService = new PlayerService();
        
        // Fake the storage to avoid actual file operations
        Storage::fake('public');
    }

    public function test_store_creates_player_without_image()
    {
        // Arrange: Create a user
        $user = User::factory()->create();
        
        $playerData = [
            'name' => 'John Doe',
            'score' => 100,
            'user_id' => $user->id,
        ];

        // Act: Create the player
        $player = $this->playerService->store($playerData);

        // Assert: Verify the player was created
        $this->assertInstanceOf(Player::class, $player);
        $this->assertEquals('John Doe', $player->name);
        $this->assertEquals(100, $player->score);
        $this->assertEquals($user->id, $player->user_id);
        
        // Assert: Verify the player exists in the database
        $this->assertDatabaseHas('players', [
            'name' => 'John Doe',
            'score' => 100,
            'user_id' => $user->id
        ]);
    }

    public function test_store_creates_player_with_image()
    {
        // Arrange: Create a user and fake image
        $user = User::factory()->create();
        $fakeImage = UploadedFile::fake()->create('player.jpg');
        
        $playerData = [
            'name' => 'Jane Smith',
            'score' => 85,
            'user_id' => $user->id,
            'image' => $fakeImage
        ];

        // Act: Create the player with image
        $player = $this->playerService->store($playerData);

        // Assert: Verify the player was created
        $this->assertInstanceOf(Player::class, $player);
        $this->assertEquals('Jane Smith', $player->name);
        $this->assertNotNull($player->image);
        $this->assertStringStartsWith('players/', $player->image);
        
        // Assert: Verify the image was stored
        $imagePath = $player->image;
        Storage::disk('public')->assertExists($imagePath);
    }

    public function test_store_creates_player_with_teams()
    {
        // Arrange: Create user and teams
        $user = User::factory()->create();
        $team1 = Team::factory()->create();
        $team2 = Team::factory()->create();
        
        $playerData = [
            'name' => 'Team Player',
            'score' => 90,
            'user_id' => $user->id,
            'teams' => [$team1->id, $team2->id]
        ];

        // Act: Create the player with teams
        $player = $this->playerService->store($playerData);

        // Assert: Verify the player was created
        $this->assertInstanceOf(Player::class, $player);
        $this->assertEquals('Team Player', $player->name);
        
        // Assert: Verify the teams are associated
        $this->assertCount(2, $player->teams);
        $this->assertTrue($player->teams->contains($team1));
        $this->assertTrue($player->teams->contains($team2));
        
        // Assert: Verify pivot table entries
        $this->assertDatabaseHas('player_team', [
            'player_id' => $player->id,
            'team_id' => $team1->id
        ]);
        $this->assertDatabaseHas('player_team', [
            'player_id' => $player->id,
            'team_id' => $team2->id
        ]);
    }

    public function test_update_updates_player_without_image()
    {
        // Arrange: Create a player
        $user = User::factory()->create();
        $player = Player::factory()->create([
            'name' => 'Original Name',
            'score' => 50,
            'user_id' => $user->id
        ]);

        $updateData = [
            'name' => 'Updated Name',
            'score' => 75
        ];

        // Act: Update the player
        $updatedPlayer = $this->playerService->update($player, $updateData);

        // Assert: Verify the player was updated
        $this->assertEquals('Updated Name', $updatedPlayer->name);
        $this->assertEquals(75, $updatedPlayer->score);
        
        // Assert: Verify database was updated
        $this->assertDatabaseHas('players', [
            'id' => $player->id,
            'name' => 'Updated Name',
            'score' => 75
        ]);
    }

    public function test_update_updates_player_with_new_image()
    {
        // Arrange: Create a player with existing image
        $user = User::factory()->create();
        $player = Player::factory()->create([
            'name' => 'Player With Image',
            'user_id' => $user->id,
            'image' => '/storage/players/old-image.jpg'
        ]);

        $newImage = UploadedFile::fake()->create('new-player.jpg');
        $updateData = [
            'name' => 'Player With Image',
            'image' => $newImage
        ];

        // Act: Update the player with new image
        $updatedPlayer = $this->playerService->update($player, $updateData);

        // Assert: Verify the image was updated
        $this->assertNotNull($updatedPlayer->image);
        $this->assertStringStartsWith('players/', $updatedPlayer->image);
        $this->assertNotEquals('/storage/players/old-image.jpg', $updatedPlayer->image);
        
        // Assert: Verify new image was stored
        $imagePath = $updatedPlayer->image;
        Storage::disk('public')->assertExists($imagePath);
    }

    public function test_update_updates_player_teams()
    {
        // Arrange: Create player with initial teams
        $user = User::factory()->create();
        $player = Player::factory()->create(['user_id' => $user->id]);
        $team1 = Team::factory()->create();
        $team2 = Team::factory()->create();
        $team3 = Team::factory()->create();
        
        // Attach initial teams
        $player->teams()->attach([$team1->id, $team2->id]);

        // Act: Update player with different teams
        $updateData = [
            'name' => $player->name,
            'teams' => [$team2->id, $team3->id] // Keep team2, remove team1, add team3
        ];
        $updatedPlayer = $this->playerService->update($player, $updateData);

        // Assert: Verify teams were synced correctly
        $this->assertCount(2, $updatedPlayer->teams);
        $this->assertFalse($updatedPlayer->teams->contains($team1));
        $this->assertTrue($updatedPlayer->teams->contains($team2));
        $this->assertTrue($updatedPlayer->teams->contains($team3));
        
        // Assert: Verify pivot table
        $this->assertDatabaseMissing('player_team', [
            'player_id' => $player->id,
            'team_id' => $team1->id
        ]);
        $this->assertDatabaseHas('player_team', [
            'player_id' => $player->id,
            'team_id' => $team2->id
        ]);
        $this->assertDatabaseHas('player_team', [
            'player_id' => $player->id,
            'team_id' => $team3->id
        ]);
    }

    public function test_delete_removes_player_successfully()
    {
        // Arrange: Create a player
        $user = User::factory()->create();
        $player = Player::factory()->create([
            'name' => 'Player to Delete',
            'user_id' => $user->id
        ]);

        $playerId = $player->id;

        // Act: Delete the player
        $this->playerService->delete($player);

        // Assert: Verify the player was deleted
        $this->assertDatabaseMissing('players', [
            'id' => $playerId,
            'name' => 'Player to Delete'
        ]);
    }

    public function test_delete_removes_player_and_team_relationships()
    {
        // Arrange: Create a player with teams
        $user = User::factory()->create();
        $player = Player::factory()->create(['user_id' => $user->id]);
        $team1 = Team::factory()->create();
        $team2 = Team::factory()->create();
        
        $player->teams()->attach([$team1->id, $team2->id]);
        $playerId = $player->id;

        // Act: Delete the player
        $this->playerService->delete($player);

        // Assert: Verify the player was deleted
        $this->assertDatabaseMissing('players', ['id' => $playerId]);
        
        // Assert: Verify pivot table entries were removed
        $this->assertDatabaseMissing('player_team', ['player_id' => $playerId]);
        
        // Assert: Verify teams still exist
        $this->assertDatabaseHas('teams', ['id' => $team1->id]);
        $this->assertDatabaseHas('teams', ['id' => $team2->id]);
    }
}
