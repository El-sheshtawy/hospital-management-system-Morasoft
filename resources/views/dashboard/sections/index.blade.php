@extends('dashboard.layouts.master')
@section('title')
	{{trans('dashboard/main-sidebar_trans.sections')}}
@endsection
@push('extra_css')
	<link href="{{URL::asset('dashboard/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
	<link href="{{URL::asset('dashboard/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
@endpush
@section('page-header')
	<!-- breadcrumb -->
	<div class="breadcrumb-header justify-content-between">
		<div class="my-auto">
			<div class="d-flex">
				<h4 class="content-title mb-0 my-auto">{{trans('dashboard/main-sidebar_trans.sections')}}</h4>
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
						<button type="button" class="btn btn-success" data-toggle="modal" data-target="#add">
							{{trans('dashboard/sections_trans.add_sections')}}
						</button>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table text-md-nowrap" id="example2">
							<thead>
							<tr>
								<th class="wd-15p border-bottom-0">#</th>
								<th class="wd-15p border-bottom-0">{{trans('dashboard/sections_trans.name_sections')}}</th>
								<th class="wd-15p border-bottom-0">{{trans('dashboard/sections_trans.description')}}</th>
								<th class="wd-20p border-bottom-0">{{trans('dashboard/sections_trans.created_at')}}</th>
								<th class="wd-20p border-bottom-0">{{trans('dashboard/sections_trans.updated_at')}}</th>
								<th class="wd-20p border-bottom-0">{{trans('dashboard/sections_trans.Processes')}}</th>
							</tr>
							</thead>
							<tbody>
							@foreach($sections as $section)
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td>
										<a href="{{ route('admin.section.doctors.show', $section->id) }}"
										   style="font-weight: bold;">
											{{ $section->name }}
										</a>
									</td>
									<td>
										{{ \Illuminate\Support\Str::limit($section->description, 50) }}
									</td>
									<td>{{ $section->created_at->diffForHumans() }}</td>
									<td> {{ $section->updated_at ? $section->updated_at->diffForHumans() : '' }}</td>
									<td>
										<a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
										   data-toggle="modal" href="#edit{{$section->id}}">
											<i class="las la-pen"></i>
										</a>

										<a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
										   data-toggle="modal" href="#delete{{$section->id}}">
											<i class="las la-trash"></i>
										</a>
									</td>
								</tr>
								@include('dashboard.sections.edit')
								@include('dashboard.sections.delete')
							@endforeach
							</tbody>
						</table>
					</div>
				</div><!-- bd -->
			</div><!-- bd -->
		</div>
		<!--/div-->

		<!-- /row -->
		@include('dashboard.sections.create')
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
