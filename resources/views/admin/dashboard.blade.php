@extends('admin.layouts.default')
@section('title')
@parent :: {!!'Dashboard'!!}
@stop
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- Dashboard Analytics Start -->
            <section id="dashboard-analytics">
                <div class="row match-height">
                    <div class="col-xl-4 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="avatar bg-rgba-info p-50 m-0 mb-1">
                                        <div class="avatar-content">
                                            <i class="feather icon-eye text-info font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="text-bold-700">36.9k</h2>
                                    <p class="mb-0 line-ellipsis">Views</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="avatar bg-rgba-info p-50 m-0 mb-1">
                                        <div class="avatar-content">
                                            <i class="feather icon-eye text-info font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="text-bold-700">36.9k</h2>
                                    <p class="mb-0 line-ellipsis">Views</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="avatar bg-rgba-info p-50 m-0 mb-1">
                                        <div class="avatar-content">
                                            <i class="feather icon-eye text-info font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="text-bold-700">36.9k</h2>
                                    <p class="mb-0 line-ellipsis">Views</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Dashboard Analytics end -->
        </div>
    </div>
</div>
<!-- END: Content-->
@stop
