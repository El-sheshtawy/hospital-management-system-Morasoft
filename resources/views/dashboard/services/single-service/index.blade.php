@extends('dashboard.layouts.master')
@section('title')
	{{trans('dashboard/main-sidebar_trans.Single_service')}}
@stop
@push('extra_css')
	<!-- Internal Data table css -->
	<link href="{{URL::asset('dashboard/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet"/>
	<link href="{{URL::asset('dashboard/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
	<link href="{{URL::asset('dashboard/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet"/>
	<link href="{{URL::asset('dashboard/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
	<link href="{{URL::asset('dashboard/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
	<link href="{{URL::asset('dashboard/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
	<!--Internal   Notify -->
	<link href="{{URL::asset('dashboard/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
@endpush
@section('page-header')
	<!-- breadcrumb -->
	<div class="breadcrumb-header justify-content-between">
		<div class="my-auto">
			<div class="d-flex">
				<h4 class="content-title mb-0 my-auto">{{trans('dashboard/main-sidebar_trans.Services')}}</h4><span
						class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{trans('dashboard/main-sidebar_trans.Single_service')}}</span>
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
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add">
							{{trans('Services.add_Service')}}
						</button>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table text-md-nowrap" id="example2">
							<thead>
							<tr>
								<th>#</th>
								<th> {{trans('Services.name')}}</th>
								<th> {{trans('Services.price')}}</th>
								<th> {{trans('doctors.Status')}}</th>
								<th> {{trans('Services.description')}}</th>
								<th>{{trans('dashboard/sections_trans.created_at')}}</th>
								<th>{{trans('dashboard/sections_trans.Processes')}}</th>
							</tr>
							</thead>
							<tbody>
							@foreach($singleServices as $singleService)
								<tr>
									<td>{{$loop->iteration}}</td>
									<td>{{$singleService->name}}</td>
									<td>{{$singleService->price}}</td>
									<td>
										<div
												class="dot-label bg-{{$singleService->active == 1 ? 'success':'danger'}} ml-1"></div>
									</td>
									<td> {{ Str::limit($singleService->description, 50) }}</td>
									<td>{{ $singleService->created_at->diffForHumans() }}</td>
									<td>
										<a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
										   data-toggle="modal" href="#edit{{$singleService->id}}"><i
													class="las la-pen"></i></a>
										<a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
										   data-toggle="modal" href="#delete{{$singleService->id}}"><i
													class="las la-trash"></i></a>
									</td>
								</tr>
								@include('dashboard.services.single-service.edit')
								@include('dashboard.services.single-service.delete')
							@endforeach
							</tbody>
						</table>
					</div>
				</div><!-- bd -->
			</div><!-- bd -->
		</div>
		<!--/div-->

		@include('dashboard.services.single-service.create')
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