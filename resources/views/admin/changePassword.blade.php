@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title')
@parent :: {!!'Change Password'!!}
@stop
@section('styles')
@stop
{{-- Content --}}
@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Change Password</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/{!! ADMIN_SLUG !!}">Home</a>
                                </li>
                                <li class="breadcrumb-item active"><a href="javascript:;">Change Password</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section id="basic-vertical-layouts">
                <div class="row match-height">
                    <div class="col-md-12 col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    {{-- Notifications --}}
                                    @include('admin.includes.notifications')
                                    
                                    {!! Form::open(['route' => ADMIN_SLUG.'.password.change', 'id' => 'change-password-form']) !!}
                                    <div class="form-body">
                                        <div class="form-group has-feedback">
                                            {!! Form::label('password','Old Password') !!}
                                            {!! Form::password('old_password', array('class'=>'form-control','id' => 'old_password')) !!}
                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        </div>

                                        <div class="form-group has-feedback">
                                            {!! Form::label('password','New Password') !!}
                                            {!! Form::password('password', array('class'=>'form-control','id' => 'password')) !!}
                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        </div>

                                        <div class="form-group has-feedback">
                                            {!! Form::label('cpassword','Confirm Password:') !!}
                                            {!! Form::password('password_confirmation', array('class'=>'form-control','id' => 'password_confirmation')) !!}
                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        </div>

                                        <div class="form-group">
                                            {!! Form::submit('Save',array('class'=>'btn btn-primary mr-1 mb-1', 'id'=>'submitform')) !!}
                                            <a href="{!! URL::previous() !!}" class="btn btn-outline-warning mr-1 mb-1">Cancel</a>
                                        </div>
                                    </div>
                                    {!! Form::close()!!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section> {{-- section end --}}
        </div>
    </div>
</div>{{-- END: Content--}}
@stop