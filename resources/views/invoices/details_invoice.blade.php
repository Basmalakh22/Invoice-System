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
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif



    @if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


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
                                            <li><a href="#tab4" class="nav-link active" data-toggle="tab">معلومات
                                                    الفاتوره</a></li>
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
                                            <div class="card card-statistics">
                                                <div class="card-body">
                                                    <p class="text-danger">* صيغة المرفق pdf, jpeg, .jpg, png </p>
                                                    <h5 class="card-title">اضافة مرفقات</h5>
                                                    <form method="post" action="{{ route('attachment.store') }}"
                                                        enctype="multipart/form-data">
                                                        {{ csrf_field() }}
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="customFile"
                                                                name="file_name" required>
                                                            <input type="hidden" id="customFile" name="invoice_number"
                                                                value="{{ $invoices->invoice_number }}">
                                                            <input type="hidden" id="invoice_id" name="invoice_id"
                                                                value="{{ $invoices->id }}">
                                                            <label class="custom-file-label" for="customFile">حدد
                                                                المرفق</label>
                                                        </div><br><br>
                                                        <button type="submit" class="btn btn-primary btn-sm"
                                                            name="uploadedFile">تاكيد</button>
                                                    </form>
                                                </div>
                                            </div>

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
                                                                <td>

                                                                    <a class="btn btn-outline-success btn-sm"
                                                                        href="{{ route('View_file', ['invoice_number' => $invoices->invoice_number, 'file_name' => urlencode($attachment->file_name)]) }}"
                                                                        role="button"><i class="fas fa-eye"></i>&nbsp;
                                                                        عرض</a>

                                                                    <a class="btn btn-outline-info btn-sm"
                                                                        href="{{ route('download', ['invoice_number' => $invoices->invoice_number, 'file_name' => $attachment->file_name]) }}"
                                                                        role="button"><i
                                                                            class="fas fa-download"></i>&nbsp;
                                                                        تحميل</a>


                                                                    <button class="btn btn-outline-danger btn-sm"
                                                                        data-toggle="modal"
                                                                        data-file_name="{{ $attachment->file_name }}"
                                                                        data-invoice_number="{{ $attachment->invoice_number }}"
                                                                        data-id_file="{{ $attachment->id }}"
                                                                        data-target="#delete_file">حذف</button>
                                                                </td>

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

    <!-- delete -->
    <div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('InvoiceDetail.destroy',$invoices->id) }}" method="post">

                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p class="text-center">
                        <h6 style="color:red"> هل انت متاكد من عملية حذف المرفق ؟</h6>
                        </p>

                        <input type="hidden" name="id_file" id="id_file" value="">
                        <input type="hidden" name="file_name" id="file_name" value="">
                        <input type="hidden" name="invoice_number" id="invoice_number" value="">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">تاكيد</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection

@section('js')
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Internal Jquery.mCustomScrollbar js-->
    <script src="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <!-- Internal Input tags js-->
    <script src="{{ URL::asset('assets/plugins/inputtags/inputtags.js') }}"></script>
    <!--- Tabs JS-->
    <script src="{{ URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
    <script src="{{ URL::asset('assets/js/tabs.js') }}"></script>
    <!--Internal  Clipboard js-->
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.js') }}"></script>
    <!-- Internal Prism js-->
    <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>

    <script>
        $('#delete_file').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id_file = button.data('id_file')
            var file_name = button.data('file_name')
            var invoice_number = button.data('invoice_number')
            var modal = $(this)

            modal.find('.modal-body #id_file').val(id_file);
            modal.find('.modal-body #file_name').val(file_name);
            modal.find('.modal-body #invoice_number').val(invoice_number);
        })

    </script>

    <script>
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

    </script>

@endsection