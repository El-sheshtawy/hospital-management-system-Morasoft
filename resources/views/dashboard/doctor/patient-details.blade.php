@extends('Dashboard.layouts.master')
@section('title')
    معلومات المريض
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Pages</h4><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0">/ Empty</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @include('Dashboard.messages_alert')
    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-lg-12 col-md-12">
            <div class="card" id="basic-alert">
                <div class="card-body">
                    <div class="text-wrap">
                        <div class="example">
                            <div class="panel panel-primary tabs-style-1">
                                <div class=" tab-menu-heading">
                                    <div class="tabs-menu1">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs main-nav-line">
                                            <li class="nav-item"><a href="#tab1" class="nav-link active"
                                                                    data-toggle="tab">سجل المريض</a></li>
                                            <li class="nav-item"><a href="#tab2" class="nav-link" data-toggle="tab">الاشعة</a>
                                            </li>
                                            <li class="nav-item"><a href="#tab3" class="nav-link" data-toggle="tab">المختبر</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body main-content-body-right border-top-0 border">
                                    <div class="tab-content">


                                        {{-- Strat Show Information Patient --}}

                                        <div class="tab-pane active" id="tab1">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card custom-card">
                                                        <div class="card-body">
                                                            <div class="vtimeline">
                                                                @foreach($diagnosis_reports as $diagnosis_report)

                                                                    <div
                                                                        class="timeline-wrapper {{ $loop->first ? '' : 'timeline-inverted' }} timeline-wrapper-primary">
                                                                        <div class="timeline-badge"><i
                                                                                class="las la-check-circle"></i></div>
                                                                        <div class="timeline-panel">
                                                                            <div class="timeline-heading">
                                                                                <h6 class="timeline-title">{{ 'This time, the doctor diagnosed the case as'  }}</h6>
                                                                            </div>
                                                                            <div class="timeline-body">
                                                                                <p>{{$diagnosis_report->diagnosis}}</p>
                                                                            </div>

                                                                            <div class="timeline-heading">
                                                                                <h6 class="timeline-title">{{ 'And The doctor determined the medication to be '  }}</h6>
                                                                            </div>
                                                                            <div class="timeline-body">
                                                                                <p>{{ $diagnosis_report->medicine}}</p>
                                                                            </div>
                                                                            <div
                                                                                class="timeline-footer d-flex align-items-center flex-wrap">
                                                                                <i class="fas fa-user-md"></i>&nbsp;
                                                                                <span>{{$diagnosis_report->doctor->name}}</span>
                                                                                <span class="mr-auto"><i
                                                                                        class="fa fa-phone"
                                                                                        aria-hidden="true"></i>
                                          {{$diagnosis_report->doctor->phone}}
                                        </span>
                                                                                <span class="mr-auto"><i
                                                                                        class="fe fe-calendar text-muted mr-1"></i>
                                            {{$diagnosis_report->date}}
                                        </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- End Show Information Patient --}}



                                        {{-- Start Invices Patient --}}

                                        <div class="tab-pane" id="tab2">

                                            <div class="table-responsive">
                                                <table class="table table-hover text-md-nowrap text-center">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>حالة الأشعة</th>
                                                        <th>اسم الدكتور</th>
                                                        <th>تشخيص الطبيب</th>
                                                        <th>اسم موظف الاشعة</th>
                                                        <th>معلومات الاشعة</th>
                                                        @can('rays-processes')
                                                            <th>العمليات</th>
                                                        @endcan
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($patient_rays as $patient_ray)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            @if($patient_ray->status === 'pending')
                                                            <td class="text-danger">غير مكتملة</td>
                                                            @elseif($patient_ray->status === 'finish')
                                                                <td class="text-success">مكتملة</td>
                                                            @else
                                                                <td> unexpectedError!</td>
                                                            @endif


                                                            <td>{{$patient_ray->doctor->name}}</td>
                                                            <td>{{$patient_ray->doctor_description}}</td>
                                                            <td>{{$patient_ray->rayEmployee->name ?? '-'}}</td>
                                                            <td>{{ $patient_ray->ray_employee_description ?? '-' }}</td>
                                                            @can('rays-processes')
                                                                 <td>
                                                                    <a class="modal-effect btn btn-sm btn-primary"
                                                                       data-effect="effect-scale" data-toggle="modal"
                                                                       href="#edit_ray_doctor{{$patient_ray->id}}"><i
                                                                            class="fas fa-edit"></i></a>
                                                                    <a class="modal-effect btn btn-sm btn-danger"
                                                                       data-effect="effect-scale" data-toggle="modal"
                                                                       href="#delete_ray{{$patient_ray->id}}"><i
                                                                            class="las la-trash"></i></a>
                                                                </td>
                                                            @endcan
                                                        </tr>
                                                        {{--
                                                        @include('dashboard.doctor.dashboard.rays.edit')
                                                        @include('dashboard.doctor.dashboard.rays.delete')
                                                        --}}
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        {{-- End Invices Patient --}}



                                        {{-- Start Receipt Patient  --}}

                                        <div class="tab-pane" id="tab3">
                                            <div class="table-responsive">
                                                <table class="table table-hover text-md-nowrap text-center">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>اسم الخدمه</th>
                                                        <th>اسم الدكتور</th>
                                                        @if(in_array(auth('doctor')->id(), $patient_laboratories->pluck('doctor_id')
                                                                       ->toArray()))
                                                            <th>العمليات</th>
                                                        @endif
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($patient_laboratories as $patient_laboratory)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{$patient_laboratory->description}}</td>
                                                            <td>{{$patient_laboratory->doctor->name}}</td>
                                                            @if($patient_laboratory->doctor_id === auth()->guard('doctor')->id())
                                                                <td>
                                                                    <a class="modal-effect btn btn-sm btn-primary"
                                                                       data-effect="effect-scale" data-toggle="modal"
                                                                       href="#edit_laboratory{{$patient_laboratory->id}}"><i
                                                                            class="fas fa-edit"></i></a>
                                                                    <a class="modal-effect btn btn-sm btn-danger"
                                                                       data-effect="effect-scale" data-toggle="modal"
                                                                       href="#delete_laboratory{{$patient_laboratory->id}}"><i
                                                                            class="las la-trash"></i></a>
                                                                </td>
                                                            @endif
                                                        </tr>
                                                        @include('dashboard.doctor.dashboard.laboratory.edit')
                                                        @include('dashboard.doctor.dashboard.laboratory.delete')
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        {{-- End Receipt Patient  --}}


                                        {{-- Start payment accounts Patient --}}
                                        <div class="tab-pane" id="tab4">
                                            {{--                                            <div class="table-responsive">--}}
                                            {{--                                                <table class="table table-hover text-md-nowrap text-center" id="example1">--}}
                                            {{--                                                    <thead>--}}
                                            {{--                                                    <tr>--}}
                                            {{--                                                        <th>#</th>--}}
                                            {{--                                                        <th>تاريخ الاضافه</th>--}}
                                            {{--                                                        <th>الوصف</th>--}}
                                            {{--                                                        <th>مدبن</th>--}}
                                            {{--                                                        <th>دائن</th>--}}
                                            {{--                                                        <th>الرصيد النهائي</th>--}}
                                            {{--                                                    </tr>--}}
                                            {{--                                                    </thead>--}}
                                            {{--                                                    <tbody>--}}
                                            {{--                                                    @foreach($Patient_accounts as $Patient_account)--}}
                                            {{--                                                        <tr>--}}
                                            {{--                                                            <td>{{$loop->iteration}}</td>--}}
                                            {{--                                                            <td>{{$Patient_account->date}}</td>--}}
                                            {{--                                                            <td>--}}

                                            {{--                                                               @if($Patient_account->invoice_id == true)--}}
                                            {{--                                                              {{$Patient_account->invoice->Service->name ?? $Patient_account->invoice->Group->name}}--}}

                                            {{--                                                                @elseif($Patient_account->Payment_id == true)--}}
                                            {{--                                                                    {{$Patient_account->PaymentAccount->description}}--}}
                                            {{--                                                                @endif--}}

                                            {{--                                                            </td>--}}
                                            {{--                                                            <td>{{ $Patient_account->Debit}}</td>--}}
                                            {{--                                                            <td>{{ $Patient_account->credit}}</td>--}}
                                            {{--                                                            <td></td>--}}
                                            {{--                                                        </tr>--}}
                                            {{--                                                        <br>--}}
                                            {{--                                                    @endforeach--}}
                                            {{--                                                    <tr>--}}
                                            {{--                                                        <th colspan="3" scope="row" class="alert alert-success">--}}
                                            {{--                                                            الاجمالي--}}
                                            {{--                                                        </th>--}}
                                            {{--                                                        <td class="alert alert-primary">{{ $Debit= $Patient_accounts->sum('Debit')}}</td>--}}
                                            {{--                                                        <td class="alert alert-primary">{{ $credit =$Patient_accounts->sum('credit')}}</td>--}}
                                            {{--                                                        <td class="alert alert-danger">--}}
                                            {{--                                                           <span class="text-danger"> {{$Debit-$credit}}  {{ $Debit-$credit > 0 ? 'مدين' :'دائن'}}</span>--}}
                                            {{--                                                        </td>--}}
                                            {{--                                                    </tr>--}}
                                            {{--                                                    </tbody>--}}
                                            {{--                                                </table>--}}

                                            {{--                                            </div>--}}

                                            <br>

                                        </div>

                                        {{-- End payment accounts Patient --}}


                                        <div class="tab-pane" id="tab5">
                                            <p>praesentium voluptatum deleniti atque corrquas molestias excepturi sint
                                                occaecati cupiditate non provident,</p>
                                            <p class="mb-0">similique sunt in culpa qui officia deserunt mollitia animi,
                                                id est laborum et dolorum fuga. Et harum quidem rerum facilis est et
                                                expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi
                                                optio cumque nihil impedit quo minus id quod maxime placeat facere
                                                possimus, omnis voluptas assumenda est, omnis dolor repellendus.</p>
                                        </div>
                                        <div class="tab-pane" id="tab6">
                                            <p>praesentium et quas molestias excepturi sint occaecati cupiditate non
                                                provident,</p>
                                            <p class="mb-0">similique sunt in culpa qui officia deserunt mollitia animi,
                                                id est laborum et dolorum fuga. Et harum quidem rerum facilis est et
                                                expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi
                                                optio cumque nihil impedit quo minus id quod maxime placeat facere
                                                possimus, omnis voluptas assumenda est, omnis dolor repellendus.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Prism Precode -->
                    </div>
                </div>
            </div>
        </div>


    </div>
    </div>
    <!-- /row -->
    </div>
    <!-- Container closed -->
    </div>
@endsection
