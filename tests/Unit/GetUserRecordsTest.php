<?php

namespace Tests\Unit;

use App\Records;
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
    public function testUserRecords ()
    {

        $token = $this->user->NewUser();
        $user_id = $this->user->UserID();

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
        $records->assertStatus(200)->assertJson(
            []
        );
    }

    /**
     * User records empty
     */
    public function testUserRecordsEmpty ()
    {
        $token = $this->user->NewUser();

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
