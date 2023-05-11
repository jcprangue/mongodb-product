<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Controller;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::filter($request)->paginate(10)->withQueryString();
        return Inertia::render("Product", [
            'filters' => $request->all(),
            "records" => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Inertia::render("Product/Show", [
            "records" => Product::find($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        
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
        $record = Product::find($id)->update([
            "title" => $request->title,
            "quantity" => $request->quantity,
            "ingredient" => $request->ingredient,
        ]);

        return $record ? "Success" : "Failed";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function chart(){
        $products = Product::limit(30)->get();
        foreach ($products as $key => $product) {
            $productList[] = $product["title"];
            $quantity[] = $product["quantity"];
        }
       
        return Inertia::render("Chart/index",[
            "product" => $productList,
            "quantity" => $quantity,
        ]);
    }
  
}
