<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Municipality;
use App\Models\Office;
use App\Models\Signatory;
use App\Models\ProcurementRecord;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Excel;
use PDF;
use App\Exports\ProcurementRecordExport;
use App\Models\ProcurementSystemLog;

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
            $user = auth()->user();
            $tags = json_decode($user->tag);
            $procurement_records = ProcurementRecord::filter($request)->paginate(10)->withQueryString();
            return Inertia::render("Records", [
                'filters' => $request->all(),
                "categories" => Category::whereIN('id', $tags)->get(),
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
        $request['created_user_by_id'] = auth()->user()->id;
        $record = ProcurementRecord::create($request->validate([
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
            'created_user_by_id' => "required"

        ]));

        ProcurementSystemLog::create([
            "procurement_id" => $record->id,
            "type" => "Create",
            "key" => "create_procurement",
            "message" => "User create the procurement titled " . $record->project_name,
            "data" => json_encode($record)
        ]);

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
            "LGUs" => Municipality::with('barangay')->get(),
            "offices" => Office::all()
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
        $request['updated_user_by_id'] = auth()->user()->id;
        $record = ProcurementRecord::find($id)->update(
            $request->validate([
                'bid_opening_date' => 'required',
                'ib_number' => 'required',
                'project_name' => 'required',
                'contractor' => 'required',
                'category_id' => 'required',
                'lgu_id' => 'required',
                'office_id' => 'required',
                'barangay_id' => 'required',
                'amount' => 'required',
                'status' => 'nullable',
                'remarks' => 'nullable',
                'updated_user_by_id' => 'required',
            ])
        );

        ProcurementSystemLog::create([
            "procurement_id" => $id,
            "type" => "Update",
            "key" => "update_procurement",
            "message" => "User update the procurement titled " . $request->project_name,
            "data" => json_encode($request->all())
        ]);

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

        ProcurementSystemLog::create([
            "procurement_id" => $id,
            "type" => "Delete",
            "key" => "delete_procurement",
            "message" => "User delete the procurement id " . $id,
            "data" => null
        ]);

        return redirect(route('records.index'))->with('success', 'Record Successfully Deleted');
    }

    public function export(Request $request)
    {
        $category = Category::find($request->category);
        return Excel::download(new ProcurementRecordExport($category), 'P-' . date('Ymdhis') . '.xlsx');
    }

    public function pdf(Request $request)
    {
        $procurement_records = ProcurementRecord::filter($request)->get();
        $signatories = Signatory::where('is_visible', 1)->get();
        $values = [
            "count" => count($procurement_records),
            "signatory" => $signatories
        ];
        $pdf = PDF::loadView('exports.procurement-record-pdf', compact('procurement_records', 'values'))
            ->setPaper('a4', 'landscape');
        return $pdf->stream('sample.pdf');
        // return $pdf->download('P-' . date('Ymdhis') . '.pdf');
    }
}
