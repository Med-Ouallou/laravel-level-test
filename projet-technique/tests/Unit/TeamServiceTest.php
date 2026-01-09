<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\TeamService;
use App\Models\Team;
use App\Models\User;

class TeamServiceTest extends TestCase
{
    protected TeamService $teamService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->teamService = new TeamService();
    }

    public function test_store_creates_team_successfully()
    {
        // Arrange: Create a user for the team
        $user = User::factory()->create();
        
        $teamData = [
            'name' => 'Test Team',
            'user_id' => $user->id,
            'type' => 'football'
        ];

        // Act: Create the team using the service
        $team = $this->teamService->store($teamData);

        // Assert: Verify the team was created
        $this->assertInstanceOf(Team::class, $team);
        $this->assertEquals('Test Team', $team->name);
        $this->assertEquals($user->id, $team->user_id);
        $this->assertEquals('football', $team->type);
        
        // Assert: Verify the team exists in the database
        $this->assertDatabaseHas('teams', [
            'name' => 'Test Team',
            'user_id' => $user->id,
            'type' => 'football'
        ]);
    }

    public function test_store_creates_team_with_minimal_data()
    {
        // Arrange: Create a user
        $user = User::factory()->create();
        
        $teamData = [
            'name' => 'Minimal Team',
            'user_id' => $user->id,
        ];

        // Act: Create the team
        $team = $this->teamService->store($teamData);

        // Assert: Verify the team was created
        $this->assertInstanceOf(Team::class, $team);
        $this->assertEquals('Minimal Team', $team->name);
        $this->assertDatabaseHas('teams', ['name' => 'Minimal Team']);
    }

    public function test_delete_removes_team_successfully()
    {
        // Arrange: Create a team
        $user = User::factory()->create();
        $team = Team::factory()->create([
            'name' => 'Team to Delete',
            'user_id' => $user->id
        ]);

        $teamId = $team->id;

        // Act: Delete the team using the service
        $this->teamService->delete($team);

        // Assert: Verify the team was deleted from the database
        $this->assertDatabaseMissing('teams', [
            'id' => $teamId,
            'name' => 'Team to Delete'
        ]);
    }

    public function test_delete_removes_team_with_players()
    {
        // Arrange: Create a team with players
        $user = User::factory()->create();
        $team = Team::factory()->create(['user_id' => $user->id]);
        
        // Create players and attach them to the team
        $player1 = \App\Models\Player::factory()->create(['user_id' => $user->id]);
        $player2 = \App\Models\Player::factory()->create(['user_id' => $user->id]);
        $team->players()->attach([$player1->id, $player2->id]);

        $teamId = $team->id;

        // Act: Delete the team
        $this->teamService->delete($team);

        // Assert: Verify the team was deleted
        $this->assertDatabaseMissing('teams', ['id' => $teamId]);
        
        // Assert: Verify the pivot table entries were removed
        $this->assertDatabaseMissing('player_team', ['team_id' => $teamId]);
        
        // Assert: Verify players still exist (only the relationship was removed)
        $this->assertDatabaseHas('players', ['id' => $player1->id]);
        $this->assertDatabaseHas('players', ['id' => $player2->id]);
    }
}
