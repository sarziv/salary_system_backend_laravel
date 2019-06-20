<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Records extends Model
{

    protected $fillable = [
        'pallet', 'lines', 'vip','extra_hour'
    ];

    public function userRecords(){
        return $this->belongsTo('App\User','user_id');
    }
}
