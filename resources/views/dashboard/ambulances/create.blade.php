@extends('dashboard.layouts.master')
@section('title')
    اضافة سيارة اسعاف جديدة
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الاسعاف</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اضافة سيارة اسعاف جديدة</span>
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
                    <form action="{{route('admin.ambulances.store')}}" method="post" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <label>رقم السيارة</label>
                                <input type="text" name="car_number"  value="{{old('car_number')}}"
                                       class="form-control @error('car_number') is-invalid @enderror">
                            </div>

                            <div class="col">
                                <label>موديل السيارة</label>
                                <input type="text" name="car_model"  value="{{old('car_model')}}"
                                       class="form-control @error('car_model') is-invalid @enderror">
                            </div>

                            <div class="col">
                                <label>سنة الصنع</label>
                                <input type="number" name="car_year_made"  value="{{old('car_year_made')}}"
                                       class="form-control @error('car_year_made') is-invalid @enderror">
                            </div>

                            <div class="col">
                                <label>نوع السيارة</label>
                                <select class="form-control" name="ownership_status">
                                    <option value="" selected disabled>-- حدد حالة ملكية السيار--</option>
                                    <option value=1>مملوكة</option>
                                    <option value=0>ايجار</option>
                                </select>
                            </div>

                        </div>
                        <br>

                        <div class="row">
                            <div class="col-3">
                                <label>اسم السائق</label>
                                <select type="text" name="driver_id"  class="form-control">
                                    <option value="" disabled selected>-- حدد اسم السائق --</option>
                                    @foreach($drivers as $driver)
                                        <option value="{{ $driver->id }}">{{ $driver->user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col">
                                <label>ملاحظات</label>
                                <textarea rows="5" cols="10" class="form-control" name="notes"></textarea>
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
