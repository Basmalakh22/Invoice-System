<?php

namespace App\Http\Controllers;

use App\Exports\InvoicesExport;
use App\Models\InvoiceAttachment;
use App\Models\InvoiceDetail;
use App\Models\Invoices;
use App\Models\Sections;
use App\Models\User;
use App\Notifications\AddInvoice;
use App\Notifications\NewInvoiceAdded;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class InvoicesController extends Controller
{

    public function index()
    {
        $invoices = Invoices::all();
        return view('invoices.invoices', compact('invoices'));
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
            'Due_date' => $request->Due_date,
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
        // $user = User::first();
        // //$user->notify(new AddInvoice($invoice_id));       OR
        // Notification::send($user,new AddInvoice($invoice_id));

        $user = User::get(); // user who has added invoice
        $invoices = Invoices::latest()->first();
        Notification::send($user, new NewInvoiceAdded($invoices));

        return Redirect::route('invoices.index')->with('Add', 'تم اضافة الفاتورة بنجاح');
    }


    public function show(Invoices $invoices, $id)
    {
        $invoices = Invoices::findOrFail($id);
        return view('invoices.status_update', compact('invoices'));
    }


    public function edit($id)
    {
        $invoices = Invoices::findOrFail($id);
        $sections = Sections::all();
        
        return view('invoices.edit_invoice', compact('invoices', 'sections'));
    }


    public function update(Request $request, $id)
    {
        $invoices = Invoices::findOrFail($id);
        $invoices->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'note' => $request->note,
        ]);

        $attachments = InvoiceAttachment::where('invoice_id', $id);
        $details = InvoiceDetail::where('id_invoice', $id);

        $attachments->update(['invoice_number' => $request->invoice_number]);
        $details->update(['invoice_number' => $request->invoice_number]);

        return Redirect::route('invoices.index')->with('edit', 'تم تعديل الفاتورة بنجاح');
    }


    public function destroy(Request $request, $id)
    {
        $invoices = Invoices::findOrFail($id);
        $Details = InvoiceAttachment::where('invoice_id', $id)->first();
        $id_page = $request->id_page;

        if (!$id_page == 2) {
            if (!empty($Details->invoice_number)) {
                Storage::disk('public_uploads')->deleteDirectory($Details->invoice_number);
            }
            $invoices->forceDelete();

            return Redirect::route('invoices.index')->with('delete_invoice', 'تم حذف الفاتورة بنجاح');
        }else{
            $invoices->delete();
            return Redirect::route('InvoiceAchive.index')->with('archive_invoice', 'تم حذف الفاتورة بنجاح');

        }
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
    public function Status_Update(Request $request, $id)
    {
        $invoices = Invoices::findOrFail($id);

        if ($request->Status === 'مدفوعة') {

            $invoices->update([
                'Value_Status' => 1,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);

            InvoiceDetail::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 1,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        } else {
            $invoices->update([
                'Value_Status' => 3,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            InvoiceDetail::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 3,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }
        return Redirect::route('invoices.index')->with('Status_Update');
    }
    public function Invoice_paid()
    {
        $invoices = Invoices::where('Value_Status', 1)->get();
        return view('invoices.invoices_paid', compact('invoices'));
    }
    public function Invoice_unpaid()
    {
        $invoices = Invoices::where('Value_Status', 2)->get();
        return view('invoices.invoices_unpaid', compact('invoices'));
    }
    public function Invoice_partial()
    {
        $invoices = Invoices::where('Value_Status', 3)->get();
        return view('invoices.invoices_partial', compact('invoices'));
    }
    public function Print_invoice($id)
    {
        $invoices = invoices::where('id', $id)->first();
        return view('invoices.Print_invoices',compact('invoices'));
    }
    public function export()
    {
        return Excel::download(new InvoicesExport, 'invoices.xlsx');
    }

}
