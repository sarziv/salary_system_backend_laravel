<?php

namespace App\Http\Controllers;

use App\Records;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $records = Records::select('id','pallet','line','vip','extra_hour','created_at')
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
            'line' => 'required',
        ]);
        $user_id = $request->user()->id;
        $record = new Records([
            'user_id'=>$user_id,
            'pallet'=>$request->pallet,
            'line'=>$request->line,
            'vip'=>$request->vip,
            'extra_hour'=>$request->extra_hour,
        ]);
        $record->save();

        return response()->json([
            'message' => 'Record successfully created!',
        ], 200);
    }

    public function currentMonth(Request $request)
    {
        $request->validate([
            'year' => 'required',
            'month' => 'required',
        ]);

        $user_id = $request->user()->id;

        $stat = DB::table('records')
            ->where('user_id', '=', $user_id)
            ->whereYear('created_at',$request->year)
            ->whereMonth('created_at',$request->month)
            ->select(
                DB::raw('count(id) as total_count'),
                DB::raw('SUM(pallet) as total_pallet'),
                DB::raw('SUM(line) as total_lines'),
                DB::raw('SUM(vip) as total_vip'),
                DB::raw('SUM(extra_hour) as total_extra_hour')
            )->get();
        
        return response()->json($stat);
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
