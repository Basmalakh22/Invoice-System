@extends('layouts.master')
@section('title')
    تفاصيل المنتجات - برنامج الفواتير
@endsection
@section('css')
    <!---Internal  Prism css-->
    <link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
    <!---Internal Input tags css-->
    <link href="{{ URL::asset('assets/plugins/inputtags/inputtags.css') }}" rel="stylesheet">
    <!--- Custom-scroll -->
    <link href="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">قائمه الفواتير</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل المنتجات</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <!-- div -->
            <div class="card mg-b-20" id="tabs-style2">
                <div class="card-body">
                    <div class="text-wrap">
                        <div class="example">
                            <div class="panel panel-primary tabs-style-2">
                                <div class="tab-menu-heading">
                                    <div class="tabs-menu1">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs main-nav-line">
                                            <li><a href="#tab4" class="nav-link active" data-toggle="tab">معلومات الفاتوره</a></li>
                                            <li><a href="#tab5" class="nav-link" data-toggle="tab">حالات الدفع</a></li>
                                            <li><a href="#tab6" class="nav-link" data-toggle="tab">المرفقات</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body main-content-body-right border">
                                    <div class="tab-content">
                                        <!-- Invoice Information Tab -->
                                        <div class="tab-pane active" id="tab4">
                                            <div class="table-responsive mt-15">
                                                <table class="table table-striped text-center">
                                                    <thead>
                                                        <tr>
                                                            <th>رقم الفاتوره</th>
                                                            <th>تاريخ الاصدار</th>
                                                            <th>تاريخ الاستحقاق</th>
                                                            <th>المنتج</th>
                                                            <th>القسم</th>
                                                            <th>مبلغ التحصيل</th>
                                                            <th>مبلغ العمولة</th>
                                                            <th>الخصم</th>
                                                            <th>نسبة الضريبة</th>
                                                            <th>قيمة الضريبة</th>
                                                            <th>الاجمالي مع الضريبة</th>
                                                            <th>الحالة الحالية</th>
                                                            <th>ملاحظات</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>{{ $invoices->invoice_number }}</td>
                                                            <td>{{ $invoices->invoice_Date }}</td>
                                                            <td>{{ $invoices->Due_date }}</td>
                                                            <td>{{ $invoices->product }}</td>
                                                            <td>{{ $invoices->section->section_name }}</td>
                                                            <td>{{ $invoices->Amount_collection }}</td>
                                                            <td>{{ $invoices->Amount_Commission }}</td>
                                                            <td>{{ $invoices->Discount }}</td>
                                                            <td>{{ $invoices->Rate_VAT }}</td>
                                                            <td>{{ $invoices->Value_VAT }}</td>
                                                            <td>{{ $invoices->Total }}</td>
                                                            <td>
                                                                @if ($invoices->Value_Status == 1)
                                                                    <span
                                                                        class="text-success">{{ $invoices->Status }}</span>
                                                                @elseif($invoices->Value_Status == 2)
                                                                    <span
                                                                        class="text-danger">{{ $invoices->Status }}</span>
                                                                @else
                                                                    <span
                                                                        class="text-warning">{{ $invoices->Status }}</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $invoices->note }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Payment Status Tab -->
                                        <div class="tab-pane" id="tab5">
                                            <div class="table-responsive mt-15">
                                                <table class="table table-striped text-center">
                                                    <thead>
                                                        <tr class="text-dark">
                                                            <th>#</th>
                                                            <th>رقم الفاتورة</th>
                                                            <th>نوع المنتج</th>
                                                            <th>القسم</th>
                                                            <th>حالة الدفع</th>
                                                            <th>تاريخ الدفع</th>
                                                            <th>ملاحظات</th>
                                                            <th>تاريخ الاضافة</th>
                                                            <th>المستخدم</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($details as $detail)
                                                            <tr>
                                                                <td>{{ $detail->id }}</td>
                                                                <td>{{ $detail->invoice_number }}</td>
                                                                <td>{{ $detail->product }}</td>
                                                                <td>{{ $invoices->section->section_name }}</td>
                                                                <td>
                                                                    @if ($detail->Value_Status == 1)
                                                                        <span
                                                                            class="text-success">{{ $detail->Status }}</span>
                                                                    @elseif($detail->Value_Status == 2)
                                                                        <span
                                                                            class="text-danger">{{ $detail->Status }}</span>
                                                                    @else
                                                                        <span
                                                                            class="text-warning">{{ $detail->Status }}</span>
                                                                    @endif
                                                                </td>
                                                                <td>{{ $detail->Payment_Date }}</td>
                                                                <td>{{ $detail->note }}</td>
                                                                <td>{{ $detail->created_at }}</td>
                                                                <td>{{ $detail->user }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Attachments Tab -->
                                        <div class="tab-pane" id="tab6">
                                            <div class="table-responsive mt-15">
                                                <table class="table table-striped text-center">
                                                    <thead>
                                                        <tr class="text-dark">
                                                            <th>#</th>
                                                            <th>اسم الملف</th>
                                                            <th>قام بالاضافة</th>
                                                            <th>تاريخ الاضافة</th>
                                                            <th>العمليات</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($attachments as $attachment)
                                                            <tr>
                                                                <td>{{ $attachment->id }}</td>
                                                                <td>{{ $attachment->file_name }}</td>
                                                                <td>{{ $attachment->Created_by }}</td>
                                                                <td>{{ $attachment->created_at }}</td>
                                                                <td>{{ $attachment->created_at }}</td>

                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /div -->
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection

@section('js')
    <!-- Internal scripts -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/inputtags/inputtags.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
    <script src="{{ URL::asset('assets/js/tabs.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>
@endsection
