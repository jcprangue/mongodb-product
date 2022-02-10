<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\Municipality;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BarangayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lgu_id = $request["id"];
        $search = $request['search'];
        $brgy = Barangay::when($request["id"] ?? null, function ($query, $lgu_id) {
            $query->where('citymun_id', $lgu_id);
        })->when($request["search"] ?? null, function ($query, $search) {
            $query->where('brgyDesc', 'like', "%$search%");
        })->orderBy('brgyDesc', 'ASC')->get();


        return Inertia::render("Barangay", [
            'filters' => $request->all('search'),
            'municipal' => Municipality::find($request->id),
            'barangays' => $brgy
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        return Inertia::render('Barangay/Create', ['municipal' => Municipality::find($id)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Barangay::create($request->validate([
            'brgyDesc' => 'required',
            'prov_id' => 'required',
            'citymun_id' => 'required',
        ]));
        return redirect(route('brgy.index', ["id" => $request->citymun_id]))->with('success', 'Barangay Successfully Created');
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
        $brgy = Barangay::find($id);
        return Inertia::render('Barangay/Edit', [
            'barangay' => $brgy,
            'municipal' => $brgy->municipal
        ]);
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
        Barangay::find($id)->update(
            $request->validate([
                'brgyDesc' => 'required',
                'prov_id' => 'required',
                'citymun_id' => 'required',
            ])
        );
        return redirect(route('brgy.index', ["id" => $request->citymun_id]))->with('success', 'Barangay Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brgy = Barangay::find($id);
        $municipal_id = $brgy->citymun_id;
        $brgy->delete();
        return redirect(route('brgy.index', ["id" => $municipal_id]))->with('success', 'Barangay Successfully Deleted');
    }
}
