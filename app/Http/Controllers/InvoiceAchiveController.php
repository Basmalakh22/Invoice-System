<?php

namespace App\Http\Controllers;

use App\Models\InvoiceAchive;
use App\Models\Invoices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class InvoiceAchiveController extends Controller
{

    public function index()
    {
        $invoices = Invoices::onlyTrashed()->get();
        return view('invoices.Achive_invoices', compact('invoices'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit(InvoiceAchive $invoiceAchive)
    {
        //
    }


    public function update(Request $request,$id)
    {
        $id = $request->invoice_id;
        $flight = Invoices::withTrashed()->where('id', $id)->restore();

        session()->flash('restore_invoice');
        return redirect('/invoices');
    }


    public function destroy(Request $request)
    {
        $invoices = Invoices::withTrashed()->where('id',$request->invoice_id)->first();
        $invoices->forceDelete();

        session()->flash('delete_invoice');
        return redirect('/InvoiceAchive');
    }
}
