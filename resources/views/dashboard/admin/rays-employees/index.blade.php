@extends('dashboard.layouts.master')
@section('title')
    قائمة الموظفين
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الاشعة</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة الموظفين</span>
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

                        @if($errors->any())
                            <div>
                                @foreach($errors->all() as $error)
                                    <div class="alert-danger">{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create">
                            اضافة موظف جديد
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table style="text-align: center" class="table text-md-nowrap" id="example1">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th >البريد الالكتروني</th>
                                <th>تاريخ الاضافة</th>
                                <th >العمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rays_employees as $rays_employee)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$rays_employee->name}}</td>
                                    <td>{{ $rays_employee->email }}</td>
                                    <td>{{ $rays_employee->created_at->diffForHumans() }}</td>
                                    <td>
                                        <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"  data-toggle="modal" href="#edit{{$rays_employee->id}}"><i class="las la-pen"></i></a>
                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"  data-toggle="modal" href="#delete{{$rays_employee->id}}"><i class="las la-trash"></i></a>
                                    </td>
                                </tr>

                                @include('dashboard.admin.rays-employees.edit')
                                @include('dashboard.admin.rays-employees.delete')
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div><!-- bd -->
            </div><!-- bd -->
        </div>
        <!--/div-->
        @include('dashboard.admin.rays-employees.create')
        <!-- /row -->

    </div>
    <!-- row closed -->

    <!-- Container closed -->

    <!-- main-content closed -->
@endsection
@push('extra_js')
    <!--Internal  Notify js -->
    <script src="{{URL::asset('dashboard/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('/plugins/notify/js/notifit-custom.js')}}"></script>
@endpush
