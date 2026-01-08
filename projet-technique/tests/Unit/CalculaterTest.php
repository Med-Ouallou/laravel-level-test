<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\Calculater;

class CalculaterTest extends TestCase
{
    public function test_calculate_numbers()
    {
        $calculater = new Calculater();
        $resultat = $calculater->somme(5, 3);

        $this->assertEquals(8, $resultat);
    }
}
