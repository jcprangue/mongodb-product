<?php

namespace App\Http\Controllers;

use App\Models\DocumentField;
use App\Models\Documents;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;

class DocumentFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('view-document-field'), Response("You don't have the permission to perform this action"), '403 Forbidden');

        $document = Documents::find($request["id"]);
        $documentFields = DocumentField::where("document_id", $request["id"])->orderBy('precedence')->get();


        return Inertia::render("DocumentField", [
            'filters' => $request->all('search'),
            'document' => $document,
            'fields' => $documentFields
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return DocumentField::find($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('document-field-create'), Response("You don't have the permission to perform this action"), '403 Forbidden');
        if (empty($request->id)) {
            DocumentField::create($request->validate([
                'field_name' => 'required',
                'field_type' => 'required',
                'document_id' => 'required',
            ]));
        } else {
            DocumentField::find($request->id)->update(
                $request->validate([
                    'field_name' => 'required',
                    'field_type' => 'required',
                    'document_id' => 'required',
                ])
            );
        }

        return redirect(route('field.index', ["id" => $request->document_id]))->with('success', 'Document Field Successfully added');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('document-field-delete'), Response("You don't have the permission to perform this action"), '403 Forbidden');

        $data = DocumentField::find($id);
        $documentId = $data->document_id;
        $data->delete();
        return redirect(route('field.index', ["id" => $documentId]))->with('success', 'Field Successfully Deleted');
    }

    public function updateOrder(Request $request)
    {

        $fields = $request->all();
        foreach ($fields as $key => $row) {
            $key = $key + 1;
            DocumentField::find($row['id'])->update([
                "precedence" => $key
            ]);
        }

        return redirect(route('field.index', ["id" => $fields[0]["document_id"]]))->with('success', 'Successfully Update');
    }
}
