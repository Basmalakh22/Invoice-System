<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{

    public function index()
    {
        $sections = Sections::all();
        $products = Product::all();
        return view('products.products', compact('products', 'sections'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|max:255|unique:products',
            'section_id' => 'required|exists:sections,id',

        ], [
            'product_name.required' => 'يرجي ادخال اسم المنتج',
            'product_name.unique' => 'اسم المنتج مسجل مسبقا',
            'section_id.required' => 'يرجى اختيار القسم',
            'section_id.exists' => 'القسم المحدد غير موجود',
        ]);
        Product::create([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'section_id' => $request->section_id,
        ]);
        return Redirect::route('products.index')->with('Add', 'تم اضافة المنتج بنجاح');
    }


    public function show(Product $product)
    {
        //
    }


    public function edit(Product $product)
    {
        //
    }


    public function update(Request $request, Product $product)
    {
        //
    }


    public function destroy(Product $product)
    {
        //
    }
}
