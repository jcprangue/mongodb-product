<?php

namespace App\Http\Controllers;

use App\Models\Municipality;
use App\Models\Province;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;

class LGUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('view-lgu'), Response("You don't have the permission to perform this action"), '403 Forbidden');

        $search = $request['search'];
        $municipalities = Municipality::when($request["search"] ?? null, function ($query, $search) {
            $query->where('lgus', 'like', "%$search%");
        })->orderBy('created_at', 'ASC')->get();


        return Inertia::render("Municipality", [
            'filters' => $request->all('search'),
            'municipalities' => $municipalities
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('lgu-create'), Response("You don't have the permission to perform this action"), '403 Forbidden');

        return Inertia::render('Municipality/Create', ['municipalities' => Province::find(1)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('lgu-create'), Response("You don't have the permission to perform this action"), '403 Forbidden');

        Municipality::create($request->validate([
            'lgus' => 'required',
            'prov_id' => 'required',
        ]));
        return redirect(route('LGUs.index'))->with('success', 'Municipal Successfully Created');
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
    public function edit(Municipality $municipality, $id)
    {
        abort_if(Gate::denies('lgu-update'), Response("You don't have the permission to perform this action"), '403 Forbidden');

        return Inertia::render('Municipality/Edit', [
            'municipality' => Municipality::find($id),
            'province' => Province::find(1)
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
        abort_if(Gate::denies('lgu-update'), Response("You don't have the permission to perform this action"), '403 Forbidden');

        Municipality::find($id)->update(
            $request->validate([
                'lgus' => 'required',
                'prov_id' => 'required',
            ])
        );
        return redirect(route('LGUs.index'))->with('success', 'Municipal Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Municipality $municipality, $id)
    {

        abort_if(Gate::denies('lgu-delete'), Response("You don't have the permission to perform this action"), '403 Forbidden');

        Municipality::find($id)->delete();
        return redirect(route('LGUs.index'))->with('success', 'LGU Successfully Deleted');
    }
}
