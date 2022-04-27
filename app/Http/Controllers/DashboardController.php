<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ProcurementRecord;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DateTime;
use DatePeriod;
use DateInterval;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $year = date('Y');
        $from = date('Y-m-d', strtotime($year . '-01'));
        $to =  date('Y-m-d', strtotime($year . '-12'));
        if (isset($request["data"])) {
            $from = date('Y-m-d', strtotime($request["data"]["month_from"]));
            $to = date('Y-m-d', strtotime($request["data"]["month_to"]));
        }
        $data = [
            "categories" => Category::with('procurementRecords')->get(),
            "date" => [
                "from" => $from,
                "to" => $to
            ],
            "auth" => auth()->user()->roles->pluck('name')
        ];
        return Inertia::render('Dashboard', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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


    public function getCategoryChart(Request $request)
    {
        $period = CarbonPeriod::create($request->month_from, '1 month', $request->month_to);
        $months = [];
        foreach ($period as $dt) {
            $date_format = $dt->format("Y-m");
            $records = ProcurementRecord::where('bid_opening_date', 'LIKE', $date_format . '%')->get();

            $months[] = $date_format;
            $dataSets[] = count($records);
        }

        return [
            "months" => $months,
            "count" => $dataSets,
        ];
    }
}
