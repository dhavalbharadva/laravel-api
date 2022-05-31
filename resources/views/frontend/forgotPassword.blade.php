@extends('frontend.layouts.default')

{{-- Web site Title --}}
@section('title')
@parent :: Forgot Password
@stop
@section('content')

<section class="page-content">
    <div class="container mt-4">
        <div class="heading">
            <div class="content mt-4">
                <h1 class="page-title">Forgot Password</h1>
                <h3 class="sub-title mt-4">
                    Please provide your registered email address, <br> we will send you an instruction on your email how to reset your password.
                </h3>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-lg-8 col-md-8 col-sm-8 offset-md-2 col-xs-12">
                @include('frontend.includes.notifications')
                {!! Form::open(array('url' => 'password/email', 'id' => 'password-form', 'name' => 'password-form')) !!}
                <div class="form-group">
                    {!! Form::text('email', old('email'),array('class'=>'form-control', 'placeholder' => 'Email')) !!}
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" id="password-form-submit">Submit</button>&nbsp;
                    <a href="{!! URL::route('frontend.login') !!}" class="xs-block btn btn-default">Cancel</a>
                </div>
                {!! Form::close()!!}
            </div>
            {{-- /.col-xs-12 --}}
        </div>
        {{-- /.row --}}
    </div>
</section>
@stop