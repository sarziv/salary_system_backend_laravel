<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rate;

class RateController extends Controller
{
    /**
    * Rate Can only be updated
    */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rate = Rate::all();
        return response()->json($rate);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

}
