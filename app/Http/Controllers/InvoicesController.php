<?php

namespace App\Http\Controllers;

use App\Models\InvoiceAttachment;
use App\Models\InvoiceDetail;
use App\Models\Invoices;
use App\Models\Sections;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

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
        Invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
        ]);
        // to save the requests in invoice_details
        $invoice_id = invoices::latest()->first()->id;
        InvoiceDetail::create([
            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        if ($request->hasFile('pic')) {
            $image = $request->file('pic');
            if (!$image) {
                return back()->with('error', 'Image file not found');
            }

            $invoice_id = Invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new InvoiceAttachment();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }
        return Redirect::route('invoices.index')->with('Add', 'تم اضافة الفاتورة بنجاح');
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
