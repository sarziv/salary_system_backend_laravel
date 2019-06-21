<?php

namespace Tests\Unit;
use Tests\TestCase;
use Tests\UserToken;

class GetUserRecordsTest extends TestCase
{

    protected $token;
    protected $url = 'http://salaryapi.local/api/user/records';

    public function __construct()
    {
        parent::__construct();
        $UserToken = new UserToken();
        $this->token = $UserToken->Token();
    }
    /**
     * User records
     */
    public function testUserRecords ()
    {
        $records = $this->withHeaders([
            'X-Header' => 'Value',
            'Authorization'=>'Bearer '.$this->token,
        ])->json('GET', $this->url);

        dd($records);
    }

}
