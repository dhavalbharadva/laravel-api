<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="{!! asset('assets/images/favicon.png') !!}" type="image/png">

        <title>
            @section('title')
            {!! config('settings.title') !!}
            @show
        </title>
        
        {{-- Meta--}}
        <meta name="description" content="{!! config('settings.metaDescription') !!}" />
        <meta name="keywords" content="{!! config('settings.metaKeywords') !!}" />
        
        {{-- css --}}
        {{-- Bootstrap core CSS --}}
        <link media="all" rel="stylesheet" href="{!! asset('/assets/css/bootstrap.min.css') !!}">
        
        {{-- Template CSS --}}
        <link href="{!! asset('/assets/css/style.css" rel="stylesheet') !!}">
        
    </head>
   <body class="inner-page-body">

        @include('frontend.includes.header')
        @yield('styles')
        @yield('content')
        
        {{-- Jquery scripts  --}}
        <script src="{!! asset('/assets/js/jquery.min.js') !!}"></script>
        {{-- popper JavaScript --}}
        <script src="{!! asset('/assets/js/popper.min.js') !!}"></script>
        {{-- Bootstrap core JavaScript  --}}
        <script src="{!! asset('/assets/js/bootstrap.min.js') !!}"></script> 
        
        {{-- custom JavaScript --}}
        <script src="{!! asset('/assets/js/validation/jquery.validate.min.js') !!}"></script>
        <script src="{!! asset('/assets/js/validation/additional-methods.js') !!}"></script>
        <script src="{!! asset('/assets/js/common.js') !!}"></script>
        @yield('scripts')
        @include('frontend.includes.footer')

    </body>
</html>
