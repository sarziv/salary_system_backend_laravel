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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = $request->user()->id;
        $records = Records::select('id', 'pallet', 'line', 'vip', 'extra_hour', 'created_at')
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->take(5)->get();

        return response()->json(
            $records
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'pallet' => 'required|integer',
            'line' => 'required|integer',
        ],[
            "pallet.required" =>"Pallet parameter is required.",
            "pallet.integer" =>"Pallet parameter must be a integer.",
            "line.required" =>"Line parameter is required.",
            "line.integer" =>"Line parameter must be a integer."
        ]);
        $user_id = $request->user()->id;
        $record = new Records([
            'user_id' => $user_id,
            'pallet' => $request->pallet,
            'line' => $request->line,
            'vip' => $request->vip,
            'extra_hour' => $request->extra_hour,
        ]);
        $record->save();

        return response()->json([
            'message' => 'Record successfully created!',
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Not in plans record should not be changed by user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = auth('api')->user()->id;
        if($user === null){
            return response()->json(["message" => "Unauthorized."],401);
        }
        $records = Records::find($id);
        if($records != null) {
            if ($user == $records->user_id) {
                $records->delete();
                return response()->json(["message" => "Deleted."],200);
            } else {
                return response()->json(["message" => "This record don't belong to you."],403);
            }
        }else{
            return response()->json(["message" => "Record do not exist."],404);
        }
    }

    /**
     * Search record for the current month.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function currentMonth(Request $request)
    {
        $request->validate([
            'year' => 'required|integer',
            'month' => 'required|integer',
        ],
            [
                'year.required' => 'Year parameter is required.',
                'year.integer' => 'Year parameter must be a integer.',
                'month.required' => 'Month parameter is required.',
                'month.integer' => 'Month parameter must be a integer.'
            ]);


        $user_id = $request->user()->id;

        $stat = DB::table('records')
            ->where('user_id', '=', $user_id)
            ->whereYear('created_at', "$request->year")
            ->whereMonth('created_at', "$request->month")
            ->select(
                DB::raw('count(id) as total_count'),
                DB::raw('SUM(pallet) as total_pallet'),
                DB::raw('SUM(line) as total_lines'),
                DB::raw('SUM(vip) as total_vip'),
                DB::raw('SUM(extra_hour) as total_extra_hour')
            )->get();

        return response()->json($stat, 200);
    }

    public function search(Request $request)
    {
        $request->validate([
            'from' =>
                [   'year' => 'required|integer',
                    'month' => 'required|integer',
                    'day' => 'required|integer',],
            'to' =>
                [   'year' => 'required|integer',
                    'month' => 'required|integer',
                    'day' => 'required|integer',],
        ],[
            "from.year.*"=>"Year paremeter required as integer.",
            "from.month.*"=>"Month paremeter required as integer.",
            "from.day.*"=>"Day paremeter required as integer.",
            "to.year.*"=>"Year paremeter required as integer.",
            "to.year.*"=>"Month paremeter required as integer.",
            "to.year.*"=>"Day paremeter required as integer.",
        ]);

        $user_id = $request->user()->id;
        $from = [
            $request->input('from.0.year').'-'.
            $request->input('from.0.month').'-'.
            $request->input('from.0.day')];
        $to = [
        $request->input('to.0.year').'-'.
        $request->input('to.0.month').'-'.
        $request->input('to.0.day')];
        $search = DB::table('records')
            ->where('user_id', '=', $user_id)
            ->whereBetween('created_at',[$from,$to])
            ->select('id','pallet','line','vip','extra_hour','created_at')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($search, 200);

    }

}
