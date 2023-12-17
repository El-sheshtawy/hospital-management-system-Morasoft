@extends('dashboard.layouts.master')
@section('title')
    قائمة الاشاعات المطلوبة
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الاشعة</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/قائمة الاشاعات المطلوبة</span>
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
                <div class="card-body">
                    <div class="table-responsive">
                        <table style="text-align: center" class="table text-md-nowrap" id="example1">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>الحالة</th>
                                <th>اسم الطبيب</th>
                                <th>تشخيص الطبيب</th>
                                <th>اسم موظف الاشعة</th>
                                <th>معلومات الاشعة</th>
                                <th>العمليات</th>
                                <th>المرفقات</th>
                                @can('rays-processes')
                                <th>عمليات المسؤول</th>
                                @endcan
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rays as $ray)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    @if($ray->status === 'pending')
                                        <td class="text-danger">غير مكتملة</td>
                                    @elseif($ray->status === 'finish')
                                        <td class="text-success">مكتملة</td>
                                    @else
                                        <td> unexpectedError!</td>
                                    @endif

                                    <td>{{ $ray->doctor->name }}</td>
                                    <td>
                                        {{ \Illuminate\Support\Str::limit($ray->doctor_description, 50) }}
                                    </td>
                                    <td>{{ $ray->rayEmployee->name ?? '-' }}</td>
                                    <td>{{ $ray->ray_employee_description ?? '-' }}</td>
                                    <td>
                                    @if(!$ray->ray_employee_description)

                                        <a class="btn btn-primary" href="{{ route('ray-employee.rays.show', $ray) }}">
                                                اضافة التقرير
                                        </a>
                                     @else

                                    @endif
                                    </td>
                                    @if($ray->status === 'finish')
                                    <td>
                                        <a class="btn btn-warning" href="{{ route('ray-employee.rays.attachments.index', $ray) }}">
                                            عرض الصور
                                        </a>
                                    </td>
                                    @endif
                                    @can('rays-processes')
                                        <td>
                                            <a class="modal-effect btn btn-sm btn-primary"
                                               data-effect="effect-scale" data-toggle="modal"
                                               href="#edit_ray_doctor{{$ray->id}}"><i
                                                    class="fas fa-edit"></i></a>
                                            <a class="modal-effect btn btn-sm btn-danger"
                                               data-effect="effect-scale" data-toggle="modal"
                                               href="#delete_ray{{$ray->id}}"><i
                                                    class="las la-trash"></i></a>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div><!-- bd -->
            </div><!-- bd -->
        </div>
    </div>
    <!-- row closed -->

    <!-- Container closed -->

    <!-- main-content closed -->
@endsection
