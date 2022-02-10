<?php

namespace App\Http\Controllers;

use App\Models\CategoryDocument;
use App\Models\DocumentField;
use App\Models\ProcurementDetails;
use App\Models\ProcurementRecord;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProcurementDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $procurement_record = ProcurementRecord::with(['category'])->where("id", $request["id"])->first();

            return Inertia::render("RecordDetails", [
                "record" => $procurement_record,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        list($procurement_id, $categoryDocument_id) = explode("-", $id);
        $recordDetails = CategoryDocument::find($categoryDocument_id);
        $procurementRecord = ProcurementRecord::find($procurement_id);
        $fields = DocumentField::where('document_id', $recordDetails->document_id)->get();

        return Inertia::render("RecordDetails/Create", [
            "record" => $recordDetails,
            "fields" => $fields,
            "procurement" => $procurementRecord
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record = ProcurementDetails::find($id);
        $fields = DocumentField::where('document_id', $record->document_id)->get();
        return Inertia::render("RecordDetails/Edit", [
            "record" => ProcurementDetails::find($id),
            "fields" => $fields,
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
        ProcurementDetails::create($request->validate([
            'procurement_record_id' => 'required',
            'category_id' => 'required',
            'document_id' => 'required',
            'field_id' => 'required',
            'data' => 'required',
            'remarks' => 'nullable',

        ]));
        return redirect(route('records-details.index', ["id" => $request->procurement_record_id]))->with('success', 'Procurement Details Successfully Created');
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
        ProcurementDetails::find($id)->update(
            $request->validate([
                'procurement_record_id' => 'required',
                'category_id' => 'required',
                'document_id' => 'required',
                'field_id' => 'required',
                'data' => 'required',
                'remarks' => 'nullable',
            ])
        );
        return redirect(route('records-details.index', ["id" => $request->procurement_record_id]))->with('success', 'Procurement Details Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = ProcurementDetails::find($id);
        $procurement_id = $data->procurement_record_id;
        $data->delete();
        return redirect(route('records-details.index', ["id" => $procurement_id]))->with('success', 'Procurement Details Successfully Deleted');
    }


    public function listDetails(Request $request)
    {
        return ProcurementDetails::with(['field'], function ($query) {
            $query->orderBy('precedence', 'ASC');
        })->where('procurement_record_id', $request->procurement_record_id)
            ->where('category_id', $request->category_id)
            ->where('document_id', $request->document_id)
            ->get();
    }

    public function headerList(Request $request)
    {
        return DocumentField::where('document_id', $request->document_id)->get();
    }
}
