@extends('dashboard.layouts.master')
@section('title')
    اضافة مريض جديد
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto" style="color: steelblue; font-weight: bold">المرضي</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اضافة مريض جديد</span>
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
                    <form action="{{route('admin.patients.store')}}" method="post" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-3">
                                <label>اسم المريض</label>
                                <input type="text" name="name"  value="{{old('name')}}"
                                       class="form-control @error('name') is-invalid @enderror " required>
                            </div>

                            <div class="col">
                                <label>البريد الالكتروني</label>
                                <input type="email" name="email"  value="{{old('email')}}"
                                       class="form-control @error('email') is-invalid @enderror" required>
                            </div>


                            <div class="col">
                                <label>تاريخ الميلاد</label>
                                <input class="form-control fc-datepicker" name="birth_date" placeholder="YYYY-MM-DD"
                                       type="text" value="{{ old('birth_date') }}" required>
                            </div>

                        </div>
                        <br>
                        <div class="row">
                        <div class="col">
                            <label>رقم الهاتف الاول</label>
                            <input class="form-control" name="first_number" type="tel"
                                   value="{{ old('first_number') }}">
                            @error('first_number')
                            <div class="alert-danger">  {{ $message }} </div>
                            @enderror
                        </div>
                        <div class="col">
                            <label>رقم الهاتف الثاني</label>
                            <input class="form-control" name="second_number" type="tel"
                                   value="{{ old('second_number') }}">
                            @error('second_number')
                            <div class="alert-danger">{{ $message }}</div>
                            @enderror
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
                                <label>                                        تأكيد كلمة المرور</label>
                                <input class="form-control" name="password_confirmation" type="password">
                                @error('password_confirmation')
                                <div class="alert-danger">  {{ $message }} </div>
                                @enderror
                            </div>
                        </div>
                        <br>
                        <div class="row">

                        <div class="col">
                            <label>الجنس</label>
                            <select name="gender" class="form-control @error('gender') is-invalid @enderror" required>
                                <option value="" disabled selected>-- حدد جنس المريض --</option>
                                @foreach($genders as $key => $gender)
                                    <option value="{{ $key }}" @selected(old('gender') == $gender)>
                                        {{ $gender }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                            <div class="col">
                            <label>فصلية الدم</label>
                            <select class="form-control" name="blood_type"  required>
                                <option value="" disabled selected>-- حدد فصيلة الدم --</option>
                                @foreach($bloodTypes as $key => $bloodType)
                                    <option value="{{ $key }}" @selected(old('blood_type') == $bloodType)>
                                        {{ $bloodType }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <label>العنوان</label>
                                <textarea rows="5" cols="10" class="form-control" name="address">
                                    {{ old('address') }}
                                </textarea>
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col">
                                <button class="btn btn-primary">حفظ البيانات</button>
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

    <script>
        document.querySelectorAll('label').forEach(e => e.style.color = "royalblue");
        document.querySelectorAll('label').forEach(e => e.style.fontWeight = "bold");
    </script>
@endpush
