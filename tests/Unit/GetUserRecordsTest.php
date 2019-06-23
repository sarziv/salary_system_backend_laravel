<?php

namespace Tests\Unit;

use Tests\TestCase;
use Tests\UserToken;

class GetUserRecordsTest extends TestCase
{

    protected $User;
    protected $url = 'http://salaryapi.local/api/user/records';

    public function __construct()
    {
        parent::__construct();
        $this->User = new UserToken();
    }
    /**
     * User records
     */
    public function testUserRecordsNoRecords ()
    {
        $Token = $this->User->NewUser();

        $records = $this->withHeaders([
            'X-Header' => 'Value',
            'Authorization'=>'Bearer '. $Token,
        ])->json('GET', $this->url);

        $records->assertStatus(200)->assertJson(
            []
        );
    }

}
