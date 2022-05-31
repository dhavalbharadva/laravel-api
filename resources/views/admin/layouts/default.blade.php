<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <title>
        @section('title')
            Administration
        @show
    </title>
    <link rel="shortcut icon" type="image/x-icon" href="{!!asset('assets/admin/images/ico/favicon.png')!!}" >
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    {{-- BEGIN: Vendor CSS--}}
    <link rel="stylesheet" type="text/css" href="{!!asset('assets/admin/vendors/css/vendors.min.css')!!}">
    {{-- END: Vendor CSS--}}

    
    
    {{-- bootstrap dataTables --}}
    <link href="{!!asset('assets/admin/vendors/datatables_1.10.8/datatables.min.css')!!}" rel="stylesheet" type="text/css" />
        

    {{-- BEGIN: Page CSS--}}
    <link rel="stylesheet" type="text/css" href="{!!asset('assets/admin/css/core/menu/menu-types/vertical-menu.css')!!}">
    <link rel="stylesheet" type="text/css" href="{!!asset('assets/admin/css/core/colors/palette-gradient.css')!!}">
    {{-- END: Page CSS--}}

    {{-- BEGIN: Theme CSS--}}
    <link rel="stylesheet" type="text/css" href="{!!asset('assets/admin/css/bootstrap.css')!!}">
    <link rel="stylesheet" type="text/css" href="{!!asset('assets/admin/css/bootstrap-extended.css')!!}">
    <link rel="stylesheet" type="text/css" href="{!!asset('assets/admin/css/colors.css')!!}">
    <link rel="stylesheet" type="text/css" href="{!!asset('assets/admin/css/components.css')!!}">
    <link rel="stylesheet" type="text/css" href="{!!asset('assets/admin/css/themes/dark-layout.css')!!}">
    <link rel="stylesheet" type="text/css" href="{!!asset('assets/admin/css/themes/semi-dark-layout.css')!!}">

    {{-- BEGIN: Custom CSS--}}
    <link rel="stylesheet" type="text/css" href="{!!asset('assets/admin/css/style.css')!!}">
    {{-- END: Custom CSS--}}

</head>

    <body class="vertical-layout vertical-menu-modern semi-dark-layout 2-columns  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="semi-dark-layout">
        
        {{-- BEGIN: Header--}}
        @include('admin.includes.header')
        {{-- END: Header--}}
        
        {{-- Left side contains the logo and sidebar --}}
        @include('admin.includes.sidebar')
        
        {{-- Right side contains the content of the page --}}
        @yield('content')
        
        @include('admin.includes.footer')
        
        {{-- BEGIN: Vendor JS--}}
        <script src="{!!asset('assets/admin/vendors/js/vendors.min.js')!!}"></script>
        {{-- BEGIN Vendor JS--}}
        
        {{-- jQuery Validation js --}}
        <script src="{!!asset('assets/admin/vendors/validation/jquery.validate.min.js')!!}" type="text/javascript"></script>
        <script src="{!!asset('assets/admin/vendors/validation/additional-methods.js')!!}" type="text/javascript"></script>
        @if(config('app.locale')!='en')
        <script src="{!!asset('assets/admin/vendors/validation/localization/messages_'.config('app.locale').'.js')!!}" type="text/javascript"></script>
        @endif
        <script src="{!!asset('assets/admin/js/common.js')!!}" type="text/javascript"></script>
        {{-- END jQuery Validation js --}}
        
        {{-- jQuery dataTables js --}}
<!--        <script src="{!!asset('assets/admin/vendors/datatables_1.10.8/pdfmake.min.js')!!}"></script>
        <script src="{!!asset('assets/admin/vendors/datatables_1.10.8/vfs_fonts.js')!!}"></script>-->
        <script src="{!!asset('assets/admin/vendors/datatables_1.10.8/datatables.min.js')!!}"></script>
<!--        <script src="{!!asset('assets/admin/vendors/datatables_1.10.8/datatables.buttons.min.js')!!}"></script>
        <script src="{!!asset('assets/admin/vendors/datatables_1.10.8/buttons.html5.min.js')!!}"></script>-->
<!--        <script src="{!!asset('assets/admin/vendors/datatables_1.10.8/buttons.print.min.js')!!}"></script>-->
        <!--<script src="{!!asset('assets/admin/vendors/datatables_1.10.8/buttons.bootstrap.min.js')!!}"></script>-->
        <script src="{!!asset('assets/admin/vendors/datatables_1.10.8/datatables.bootstrap4.min.js')!!}"></script>

        {{-- ckeditor --}}
        <script type="text/javascript" src="{!!asset('assets/admin/vendors/ckeditor/ckeditor.js')!!}"></script>

        {{-- BEGIN: Theme JS--}}
        <script src="{!!asset('assets/admin/js/core/app-menu.js')!!}"></script>
        <script src="{!!asset('assets/admin/js/core/app.js')!!}"></script>
        <script src="{!!asset('assets/admin/js/scripts/components.js')!!}"></script>
        {{-- END: Theme JS--}}

        <script type="text/javascript">
        $(function () {
            //hide alert message when click on remove icon
            $(".close").click(function () {
                $(this).closest('.alert').addClass('d-none');
            });
        });
        </script>
        @yield('scripts')
    </body>

</html>