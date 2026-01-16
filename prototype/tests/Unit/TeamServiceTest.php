<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Team;
use App\Services\TeamService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TeamServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected TeamService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new TeamService();
    }

    public function test_it_can_get_all_teams()
    {
        // Arrange
        Team::create(['name' => 'Test Team', 'type' => 'Test Type']);

        // Act
        $teams = $this->service->getAllTeams();

        // Assert
        $this->assertGreaterThan(0, $teams->count());
    }
}
