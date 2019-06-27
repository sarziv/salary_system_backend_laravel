<?php

namespace Tests\Unit;

use Tests\TestCase;
use Tests\UserToken;

class GetUserStatisticTest extends TestCase
{

    protected $user;
    protected $url = 'http://salaryapi.local/api/user/statistic';

    public function __construct()
    {
        parent::__construct();
        $this->user = new UserToken();
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_GetUserStatistic()
    {
        $token = $this->user->UserToken();
        $data = ["year" => 2019, "month" => 6];
        $records = $this->withHeaders([
            'X-Header' => 'Value',
            'Authorization' => 'Bearer ' . $token,
        ])->json('POST', $this->url, $data);

        $records->assertStatus(200)->assertJsonStructure(
            ["0" => [
                "total_count",
                "total_pallet",
                "total_lines",
                "total_vip",
                "total_extra_hour",
            ]
            ]
        );
    }
    public function test_NotExistingUserStatistic()
    {
        $data = ["year" => 2019, "month" => 6];
        $records = $this->withHeaders([
            'X-Header' => 'Value',
            'Authorization' => 'Bearer ' . "Fake-token",
        ])->json('POST', $this->url, $data);

        $records->assertStatus(401)->assertJson([
                "message" => "Unauthenticated."
            ]
        );
    }
}
