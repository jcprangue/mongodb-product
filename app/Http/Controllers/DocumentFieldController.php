<?php

namespace App\Http\Controllers;

use App\Models\DocumentField;
use App\Models\Documents;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DocumentFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $document = Documents::find($request["id"]);
        $documentFields = DocumentField::where("document_id", $request["id"])->orderBy('precedence')->get();


        return Inertia::render("DocumentField", [
            'filters' => $request->all('search'),
            'document' => $document,
            'fields' => $documentFields
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
