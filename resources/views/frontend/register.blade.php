@extends('frontend.layouts.default')

{{-- Web site Title --}}
@section('title')
@parent :: Create an Account
@stop
@section('content')

<section class="page-content">
    <div class="container">
        <div class="heading">
            <div class="content mt-4">
                <h1 class="page-title">Create an Account</h1>
                <h3 class="sub-title mt-4">
                    Do you already have an account? &nbsp; <a href="{!! URL::route('frontend.login') !!}">Login</a>
                </h3>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-lg-8 col-md-8 col-sm-8 offset-md-2 col-xs-12">
                @include('frontend.includes.notifications')
                {!! Form::open(['route' => 'users.store', 'id' => 'register-form', 'class' => 'form', 'files' => true]) !!}

                <div class="form-group has-feedback">
                    {!! Form::text('name', old('name'),array('class'=>'form-control', 'placeholder'=>'Name')) !!}
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                </div>

                <div class="form-group has-feedback">
                    {!! Form::text('email', old('email'),array('class'=>'form-control', 'placeholder'=>'Email')) !!}
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    <span id="loader" class="help-block"></span>
                </div>

                <div class="form-group has-feedback">
                    {!! Form::password('password', array('class'=>'form-control', 'id'=>'password', 'placeholder'=>'Password')) !!}
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                </div>
                <div class="form-group has-feedback">
                    {!! Form::password('password_confirmation', array('class'=>'form-control', 'placeholder'=>'Confirm Password')) !!}
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                </div>

                <div class="form-group has-feedback">
                    <button type="submit" class="btn btn-primary" id="register-form-submit">Register</button>
                </div>
                {!! Form::close()!!}
            </div>
            {{-- /.col-xs-12 --}}
        </div>
        {{-- /.row --}}
    </div>
</section>
@stop
