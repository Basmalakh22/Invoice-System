@extends('layouts.master')
@section('css')
    <style>
        @media print {
            #print_Button {
                display: none;
            }
        }
    </style>
@endsection
@section('title')
    طباعه الفاتوره - برنامج الفواتير
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ طباعه الفاتوره</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-md-12 col-xl-12">
            <div class=" main-content-body-invoice">
                <div class="card card-invoice" id="print">
                    <div class="card-body">
                        <div class="invoice-header">
                            <h1 class="invoice-title">فاتوره تحصيل</h1>
                            <div class="billed-from">
                                <h6>{{ Auth::user()->name }}</h6>
                                {{ Auth::user()->email }}</p>
                            </div>
                        </div>
                        <div class="col-md">
                            <label class="tx-gray-600">معلومات الفاتوره</label>
                            <p class="invoice-info-row"><span>رقم الفاتوره</span>
                                <span>{{ $invoices->invoice_number }}</span>
                            </p>
                            <p class="invoice-info-row"><span>تاريخ الاصدار</span>
                                <span>{{ $invoices->invoice_Date }}</span>
                            </p>
                            <p class="invoice-info-row"><span>تاريخ الاستحقاق</span>
                                <span>{{ $invoices->Due_date }}</span>
                            </p>
                            <p class="invoice-info-row"><span>القسم</span>
                                <span>{{ $invoices->section->section_name }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="table-responsive mg-t-40">
                        <table class="table table-invoice border text-md-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th class="wd-20p">#</th>
                                    <th class="wd-40p">المنتج</th>
                                    <th class="tx-center">مبلغ التحصيل</th>
                                    <th class="tx-right">مبلغ العموله</th>
                                    <th class="tx-right">الاجمالي</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $invoices->id }}</td>
                                    <td class="tx-12">{{ $invoices->product }}</td>
                                    <td class="tx-center">${{ number_format((float) $invoices->Amount_collection, 2) }}</td>
                                    <td class="tx-right">${{ number_format((float) $invoices->Amount_Commission, 2) }}</td>
                                    @php
                                        $total = $invoices->Amount_collection + $invoices->Amount_Commission
                                    @endphp
                                    <td class="tx-right">${{ number_format((float) $total, 2) }}</td>
                                </tr>

                                <tr>
                                    <td class="valign-middle" colspan="2" rowspan="4">
                                        <div class="invoice-notes">
                                            <label class="main-content-label tx-13">#</label>
                                        </div>
                                    </td>
                                    <td class="tx-right">الاجمالي</td>
                                    <td class="tx-right" colspan="2">${{ number_format((float) $total, 2) }}</td>
                                </tr>
                                
                                <tr>
                                    <td class="tx-right">نسبه الضريبه</td>
                                    <td class="tx-right" colspan="2">{{ $invoices->Rate_VAT }}</td>
                                </tr>
                                <tr>
                                    <td class="tx-right tx-uppercase tx-bold tx-inverse">قيمه الخصم</td>
                                    <td class="tx-right" colspan="2">
                                        <h4 class="tx-primary tx-bold">{{ number_format((float)$invoices->Discount,2) }}</h4>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr class="mg-b-40">

                    <button class="btn btn-danger  float-left mt-3 mr-2" id="print_Button" onclick="printDiv()"> 
                        <i class="mdi mdi-printer ml-1"></i>طباعة
                    </button>

                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
@endsection
@section('js')
    <script type="text/javascript">
        function printDiv() {
            var printContents = document.getElementById('print').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }
    </script>
@endsection
