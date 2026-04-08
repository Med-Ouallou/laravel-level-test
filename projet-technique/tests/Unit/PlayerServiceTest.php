<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Player;
use App\Models\Team;
use App\Services\PlayerService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlayerServiceTest extends TestCase
{
    use RefreshDatabase;

    protected PlayerService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new PlayerService();
    }

    public function test_it_can_get_all_players()
    {
        Player::factory()->count(3)->create();

        $result = $this->service->getAll();

        $this->assertEquals(3, $result->total());
    }

    public function test_it_can_filter_players_by_name()
    {
        Player::factory()->create(['name' => 'Lionel Messi']);
        Player::factory()->create(['name' => 'Cristiano Ronaldo']);

        $result = $this->service->getAll([
            'search' => 'Messi'
        ]);

        $this->assertEquals(1, $result->total());
    }

    public function test_it_can_filter_players_by_team()
    {
        $team = Team::factory()->create();
        $players = Player::factory()->count(2)->create();
        foreach($players as $player) {
            $player->teams()->attach($team->id);
        }

        $otherTeam = Team::factory()->create();
        $otherPlayer = Player::factory()->create();
        $otherPlayer->teams()->attach($otherTeam->id);

        $result = $this->service->getAll([
            'team_id' => $team->id
        ]);

        $this->assertEquals(2, $result->total());
    }

    public function test_it_can_update_a_player()
    {
        $player = Player::factory()->create();
        $newName = $player->name . ' Updated';

        $this->service->update($player, [
            'name' => $newName
        ]);

        $this->assertDatabaseHas('players', [
            'id' => $player->id,
            'name' => $newName
        ]);
    }

    public function test_it_can_delete_a_player()
    {
        $player = Player::factory()->create();

        $this->service->delete($player);

        $this->assertDatabaseMissing('players', [
            'id' => $player->id
        ]);
    }
}
