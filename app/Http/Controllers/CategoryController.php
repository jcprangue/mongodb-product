<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request['search'];
        $category = Category::when($request["search"] ?? null, function ($query, $search) {
            $query->where('name', 'like', "%$search%")
                ->orWhere('abbr', 'like', "%$search%");
        })->orderBy('created_at', 'ASC')->paginate(10);

        $category->transform(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'abbr' => $category->abbr,
                'parent_id' => $category->parent_id,
                'parent_category' => $category->parent_id ? $category->parent->abbr : null,
                'deleted_at' => $category->deleted_at
            ];
        });


        return Inertia::render("Category", [
            'filters' => $request->all('search'),
            'categories' => $category
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Category/Create', ['categories' => Category::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Category::create($request->validate([
            'name' => 'required',
            'abbr' => 'required',
            'parent_id' => 'nullable|exists:categories,id'
        ]));
        return redirect(route('category.index'))->with('success', 'Category Successfully Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return Inertia::render('Category/Edit', [
            'category' => $category,
            'categories' => Category::whereNotIn('id', [$category->id])->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $category->update(
            $request->validate([
                'name' => 'required',
                'abbr' => 'required',
                'parent_id' => 'nullable|exists:categories,id'
            ])
        );
        return redirect(route('category.index'))->with('success', 'Category Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect(route('category.index'))->with('success', 'Category Successfully Deleted');
    }
}
