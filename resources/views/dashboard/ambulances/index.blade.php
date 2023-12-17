@extends('dashboard.layouts.master')
@section('page-header')
	<!-- breadcrumb -->
	<div class="breadcrumb-header justify-content-between">
		<div class="my-auto">
			<div class="d-flex">
				<h4 class="content-title mb-0 my-auto">الاسعاف</h4>
				<span class="text-muted mt-1 tx-13 mr-2 mb-0">/ سيارات الاسعاف</span>
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
						<a href="{{route('admin.ambulances.create')}}" class="btn btn-primary">اضافة سيارة جديدة</a>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table text-md-nowrap" id="example1">
							<thead>
							<tr>
								<th>#</th>
								<th >رقم السيارة</th>
								<th >موديل السيارة</th>
								<th>سنة الصنع</th>
								<th>ملكية السيارة</th>
								<th >اسم السائق</th>
								<th >حالة السيارة</th>
								<th >ملاحظات</th>
								<th>العمليات</th>
							</tr>
							</thead>
							<tbody>
							@foreach($ambulances as $ambulance)
								<tr>
									<td>{{$loop->iteration}}</td>
									<td>{{$ambulance->car_number}}</td>
									<td>{{$ambulance->car_model}}</td>
									<td>{{$ambulance->car_year_made}}</td>
									<td>{{$ambulance->ownership_status === 1 ? 'مملوكة' :'ايجار'}}</td>
									<td>
											{{$ambulance->user->name}}
									</td>
									<td>{{$ambulance->active == 1 ? 'مفعلة':'غير مفعلة'}}</td>
									<td>{{$ambulance->notes}}</td>
									<td>
										<a href="{{route('admin.ambulances.edit',$ambulance->id)}}"
										   class="btn btn-sm btn-success">
											<i class="fas fa-edit"></i>
										</a>
										<button class="btn btn-sm btn-danger" data-toggle="modal"
												data-target="#delete{{$ambulance->id}}">
											<i class="fas fa-trash"></i>
										</button>
									</td>
									@include('dashboard.ambulances.delete')
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
	</div>
	<!-- Container closed -->
	</div>
	<!-- main-content closed -->
@endsection
