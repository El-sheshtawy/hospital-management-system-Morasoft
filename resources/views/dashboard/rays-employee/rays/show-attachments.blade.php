@extends('dashboard.layouts.master')
@section('title')
    المرفقات
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الاشاعات</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المرفقات
                </span>
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
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="col-xs-1 text-center">
                        <h1>Attachments</h1>
                        </div>
                        @foreach($ray->images as $image)
                            <img src="{{ url('images/rays/'.$image->filename) }}"
                                 class="img-fluid"  alt="Responsive image">
                        @endforeach
                    </div>
                </div><!-- bd -->
            </div><!-- bd -->
        </div>
        <!--/div-->
        <!-- /row -->
    </div>
@endsection



