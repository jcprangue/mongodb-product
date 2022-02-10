<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryDocument;
use App\Models\Documents;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $category = Category::find($request["id"]);

        $categoryDocument = CategoryDocument::with(['category', 'document'])
            ->where("category_id", $request["id"])
            ->orderBy('precedence')
            ->get()->map(function ($query) {
                return [
                    "id" => $query->id,
                    "category_id" => $query->category_id,
                    "document_id" => $query->document_id,
                    "name" => $query->document->name,
                ];
            });

        $documents = Documents::whereNotIn('id', $categoryDocument->pluck('document_id'))->get()->map(function ($query) use ($request) {
            return [
                "id" => $query->id,
                "category_id" => $request['id'],
                "document_id" => $query->id,
                "name" => $query->name,
            ];
        });


        return Inertia::render("CategoryDocument", [
            'category' => $category,
            'documents' => $documents,
            'categoryDocuments' => $categoryDocument
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $documents = $request->all();
        CategoryDocument::where('category_id', $id)->delete();
        foreach ($documents as $key => $document) {
            CategoryDocument::create([
                "category_id" => $id,
                "document_id" => $document["document_id"],
                "precedence" => $key + 1,
            ]);
        }

        return redirect(route('category-document.store', ["id" => $id]))->with('success', 'Document Field Successfully added');
    }
}
