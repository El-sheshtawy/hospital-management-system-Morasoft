@extends('dashboard.layouts.master')
@section('title')
    Assign Permission For Users
@endsection

@push('extra_css')
    {{--Internal Sumoselect css--}}
    <link rel="stylesheet" href="{{ URL::asset('dashboard/plugins/sumoselect/sumoselect-rtl.css') }}">
    <link href="{{URL::asset('dashboard/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
@endpush
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Assign Permission For Users</h4>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @include('dashboard.messages_alert')

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.permission-for-users.store') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputPassword1" style="font-weight: bold;color: blue">Permission Name</label>
                            <input type="text" name="name" class="form-control"><br>

                            <label for="exampleInputPassword1" style="font-weight: bold;color: blue">Assign Permission For Users</label>
                            <div>
                                <select multiple="multiple" class="testselect2" name="users[]">
                                    <option value=""  disabled class="col-xs-1 text-center" >-- Select Users --</option>

                                    <option value="" disabled style="font-weight: bold;color: red">Admins Members</option>
                                    @foreach($admins as  $admin)
                                        <option value="{{ $admin->user_id }}">{{ $admin->user->name }}</option>
                                    @endforeach

                                    <option value="" disabled style="font-weight: bold;color: red">Doctors Members</option>
                                    @foreach($doctors as  $doctor)
                                        <option value="{{ $doctor->user_id }}">{{ $doctor->user->name }}</option>
                                    @endforeach

                                    <option value="" disabled style="font-weight: bold;color: red">Rays employees</option>
                                    @foreach($rays_employees as  $rays_employee)
                                        <option value="{{ $rays_employee->user_id }}">{{ $rays_employee->user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary">تاكيد</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@push('extra_js')
    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('dashboard/js/select2.js') }}"></script>
    <script src="{{ URL::asset('dashboard/js/advanced-form-elements.js') }}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('dashboard/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    {{-- Upload Photo Script --}}
    <script src="{{ asset('dashboard/js/upload-photo.js') }}"></script>
@endpush
