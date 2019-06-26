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
            'pallet' => 'required',
            'line' => 'required',
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
                'year.required' => 'year is field required.',
                'year.integer' => 'year should be a number.',
                'month.required' => 'month is field required.',
                'month.integer' => 'month should be a ingeter.'
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
                [   'year' => 'required',
                    'month' => 'required',
                    'day' => 'required',],
            'to' =>
                [   'year' => 'required',
                    'month' => 'required',
                    'day' => 'required',],
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
