@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title')
@parent :: {!! 'Admin Profile' !!}
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
                        <h2 class="content-header-title float-left mb-0">Admin Profile</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/{!! ADMIN_SLUG !!}">Home</a>
                                </li>
                                <li class="breadcrumb-item active"><a href="javascript:;">Admin Profile</a>
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

                                    @if(isset($profile))
                                        {!! Form::model($profile, ['route' => array('profile.update', $profile->id),'method' => 'PATCH', 'id' => 'profile-form', 'files' => true]) !!}
                                        <input type="hidden" name="id" value="<?php echo $profile->id; ?>" >
                                   @endif
                                    <div class="form-body">
                                        <div class="form-group">
                                            {!! Form::label('firstname', 'First Name') !!}
                                            {!! Form::text('firstname', old('firstname'),array('class'=>'form-control')) !!}
                                        </div>

                                        <div class="form-group">
                                            {!! Form::label('lastname', 'Last Name') !!}
                                            {!! Form::text('lastname', old('lastname'),array('class'=>'form-control')) !!}
                                        </div>

                                        <div class="form-group">
                                            {!! Form::label('email', 'Email') !!}
                                            {!! Form::text('email', old('email'),array('class'=>'form-control')) !!}
                                        </div>

                                        <div class="form-group">
                                            {!! Form::submit('Submit',array('class'=>'btn btn-primary mr-1 mb-1', 'id'=>'submitform')) !!}
                                            <a href="{!! URL(ADMIN_SLUG) !!}" class="btn btn-outline-warning mr-1 mb-1">Cancel</a>
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