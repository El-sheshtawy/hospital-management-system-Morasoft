@extends('dashboard.layouts.master')
@section('title')
    معلومات المريض
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ $patient->name }}</h4><span
                        class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ $patient->name }} Details</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
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
                                            <li class="nav-item">
                                                <a href="#tab1" class="nav-link active" data-toggle="tab">
                                                    معلومات المريض
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#tab2" class="nav-link" data-toggle="tab">الفواتير</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#tab3" class="nav-link" data-toggle="tab">المدفوعات</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#tab4" class="nav-link" data-toggle="tab">كشف حساب</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#tab5" class="nav-link" data-toggle="tab">الاشعه</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#tab6" class="nav-link" data-toggle="tab">المختبر</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body main-content-body-right border-top-0 border">
                                    <div class="tab-content">


                                        {{-- Strat Show Information Patient --}}

                                        <div class="tab-pane active" id="tab1">
                                            <br>
                                            <div class="table-responsive">
                                                <table class="table table-hover text-md-nowrap text-center">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>اسم المريض</th>
                                                        <th>رقم الهاتف</th>
                                                        <th>البريد الالكتورني</th>
                                                        <th>تاريخ الميلاد</th>
                                                        <th>النوع</th>
                                                        <th>فصيلة الدم</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>{{ $patient->name }}</td>
                                                        <td>{{ $patientPhoneNumbers }}</td>
                                                        <td>{{ $patient->email }}</td>
                                                        <td>{{ $patient->birth_date }}</td>
                                                        <td>{{ $patient->gender == 'male' ? '`ذكر' :  'انثي' }}</td>
                                                        <td>{{ $patient->blood_type }}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
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
                                                        <th>اسم الخدمه</th>
                                                        <th>تاريخ الفاتوره</th>
                                                        <th>الاجمالي مع الضريبه</th>
                                                        <th>نوع الفاتوره</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($patientInvoices as $patientInvoice)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>
                                                                {{ $patientInvoice->singleService->name ??
                                                                   $patientInvoice->groupServices->name }}
                                                            </td>
                                                            <td>{{$patientInvoice->date}}</td>
                                                            <td>{{$patientInvoice->total_with_tax}}</td>
                                                            <td>{{$patientInvoice->type == 1 ? 'نقدي' : 'اجل'}}</td>
                                                        </tr>
                                                        <br>
                                                    @endforeach
                                                    <tr>
                                                        <th colspan="4" scope="row" class="alert alert-success">
                                                            الاجمالي
                                                        </th>
                                                        <td class="alert alert-primary">
                                                            {{ number_format( $patientInvoices->sum('total_with_tax') , 2)}}
                                                        </td>
                                                    </tr>
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
                                                        <th>تاريخ الاضافه</th>
                                                        <th>المبلغ</th>
                                                        <th>البيان</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($patientReceipts as $patientReceipt)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{$patientReceipt->date}}</td>
                                                            <td>{{$patientReceipt->amount}}</td>
                                                            <td>{{$patientReceipt->description}}</td>
                                                        </tr>
                                                        <br>
                                                    @endforeach
                                                    <tr>
                                                        <th scope="row" class="alert alert-success">الاجمالي
                                                        </th>
                                                        <td colspan="4"
                                                            class="alert alert-primary">
                                                            {{ number_format( $patientReceipts->sum('amount') , 2)}}
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        {{-- End Receipt Patient  --}}


                                        {{-- Start payment accounts Patient --}}
                                        <div class="tab-pane" id="tab4">
                                            <div class="table-responsive">
                                                <table class="table table-hover text-md-nowrap text-center"
                                                       id="example1">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>تاريخ الاضافه</th>
                                                        <th>الوصف</th>
                                                        <th>مدبن</th>
                                                        <th>دائن</th>
                                                        <th>الرصيد النهائي</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($patientAccounts as $patientAccount)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{$patientAccount->date}}</td>
                                                            <td>
                                                                @if($patientAccount->single_invoice_id)
                                                                    {{ $patientAccount->singleInvoice->service->name }}

                                                                @elseif($patientAccount->receipt_id)
                                                                    {{ $patientAccount->receiptAccount->description }}

                                                                @elseif($patientAccount->payment_id)
                                                                    {{ $patientAccount->paymentAccount->description }}
                                                                @endif

                                                            </td>
                                                            <td>{{ $patientAccount->debit}}</td>
                                                            <td>{{ $patientAccount->credit}}</td>
                                                            <td></td>
                                                        </tr>
                                                        <br>
                                                    @endforeach
                                                    <tr>
                                                        <th colspan="3" scope="row" class="alert alert-success">
                                                            الاجمالي
                                                        </th>
                                                        <td class="alert alert-primary">
                                                            {{ number_format( $debit = $patientAccounts->sum('debit'), 2) }}
                                                        </td>
                                                        <td class="alert alert-primary">
                                                            {{ number_format( $credit = $patientAccounts->sum('credit'), 2) }}
                                                        </td>
                                                        <td class="alert alert-danger">
                                                            <span class="text-danger">
                                                                {{ number_format(abs($debit - $credit), 2) }}
                                                                @if($credit - $debit > 0)
                                                                    دائن
                                                                @elseif($credit - $debit < 0)
                                                                    مدين
                                                                @else

                                                                @endif
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>

                                            </div>

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
