<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\Sections;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoicesController extends Controller
{

    public function index()
    {
        return view('invoices.invoices');
    }


    public function create()
    {
        $sections = Sections::all();
        return view('invoices.add_invoices', compact('sections'));
    }


    public function store(Request $request)
    {
        //
    }


    public function show(Invoices $invoices)
    {
        //
    }


    public function edit(Invoices $invoices)
    {
        //
    }


    public function update(Request $request, Invoices $invoices)
    {
        //
    }


    public function destroy(Invoices $invoices)
    {
        //
    }
    public function getProducts($id): JsonResponse
    {
        $products = DB::table('products')
            ->where('section_id', $id)
            ->pluck('product_name', 'id');

        if ($products->isEmpty()) {
            return response()->json(['message' => 'No products found for this section.'], 404);
        }

        return response()->json($products, 200);
    }
}
