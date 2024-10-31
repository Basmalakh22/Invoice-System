<?php

namespace App\Http\Controllers;

use App\Models\InvoiceAttachment;
use App\Models\InvoiceDetail;
use App\Models\Invoices;
use Illuminate\Http\Request;

class InvoiceDetailController extends Controller
{

    public function index()
    {

    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }

    public function show(InvoiceDetail $invoiceDetail)
    {
        //
    }


    public function edit($id)
    {
        $invoices = Invoices::where('id',$id)->first();
        $details  = InvoiceDetail::where('id_Invoice',$id)->get();
        $attachments  = InvoiceAttachment::where('invoice_id',$id)->get();
        
        if (!$invoices) {
            return redirect()->back()->with('error', 'Invoice not found.');
        }
    
        return view('invoices.details_invoice',compact('invoices','details','attachments'));
    }
    



    public function update(Request $request, InvoiceDetail $invoiceDetail)
    {
        //
    }


    public function destroy(InvoiceDetail $invoiceDetail)
    {
        //
    }
}
