@extends('dashboard.layouts.master')
@section('title')
    تعديل بيانات مريض
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المرضي</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/  تعديل بيانات مريض</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @include('dashboard.messages_alert')
    <!-- row -->
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{route('admin.patients.update', $patient)}}"
                          autocomplete="off">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-3">
                                <label>اسم المريض</label>
                                <input type="text" name="name"  value="{{$patient->user->name}}"
                                       class="form-control @error('name') is-invalid @enderror " required>
                                <input type="hidden" name="patient_id" value="{{$patient->id}}">
                            </div>

                            <div class="col">
                                <label>البريد الالكتروني</label>
                                <input type="email" name="email"  value="{{$patient->user->email}}"
                                       class="form-control @error('email') is-invalid @enderror" required>
                            </div>


                            <div class="col">
                                <label>تاريخ الميلاد</label>
                                <input class="form-control fc-datepicker" value="{{$patient->birth_date}}"
                                       name="birth_date" type="text" required>
                            </div>

                        </div>
                        <br>


                        <div class="row">
                            <div class="col">
                                <label>                                        كلمة المرور
                                </label>
                                <input class="form-control" name="password" type="password">
                                @error('password')
                                <div class="alert-danger">  {{ $message }} </div>
                                @enderror
                            </div>
                            <div class="col">
                                <label> تأكيد كلمة المرور</label>
                                <input class="form-control" name="password_confirmation" type="password">
                                @error('password_confirmation')
                                <div class="alert-danger">  {{ $message }} </div>
                                @enderror
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col">
                                <label>رقم الهاتف الاول</label>
                                <input class="form-control" name="first_number" type="tel"
                                       value="{{ $patient->user->phone_numbers['first_number'] }}">
                                @error('first_number')
                                <div class="alert-danger">  {{ $message }} </div>
                                @enderror
                            </div>
                            <div class="col">
                                <label>رقم الهاتف الثاني</label>
                                <input class="form-control" name="second_number" type="tel"
                                       value="{{ $patient->user->phone_numbers['second_number'] }}">
                                @error('second_number')
                                <div class="alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <br>

                            <div class="col">
                                <label>الجنس</label>
                                <select class="form-control" name="gender" required>
                                    @foreach($genders as $key => $gender)
                                        <option value="{{ $key }}" @selected($patient->gender == $gender)>
                                            {{ $gender }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col">
                                <label>فصلية الدم</label>
                                <select class="form-control" name="blood_type" required>
                                    @foreach($bloodTypes as $key =>  $bloodType)
                                        <option value="{{ $key }}"
                                                @selected($bloodType == $patient->blood_type)>
                                            {{ $bloodType }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <label>العنوان</label>
                                <textarea rows="5" cols="10" class="form-control" name="address">
                                    {{$patient->address}}
                                </textarea>
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col">
                                <button class="btn btn-success">حفظ البيانات</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
@endsection
@push('extra_js')
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('dashboard/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>

    <script>
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();
    </script>
@endpush
