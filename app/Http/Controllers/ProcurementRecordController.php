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
use Illuminate\Support\Facades\Gate;
use App\Exports\ProcurementRecordExport;
use App\Models\ProcurementSystemLog;
use App\Models\UserLogProcurement;

class ProcurementRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
            
        abort_if(Gate::denies('view-procurement'), Response("You don't have the permission to perform this action"), '403 Forbidden');
        
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
        abort_if(Gate::denies('procurement-create'), Response("You don't have the permission to perform this action"), '403 Forbidden');

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
        abort_if(Gate::denies('procurement-create'), Response("You don't have the permission to perform this action"), '403 Forbidden');

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

        UserLogProcurement::create([
            'procurement_record_id' => $record->id,
            'user_id' => auth()->user()->id,
            'action' => 'Add new procurement'
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
        abort_if(Gate::denies('procurement-update'), Response("You don't have the permission to perform this action"), '403 Forbidden');
        $procurement = ProcurementRecord::find($id);
        $procurement->amount = (float) str_replace(',', '', $procurement->amount);
        return Inertia::render('Records/Edit', [
            "record" => $procurement,
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
        abort_if(Gate::denies('procurement-update'), Response("You don't have the permission to perform this action"), '403 Forbidden');

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

        UserLogProcurement::create([
            'procurement_record_id' => $record->id,
            'user_id' => auth()->user()->id,
            'action' => 'Update procurement'
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
        abort_if(Gate::denies('procurement-delete'), Response("You don't have the permission to perform this action"), '403 Forbidden');

        ProcurementRecord::find($id)->delete();

        ProcurementSystemLog::create([
            "procurement_id" => $id,
            "type" => "Delete",
            "key" => "delete_procurement",
            "message" => "User delete the procurement id " . $id,
            "data" => null
        ]);

        UserLogProcurement::create([
            'procurement_record_id' => $record->id,
            'user_id' => auth()->user()->id,
            'action' => 'Delete procurement'
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
