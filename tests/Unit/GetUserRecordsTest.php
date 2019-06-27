<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Tests\UserToken;

class GetUserRecordsTest extends TestCase
{

    protected $user;
    protected $url = 'http://salaryapi.local/api/user/records';

    public function __construct()
    {
        parent::__construct();
        $this->user = new UserToken();
    }
    /**
     * User records
    */
    public function test_UserRecords ()
    {

        $token = $this->user->UserToken();
        $user_id = $this->user->UserId();

        DB::table('records')->insert([
            'user_id'=>$user_id,
            'pallet'=>$user_id,
            'line'=>$user_id,
            'vip'=>$user_id,
            'extra_hour'=>$user_id,
    ]);
        $records = $this->withHeaders([
            'X-Header' => 'Value',
            'Authorization'=>'Bearer '. $token,
        ])->json('GET', $this->url);
        $records->assertStatus(200)->assertJsonStructure(
            [ "0" =>[
                "id",
                "pallet",
                "line",
                "vip",
                "extra_hour",
                "created_at"
                ]
            ]
        );
    }

    /**
     * User records empty
     */
    public function test_UserRecordsEmpty ()
    {
        $token = $this->user->UserToken();

        $records = $this->withHeaders([
            'X-Header' => 'Value',
            'Authorization'=>'Bearer '. $token,
        ])->json('GET', $this->url);

        //Empty record array
        $records->assertStatus(200)->assertJson(
            []
        );
    }


}
