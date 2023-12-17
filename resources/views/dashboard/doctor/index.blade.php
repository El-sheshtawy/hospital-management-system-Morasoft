@extends('dashboard.layouts.master')
@section('title')
	{{trans('dashboard/main-sidebar_trans.doctors')}}
@endsection
@section('page-header')
	<!-- breadcrumb -->
	<div class="breadcrumb-header justify-content-between">
		<div class="my-auto">
			<div class="d-flex">
				<h4 class="content-title mb-0 my-auto">{{trans('dashboard/main-sidebar_trans.doctors')}}</h4>
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
			<div class="card mg-b-20">
				<div class="card-header pb-0">
					<div class="d-flex justify-content-between">
						<a href="{{route('admin.doctors.create')}}" class="btn btn-success"
						   role="button" aria-pressed="true">
							{{trans('doctors.add_doctor')}}
						</a>
						<button type="button" class="btn btn-danger" id="delete-selected-btn">
							{{trans('doctors.delete_select')}}
						</button>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table id="doctors-table" class="table key-buttons text-md-nowrap">
							<thead>
							<tr>
								<th>
									<input type="checkbox" name="select_all" id="select-all"/>
								</th>
								<th>#</th>
								<th>{{ trans('Doctors.doctor image') }}</th>
								<th>{{trans('doctors.name')}}</th>
								<th>{{trans('doctors.email')}}</th>
								<th>{{trans('doctors.section')}}</th>
                                <th>رقم الهاتف الاول</th>
                                <th>رقم الهاتف الثاني</th>
								<th>{{trans('doctors.appointments')}}</th>
								<th>{{trans('doctors.Status')}}</th>
								<th>{{trans('doctors.created_at')}}</th>
								<th>{{trans('doctors.Processes')}}</th>
							</tr>
							</thead>
							<tbody>
							@foreach($doctors as $doctor)
								<tr>
									<td>
										<input type="checkbox" name="select_one" value="{{$doctor->id}}"
											   class="select-one">
									</td>
									<td>{{ $doctor->id }}</td>
									@if(is_null($doctor->image))
										<td>
											<img src="{{ url('images/dashboard/doctors/doctor_default.PNG') }}"
												 height="50px" width="50px" alt="doc-img">
										</td>
									@else
										<td>
											<img src="{{ url('images/dashboard/doctors/'.$doctor->image->filename) }}"
												 height="50px" width="50px" alt="doc-img">
										</td>
									@endif
									<td>
                                            {{ $doctor->user->name }}
                                    </td>
									<td>{{ $doctor->user->email }}</td>
									<td>{{ $doctor->section->name}}</td>
									<td>
                                        {{ $doctor->user->phone_numbers['first_number'] }}
                                    </td>

                                    <td>
                                        {{ $doctor->user->phone_numbers['second_number'] ?? '' }}
                                    </td>
									<td>
										@foreach($doctor->appointments as $key => $appointment)
											@if($key == $doctor->appointments->count() - 1 )
												{{ $appointment->name . ' .' }}
											@else
												{{ $appointment->name . ' , '  }}
											@endif
										@endforeach
									</td>
									<td>
										<div class="dot-label bg-{{$doctor->active == 1 ? 'success':'danger'}} ml-1">

										</div>

									</td>

									<td>{{ $doctor->created_at->diffForHumans() }}</td>

									<td>
										<div class="dropdown">
											<button aria-expanded="false" aria-haspopup="true"
													class="btn ripple btn-outline-primary btn-sm"
													data-toggle="dropdown" type="button">
												{{trans('doctors.Processes')}}
												<i class="fas fa-caret-down mr-1"></i>
											</button>

											<div class="dropdown-menu tx-13">

												<a class="dropdown-item"
												   href="{{route('admin.doctors.edit',$doctor->id)}}">
													<i style="color: #0ba360" class="text-success ti-user"></i>
													&nbsp;&nbsp;تعديل البيانات
												</a>

												<a class="dropdown-item" href="#" data-toggle="modal"
												   data-target="#update-password{{$doctor->id}}">
													<i class="text-primary ti-key">
													</i>&nbsp;&nbsp;تغير كلمة المرور
												</a>

												<a class="dropdown-item" href="#" data-toggle="modal"
												   data-target="#update-status{{$doctor->id}}">
													<i class="text-warning ti-back-right"></i>
													&nbsp;&nbsp;تغير الحالة
												</a>

												<a class="dropdown-item" href="#" data-toggle="modal"
												   data-target="#delete-one{{$doctor->id}}">
													<i class="text-danger  ti-trash"></i>
													&nbsp;&nbsp;حذف البيانات
												</a>
											</div>
										</div>
									</td>
								</tr>
								@include('dashboard.doctor.delete-one')
								@include('dashboard.doctor.delete-selected')
								@include('dashboard.doctor.update-password')
								@include('dashboard.doctor.update-status')
							@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<!--/div-->
	</div>
	<!-- /row -->
	</div>
	<!-- Container closed -->
	</div>
	<!-- main-content closed -->
@endsection
@push('extra_js')

	{{-- when click on select in header , all rows will be selected --}}
	<script>
		$(function () {
			$('#select-all').click(function (source) {
			 selectedDoctors = $('.select-one');
				for (var index in selectedDoctors) {
					selectedDoctors[index].checked = source.target.checked;
				}
			});
		});
	</script>

	{{-- when click on (حذف مجموعة اطباء) button , selected doctors will pass to delete-many modal to delete  --}}
	<script>
		$(function () {
			$("#delete-selected-btn").click(function () {
				var selectedDoctors = [];
				$("#doctors-table input[name=select_one]:checked").each(function () {
					selectedDoctors.push(this.value);
				});

				if (selectedDoctors.length > 0) {
					$('#delete-many').modal('show');
					$('#selected-doctors').val(selectedDoctors);
				}
			});
		});
	</script>
@endpush

