@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title')
@parent :: {!!'Users'!!}
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
                        <h2 class="content-header-title float-left mb-0">Users</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/{!! ADMIN_SLUG !!}">Home</a>
                                </li>
                                <li class="breadcrumb-item active"><a href="javascript:;">Users</a>
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

                                    @if(isset($user))
                                    {!! Form::model($user, array('route' => array(ADMIN_SLUG.'.users.update', $user->id), 'method' => 'PATCH', 'id' => 'user-form', 'class' => 'form form-vertical', 'files' => true )) !!}
                                    @else
                                    {!! Form::open(array('route' => ADMIN_SLUG.'.users.store', 'id' => 'user-form', 'class' => 'form form-vertical', 'files' => true)) !!}
                                    @endif
                                    <div class="form-body">
                                        <div class="form-group">
                                            {!! Form::label('title', 'Name') !!}
                                            {!! Form::text('name', old('name'),array('class'=>'form-control')) !!}
                                        </div>

                                        <div class="form-group">
                                            {!! Form::label('title', 'Email') !!}
                                            {!! Form::text('email', old('email'),array('class'=>'form-control')) !!}
                                        </div>

                                        <div class="form-group">
                                            {!! Form::label('password', 'Password') !!}
                                            {!! Form::password('password', array('class'=>'form-control', 'id'=>'password')) !!}
                                        </div>

                                        <div class="form-group">
                                            {!! Form::label('password_confirmation', 'Confirm Password') !!}
                                            {!! Form::password('password_confirmation', array('class'=>'form-control', 'id'=>'password_confirmation')) !!}
                                        </div>

                                        <div class="form-group">
                                            {!! Form::submit('Submit',array('class'=>'btn btn-primary mr-1 mb-1', 'id'=>'submitform')) !!}
                                            <a href="{!! URL::route('users.index') !!}" class="btn btn-outline-warning mr-1 mb-1">Cancel</a>
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
{{-- Scripts --}}
@section('scripts')
<script type="text/javascript">
    CKEDITOR.replace('content', {
        //uiColor:"#532F12",
        //toolbar: 'BlogToolbar',
        toolbar: 'MyToolbar',
    });
</script>
@stop