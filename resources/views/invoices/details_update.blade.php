@extends('layouts.master')
@section('title')
    تعديل المرفقات - برنامج الفواتير
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
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل
                    المرفقات</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('attachment.update', $attachment->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="file_name">اختر ملف مرفق</label>
                <input type="file" class="form-control" id="file_name" name="file_name" required>
                <small class="form-text text-muted">صيغة المرفق pdf, jpeg, .jpg, png</small>
            </div>

            <input type="hidden" name="invoice_number" value="{{ $attachment->invoice_number }}">
            <input type="hidden" name="invoice_id" value="{{ $attachment->invoice_id }}">

            <button type="submit" class="btn btn-primary">تحديث المرفق</button>
            <a href="{{ route('invoice.index') }}" class="btn btn-secondary">عودة</a>
        </form>
    </div>

    </div>
    <!-- row closed -->
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

@endsection


