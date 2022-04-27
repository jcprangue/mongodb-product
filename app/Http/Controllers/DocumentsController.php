<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;

class DocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('view-documents'), Response("You don't have the permission to perform this action"), '403 Forbidden');

        $search = $request['search'];
        $documents = Documents::when($request["search"] ?? null, function ($query, $search) {
            $query->where('name', 'like', "%$search%")
                ->orWhere('abbr', 'like', "%$search%");
        })->orderBy('created_at', 'ASC')->get();


        return Inertia::render("Document", [
            'filters' => $request->all('search'),
            'documents' => $documents
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        abort_if(Gate::denies('document-create'), Response("You don't have the permission to perform this action"), '403 Forbidden');

        return Inertia::render('Document/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('document-create'), Response("You don't have the permission to perform this action"), '403 Forbidden');

        Documents::create($request->validate([
            'name' => 'required',
            'abbr' => 'required',
        ]));
        return redirect(route('documents.index'))->with('success', 'Document Type Successfully Created');
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
    public function edit(Documents $documents, $id)
    {
        abort_if(Gate::denies('document-update'), Response("You don't have the permission to perform this action"), '403 Forbidden');

        return Inertia::render('Document/Edit', [
            'document' => Documents::find($id),
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
        abort_if(Gate::denies('document-update'), Response("You don't have the permission to perform this action"), '403 Forbidden');

        Documents::find($id)->update(
            $request->validate([
                'name' => 'required',
                'abbr' => 'required',
            ])
        );
        return redirect(route('documents.index'))->with('success', 'Document Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('document-delete'), Response("You don't have the permission to perform this action"), '403 Forbidden');

        $data = Documents::find($id)->delete();
        return redirect(route('documents.index'))->with('success', 'Document Successfully Deleted');
    }
}
