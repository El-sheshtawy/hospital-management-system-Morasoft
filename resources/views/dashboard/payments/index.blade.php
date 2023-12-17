@extends('dashboard.layouts.master')
@section('title')
    سندات الصرف
@stop
@push('extra_css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('Dashboard/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{URL::asset('dashboard/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>

    <link href="{{URL::asset('dashboard/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <!--Internal  Datetimepicker-slider css -->
    <link href="{{URL::asset('dashboard/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css')}}" rel="stylesheet">
    <link href="{{URL::asset('dashboard/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css')}}" rel="stylesheet">
    <link href="{{URL::asset('dashboard/plugins/pickerjs/picker.min.css')}}" rel="stylesheet">
    <!-- Internal Spectrum-colorpicker css -->
    <link href="{{URL::asset('dashboard/plugins/spectrum-colorpicker/spectrum.css')}}" rel="stylesheet">
@endpush
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الحسابات</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ سندات الصرف</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @include('dashboard.messages_alert')
    <!-- row -->
    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <a href="{{route('admin.payments.create')}}" class="btn btn-primary" role="button"
                           aria-pressed="true">اضافة سند جديد</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم المريض</th>
                                <th>المبلغ</th>
                                <th>البيان</th>
                                <th>تاريخ الاضافة</th>
                                <th>العمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $payment->patient->name }}</td>
                                    <td>{{ number_format($payment->amount, 2) }}</td>
                                    <td>{{ \Str::limit($payment->description, 50) }}</td>
                                    <td>{{ $payment->created_at->diffForHumans() }}</td>
                                    <td>
                                        <a href="{{route('admin.payments.edit',$payment->id)}}"
                                           class="btn btn-sm btn-primary"><i class="fas fa-edit"></i>
                                        </a>
                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                           data-toggle="modal" href="#delete{{$payment->id}}">
                                            <i class="las la-trash"></i>
                                        </a>
                                        <a href="{{route('admin.payments.print',$payment->id)}}"
                                           class="btn btn-primary btn-sm"
                                           target="_blank" title="طباعه سند صرف">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    </td>
                                </tr>
                                @include('dashboard.payments.delete')
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div><!-- bd -->
            </div><!-- bd -->
        </div>
        <!--/div-->

        <!-- /row -->

    </div>
    <!-- row closed -->

    <!-- Container closed -->

    <!-- main-content closed -->
@endsection
@push('extra_js')
    @include('dashboard.payments.extra-js')
@endpush