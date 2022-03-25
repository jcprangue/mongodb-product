<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Municipality;
use App\Models\Office;
use App\Models\ProcurementRecord;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Excel;
use App\Exports\ProcurementRecordExport;

class ProcurementRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $procurement_records = ProcurementRecord::filter($request)->paginate(10)->withQueryString();

            return Inertia::render("Records", [
                'filters' => $request->all(),
                "categories" => Category::all(),
                "records" => $procurement_records,
                "LGUs" => Municipality::with('barangay')->get(),
                "offices" => Office::all()

            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Records/Create', [
            "categories" => Category::all(),
            "offices" => Office::all(),
            "LGUs" => Municipality::with('barangay')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ProcurementRecord::create($request->validate([
            'bid_opening_date' => 'required',
            'ib_number' => 'required',
            'project_name' => 'required',
            'contractor' => 'required',
            'category_id' => 'required',
            'office_id' => 'nullable',
            'lgu_id' => 'nullable',
            'barangay_id' => 'nullable',
            'amount' => 'required',
            'status' => 'nullable',
            'remarks' => 'nullable',

        ]));
        return redirect(route('records.index'))->with('success', 'Procurement Records Successfully Created');
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
        return Inertia::render('Records/Edit', [
            "record" => ProcurementRecord::find($id),
            "categories" => Category::all(),
            "LGUs" => Municipality::with('barangay')->get()
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
        ProcurementRecord::find($id)->update(
            $request->validate([
                'bid_opening_date' => 'required',
                'ib_number' => 'required',
                'project_name' => 'required',
                'contractor' => 'required',
                'category_id' => 'required',
                'lgu_id' => 'required',
                'barangay_id' => 'required',
                'amount' => 'required',
                'status' => 'nullable',
                'remarks' => 'nullable',
            ])
        );
        return redirect(route('records.index'))->with('success', 'Procurement record Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ProcurementRecord::find($id)->delete();
        return redirect(route('records.index'))->with('success', 'Record Successfully Deleted');
    }

    public function export(Request $request)
    {
        $category = Category::find($request->category);
        return Excel::download(new ProcurementRecordExport($category), 'P-' . date('Ymdhis') . '.xlsx');
    }
}
