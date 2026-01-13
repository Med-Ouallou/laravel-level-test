<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Player;
use App\Models\Team;
use App\Services\PlayerService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PlayerServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected PlayerService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new PlayerService();
        // Ensure teams from CSV exist for tests that rely on them
        // In a real simplified structure running against a seeded DB, we assume data exists.
        // However, to be safe and match previous "use CSV" requirement, we can ensure seeding.
        // But DatabaseTransactions rolls back transactions, so if we seed inside, it's fine.
        $this->seed(\Database\Seeders\TeamSeeder::class);
        $this->seed(\Database\Seeders\PlayerSeeder::class); 
    }

    public function test_it_can_get_all_players()
    {
        $result = $this->service->getAll();

        $this->assertGreaterThan(0, $result->total());
    }

    public function test_it_can_filter_players_by_name()
    {
        $result = $this->service->getAll([
            'search' => 'Messi'
        ]);

        $this->assertGreaterThanOrEqual(1, $result->total());
    }

    public function test_it_can_filter_players_by_team()
    {
        $team = Team::where('name', 'Barcelona')->first();

        $result = $this->service->getAll([
            'team_id' => $team->id
        ]);

        $this->assertGreaterThan(0, $result->total());
    }

    public function test_it_can_update_a_player()
    {
        $player = Player::first();
        $originalName = $player->name;
        $newName = $originalName . ' Updated';

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
        $player = Player::first();

        $this->service->delete($player);

        $this->assertDatabaseMissing('players', [
            'id' => $player->id
        ]);
    }
}
