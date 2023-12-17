@extends('dashboard.layouts.master')
@section('page-header')
	<!-- breadcrumb -->
	<div class="breadcrumb-header justify-content-between">
		<div class="my-auto">
			<div class="d-flex">
				<h4 class="content-title mb-0 my-auto">المرضي</h4>
				<span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة المرضي</span>
			</div>
		</div>
	</div>
	<!-- breadcrumb -->
@endsection
@section('content')
	@include('dashboard.messages_alert')
	<!-- row opened -->
	<div class="row row-sm">
		<!--div-->
		<div class="col-xl-12">
			<div class="card">
				<div class="card-header pb-0">
					<div class="d-flex justify-content-between">
						<a href="{{route('admin.patients.create')}}" class="btn btn-primary">اضافة مريض جديد</a>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table text-md-nowrap" id="example1">
							<thead>
							<tr>
								<th>#</th>
								<th>اسم المريض</th>
								<th >البريد الالكتروني</th>
								<th>تاريخ الميلاد</th>
                                <th>رقم الهاتف الاول</th>
                                <th>رقم الهاتف الثاني</th>
								<th>الجنس</th>
								<th >فصلية الدم</th>
								<th >العنوان</th>
								<th>العمليات</th>
							</tr>
							</thead>
							<tbody>
							@foreach($patients as $patient)
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td>{{ $patient->user->name }}</td>
									<td>{{ $patient->user->email }}</td>
									<td>{{ $patient->birth_date }}</td>
                                    <td>
                                        {{ $patient->user->phone_numbers['first_number'] }}
                                    </td>

                                    <td>
                                        {{ $patient->user->phone_numbers['second_number'] ?? '' }}
                                    </td>
									<td>{{ $patient->gender === 1 ? 'ذكر' : 'أنثي' }}</td>
									<td>
                                        @if($patient->blood_type === 1)
                                            +O
                                        @elseif($patient->blood_type === 2)
                                            -O
                                        @elseif($patient->blood_type === 3)
                                            +A
                                        @elseif($patient->blood_type === 4)
                                            -A
                                        @elseif($patient->blood_type === 5)
                                            +B
                                        @elseif($patient->blood_type === 6)
                                            -B
                                        @elseif($patient->blood_type === 7)
                                            +AB
                                        @elseif($patient->blood_type === 8)
                                            -AB
                                        @endif
                                    </td>
									<td>{{ $patient->address }}</td>
									<td>
										<a href="{{ route('admin.patients.edit', $patient) }}"
										   class="btn btn-sm btn-success">
											<i class="fas fa-edit"></i>
										</a>
										<button class="btn btn-sm btn-danger" data-toggle="modal"
												data-target="#delete{{$patient->id}}">
											<i class="fas fa-trash"></i>
										</button>
										<a href="{{ route('admin.patients.show', $patient) }}"
										   class="btn btn-primary btn-sm">
											<i class="fas fa-eye"></i>
                                        </a>

									</td>
									@include('dashboard.patient.delete')
								</tr>
							@endforeach
							</tbody>
						</table>
					</div>
				</div><!-- bd -->
			</div><!-- bd -->
		</div>
		<!--/div-->
	</div>
	<!-- /row -->
	<!-- Container closed -->
	<!-- main-content closed -->
@endsection
