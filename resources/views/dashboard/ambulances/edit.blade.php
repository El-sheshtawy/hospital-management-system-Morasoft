@extends('dashboard.layouts.master')
@section('title')
    تعديل سيارة جديدة
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الاسعاف</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اضافة سيارة جديدة</span>
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
                    <form action="{{route('admin.ambulances.update', $ambulance->id)}}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col">
                                <label>رقم السيارة</label>
                                <input type="text" name="car_number"  value="{{$ambulance->car_number}}"
                                       class="form-control @error('car_number') is-invalid @enderror">
                                <input type="hidden" name="ambulance_id" value="{{$ambulance->id}}">
                            </div>

                            <div class="col">
                                <label>موديل السيارة</label>
                                <input type="text" name="car_model"  value="{{$ambulance->car_model}}"
                                       class="form-control @error('car_model') is-invalid @enderror">
                            </div>

                            <div class="col">
                                <label>سنة الصنع</label>
                                <input type="number" name="car_year_made"  value="{{$ambulance->car_year_made}}"
                                       class="form-control @error('car_year_made') is-invalid @enderror">
                            </div>

                            <div class="col">
                                <label>نوع السيارة</label>
                                <select class="form-control" name="ownership_status">
                                    <option value=1 @selected(1== $ambulance->ownership_status)>
                                        مملوكة</option>
                                    <option value=0 @selected(0== $ambulance->ownership_status)>
                                        ايجار
                                    </option>
                                </select>
                            </div>

                        </div>
                        <br>

                        <div class="row">
                            <div class="col-3">
                                <label>اسم السائق</label>
                                <select type="text" name="driver_id"  class="form-control">
                                    @foreach($drivers as $driver)
                                        <option value="{{ $driver->id }}"
                                                @selected($ambulance->user->user_id == $driver->id)>
                                            {{ $driver->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col">
                                <label>ملاحظات</label>
                                <textarea rows="5" cols="10" class="form-control" name="notes">
                                    {{$ambulance->notes}}
                                </textarea>
                            </div>
                        </div>

                        <br>
                        <div class="row">
                            <div class="col">
                                <label>حالة التفعيل</label>
                                &nbsp;
                                <input name="active" type="checkbox" @checked(old('active',  $ambulance->active))
                                       class="form-check-input">
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
