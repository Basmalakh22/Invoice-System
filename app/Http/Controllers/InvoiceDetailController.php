<?php

namespace App\Http\Controllers;

use App\Models\InvoiceAttachment;
use App\Models\InvoiceDetail;
use App\Models\Invoices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

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
        $request->validate([
            'file_name' => 'required|file|mimes:pdf,jpeg,jpg,png|max:2048',
            'invoice_number' => 'required',
            'invoice_id' => 'required|exists:invoices,id',
        ]);

        $file = $request->file('file_name');
        $invoiceNumber = $request->invoice_number;

        // Define the path where you want to store the file
        $path = public_path('Attachments/' . $invoiceNumber);

        // Create the directory if it doesn't exist
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        // Move the uploaded file to the specified path
        $file->move($path, $file->getClientOriginalName());



        return redirect()->back()->with('Add', 'File uploaded successfully.');
    }


    public function show(InvoiceDetail $invoiceDetail)
    {
        //
    }


    public function edit($id)
    {
        $invoices = Invoices::where('id', $id)->first();
        $details  = InvoiceDetail::where('id_Invoice', $id)->get();
        $attachments  = InvoiceAttachment::where('invoice_id', $id)->get();

        if (!$invoices) {
            return redirect()->back()->with('error', 'Invoice not found.');
        }

        return view('invoices.details_invoice', compact('invoices', 'details', 'attachments'));
    }




    public function update(Request $request, InvoiceDetail $invoiceDetail)
    {
        //
    }


    public function destroy(Request $request, $id)
    {
        $invoices = InvoiceAttachment::findOrFail($id);
        $invoices->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number . '/' . $request->file_name);
        return Redirect::back()->with('delete', 'تم حذف المرفق بنجاح');
    }


}
