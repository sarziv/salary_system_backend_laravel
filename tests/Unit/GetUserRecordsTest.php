<?php

namespace Tests\Unit;

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

    public function testUserRecords ()
    {
        //empty
    }
*/
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
