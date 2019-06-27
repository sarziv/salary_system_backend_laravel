<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetRateTest extends TestCase
{

    protected $url = 'http://salaryapi.local/api/rate/all';

    /**
     * Get current rates
     *
     * @return void
     */
    public function test_GetRates()
    {
        $rates = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('GET', $this->url);
        //dd($rates);
        $rates->assertJsonStructure([
            "0" => [
                "id",
                "pallet",
                "lines",
                "vip",
                "extraHour",
            ]
        ]);
    }
}
