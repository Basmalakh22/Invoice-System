<?php

namespace App\Http\Controllers;

use App\Models\InvoiceAttachment;
use App\Models\Invoices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class InvoiceAttachmentController extends Controller
{

    public function index()
    {
        //
    }


    public function create($id)
    {
       
    }


    public function store(Request $request)
    {
        $request->validate([
            'file_name' => 'mimes:pdf,jpeg,png,jpg',
        ], [
            'file_name.mimes' => 'صيغة المرفق يجب ان تكون   pdf, jpeg , png , jpg',
        ]);

        $image = $request->file('file_name');
        $file_name = $image->getClientOriginalName();

        $attachments =  new InvoiceAttachment();
        $attachments->file_name = $file_name;
        $attachments->invoice_number = $request->invoice_number;
        $attachments->invoice_id = $request->invoice_id;
        $attachments->Created_by = Auth::user()->name;
        $attachments->save();

        // move pic
        $imageName = $request->file_name->getClientOriginalName();
        $request->file_name->move(public_path('Attachments/' . $request->invoice_number), $imageName);

        return Redirect::back()->with('Add', 'تم اضافة المرفق بنجاح');
    }


    public function show(InvoiceAttachment $invoiceAttachment)
    {
        //
    }


    public function edit(InvoiceAttachment $invoiceAttachment,$id)
    {
        $attachment = InvoiceAttachment::findOrFail($id);
        $invoices = Invoices::all();

        return view('invoices.details_update', compact('attachment'));
    }


    
    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'file_name' => 'required|file|mimes:pdf,jpeg,jpg,png|max:2048', // Adjust max size as needed
        ]);
    
        // Find the existing attachment
        $attachment = InvoiceAttachment::findOrFail($id);
    
        // Handle the file upload
        if ($request->hasFile('file_name')) {
            // Delete the old file if necessary
            if (File::exists(public_path('attachments/' . $attachment->file_name))) {
                File::delete(public_path('attachments/' . $attachment->file_name));
            }
    
            // Store the new file
            $file = $request->file('file_name');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('attachments'), $filename);
    
            // Update the attachment record
            $attachment->file_name = $filename;
        }
    
        $attachment->save();
    
        return redirect()->route('invoices.index')->with('edit', 'تم تحديث المرفق بنجاح');
    }
    



    public function destroy(InvoiceAttachment $invoiceAttachment)
    {
        //
    }
}
