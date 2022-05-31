@extends('frontend.layouts.default')

{{-- Web site Title --}}
@section('title')
@parent :: Login
@stop
@section('content')

<section class="page-content">
    <div class="container">
        <div class="heading">
            <div class="content mt-4">
                <h1 class="page-title">Login</h1>
                <h3 class="sub-title mt-4">
                    Don't you have an account yet? &nbsp; <a href="{!! URL::route('frontend.users.create') !!}">Create an Account</a>
                </h3>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-lg-8 col-md-8 col-sm-8 offset-md-2 col-xs-12">
                @include('frontend.includes.notifications')
                {!! Form::open(['url' => 'login', 'id' => 'login-form', 'class' => 'form']) !!}
                <div class="form-group">
                    <div class="form-icon has-feedback">
                        {!! Form::text('email', old('email'),array('class'=>'form-control', 'placeholder'=>'Email')) !!}
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-icon has-feedback">
                        {!! Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password')) !!}
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    </div>
                </div>

                <div class="form-group has-feedback">
                    <button type="submit" class="btn btn-primary" id="login-form-submit">Login</button>&nbsp;
                    <a href="{!! URL::to('password/reset') !!}">Forgot password?</a>
                </div>
                {!! Form::close()!!}
            </div>
            {{-- /.col-xs-12 --}}
        </div>
        {{-- /.row --}}
    </div>
</section>
@stop