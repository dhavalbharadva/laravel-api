@extends('frontend.layouts.default')

{{-- Web site Title --}}
@section('title')
@parent :: Reset Password
@stop
@section('content')

<section class="page-content">
    <div class="container mt-4">
        <div class="heading">
            <div class="content mt-4">
                <h1 class="page-title">Reset Password</h1>
                <h3 class="sub-title mt-4">
                    Now you just need to provide registered email and set new password for further use.
                </h3>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-lg-8 col-md-8 col-sm-8 offset-md-2 col-xs-12">
                @include('frontend.includes.notifications')
                {!! Form::open(array('route' => array('password.reset', $token),'id' => 'reset-password-form')) !!}
                {!! Form::hidden('token', $token) !!}
                <div class="form-group">
                    {!! Form::text('email', $email or old('email') ,array('class'=>'form-control', 'placeholder' => 'Email')) !!}
                </div>
                <div class="form-group">
                    {!! Form::password('password', array('class'=>'form-control','id' => 'password', 'placeholder' => 'New Password')) !!}
                </div>
                <div class="form-group">
                    {!! Form::password('password_confirmation', array('class'=>'form-control','id' => 'password_confirmation', 'placeholder' => 'Confirm Password')) !!}
                </div>
                <div class="form-group text-center">
                    {!! Form::submit('Save', array('class'=>'btn btn-primary btn-lg')) !!}
                </div>
                {!! Form::close()!!}
            </div>
            {{-- /.col-xs-12 --}}
        </div>
        {{-- /.row --}}
    </div>
</section>
@stop