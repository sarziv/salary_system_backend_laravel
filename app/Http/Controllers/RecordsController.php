<?php

namespace App\Http\Controllers;

use App\Records;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RecordsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = $request->user()->id;
        $records = Records::select('id','pallet','lines','vip','extra_hour','created_at')
            ->where('user_id',$user_id)
            ->orderBy('created_at','desc')
            ->take(5)->get();

        return response()->json(
           $records
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'pallet' => 'required',
            'lines' => 'required',
        ]);
        $user_id = $request->user()->id;
        $record = new Records([
            'user_id'=>$user_id,
            'pallet'=>$request->pallet,
            'lines'=>$request->lines,
            'vip'=>$request->vip,
            'extra_hour'=>$request->extra_hour,
        ]);
        $record->save();

        return response()->json([
            'message' => 'Record successfully created!',
        ], 200);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
