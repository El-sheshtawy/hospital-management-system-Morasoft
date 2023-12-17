@extends('dashboard.layouts.master')

@push('extra_css')
    {{--Internal Sumoselect css--}}
    <link rel="stylesheet" href="{{ URL::asset('dashboard/plugins/sumoselect/sumoselect-rtl.css') }}">
    <link href="{{URL::asset('dashboard/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
@endpush

@section('title')
        {{trans('doctors.add_doctor')}}
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> {{trans('dashboard/main-sidebar_trans.doctors')}}</h4><span
                        class="text-muted mt-1 tx-13 mr-2 mb-0">/
               {{trans('doctors.add_doctor')}}</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
@include('dashboard.messages_alert')

    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('admin.doctors.store') }}" method="post" autocomplete="off"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="pd-30 pd-sm-40 bg-gray-200">

                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-1">
                                    <label for="exampleInputEmail1">
                                        {{trans('doctors.name')}}</label>
                                </div>
                                <div class="col-md-11 mg-t-5 mg-md-t-0">
                                    <input class="form-control" name="name" type="text" autofocus
                                           value="{{ old('name') }}">
                                    @error('name')
                                    <div class="alert-danger">  {{ $message }} </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-1">
                                    <label for="exampleInputEmail1">
                                        {{trans('doctors.email')}}</label>
                                </div>
                                <div class="col-md-11 mg-t-5 mg-md-t-0">
                                    <input class="form-control" name="email" type="email"
                                           value="{{ old('email') }}">
                                    @error('email')
                                    <div class="alert-danger">  {{ $message }} </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-1">
                                    <label for="exampleInputEmail1">
                                        {{ trans('doctors.password') }}</label>
                                </div>
                                <div class="col-md-11 mg-t-5 mg-md-t-0">
                                    <input class="form-control" name="password" type="password">
                                    @error('password')
                                    <div class="alert-danger">  {{ $message }} </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-1">
                                    <label for="exampleInputEmail1">
                                        تأكيد كلمة المرور
                                    </label>
                                </div>
                                <div class="col-md-11 mg-t-5 mg-md-t-0">
                                    <input class="form-control" name="password_confirmation" type="password">
                                    @error('password_confirmation')
                                    <div class="alert-danger">  {{ $message }} </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-1">
                                    <label for="exampleInputEmail1">
                                        رقم الهاتف الاول
                                    </label>
                                </div>
                                <div class="col-md-11 mg-t-5 mg-md-t-0">
                                    <input class="form-control" name="first_number" type="tel"
                                           value="{{ old('first_number') }}">
                                    @error('first_number')
                                    <div class="alert-danger">  {{ $message }} </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-1">
                                    <label for="exampleInputEmail1">
                                        رقم الهاتف الثاني
                                    </label>
                                </div>
                                <div class="col-md-11 mg-t-5 mg-md-t-0">
                                    <input class="form-control" name="second_number" type="tel"
                                           value="{{ old('second_number') }}">
                                    @error('second_number')
                                    <div class="alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-1">
                                    <label for="exampleInputEmail1">
                                        {{trans('doctors.section')}}</label>
                                </div>

                                <div class="col-md-11 mg-t-5 mg-md-t-0">
                                    <select name="section_id" class="form-control SlectBox">
                                        <option value="" selected disabled>------</option>
                                        @foreach($sections as $section)
                                            <option value="{{ $section->id }}">{{$section->name}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('section_id'))
                                        <div class="alert-danger">
                                        @foreach($errors->get('section_id') as $error)
                                        <ul>
                                            <li>{{ $error }}</li>
                                        </ul>
                                        @endforeach
                                        </div>
                                    @endif
                                </div>

                            </div>

                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-1">
                                    <label for="exampleInputEmail1">
                                        {{trans('doctors.appointments')}}</label>
                                </div>

                                <div class="col-md-11 mg-t-5 mg-md-t-0">
                                    <select multiple="multiple" class="testselect2" name="appointments[]">
                                        <option value="" selected disabled>-- حدد المواعيد --</option>
                                        @foreach($appointments as  $appointment)
                                        <option value="{{ $appointment->id }}">{{ $appointment->name }}</option>
                                        @endforeach
                                    </select>

                                    <div class="alert-danger">
                                    @error('appointments')
                                        {{ $message }}
                                    @enderror

                                    @if($errors->has('appointments.*'))
                                        <h5>There is an error in appointments field</h5>
                                        <ul>
                                            @foreach($errors->get('appointments.*') as $errors)
                                                @foreach($errors as $error)
                                                        <li>{{ $error }}</li>
                                                @endforeach
                                            @endforeach
                                        </ul>
                                    @endif
                                    </div>
                                </div>

                            </div>


                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-1">
                                    <label for="exampleInputEmail1">
                                        {{ trans('Doctors.doctor_photo') }}</label>
                                </div>
                                <input name="photo" id="photo" type="file" accept="image/*" />
                                <div id="dvPreview"></div>
                            </div>

                            <button type="submit"
                                    class="btn btn-main-primary pd-x-30 mg-r-5 mg-t-5">{{ trans('Doctors.submit') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /row -->
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
