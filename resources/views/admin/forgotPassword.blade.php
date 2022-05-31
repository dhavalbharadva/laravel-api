<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
        <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
        <title>{!! config('settings.sitename') !!} :: Forgot Password</title>
        <link rel="shortcut icon" type="image/x-icon" href="{!!asset('assets/admin/images/ico/favicon.png')!!}" >
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

        {{-- BEGIN: Vendor CSS--}}
        <link rel="stylesheet" type="text/css" href="{!!asset('assets/admin/vendors/css/vendors.min.css')!!}">
        {{-- END: Vendor CSS--}}

        {{-- BEGIN: Theme CSS--}}
        <link rel="stylesheet" type="text/css" href="{!!asset('assets/admin/css/bootstrap.css')!!}">
        <link rel="stylesheet" type="text/css" href="{!!asset('assets/admin/css/bootstrap-extended.css')!!}">
        <link rel="stylesheet" type="text/css" href="{!!asset('assets/admin/css/colors.css')!!}">
        <link rel="stylesheet" type="text/css" href="{!!asset('assets/admin/css/components.css')!!}">
        <link rel="stylesheet" type="text/css" href="{!!asset('assets/admin/css/themes/dark-layout.css')!!}">
        <link rel="stylesheet" type="text/css" href="{!!asset('assets/admin/css/themes/semi-dark-layout.css')!!}">

        {{-- BEGIN: Page CSS--}}
        <link rel="stylesheet" type="text/css" href="{!!asset('assets/admin/css/core/menu/menu-types/vertical-menu.css')!!}">
        <link rel="stylesheet" type="text/css" href="{!!asset('assets/admin/css/core/colors/palette-gradient.css')!!}">
        <link rel="stylesheet" type="text/css" href="{!!asset('assets/admin/css/pages/authentication.css')!!}">
        {{-- END: Page CSS--}}

        {{-- BEGIN: Custom CSS--}}
        <link rel="stylesheet" type="text/css" href="{!!asset('assets/admin/css/style.css')!!}">
        {{-- END: Custom CSS--}}

    </head>

    <body class="vertical-layout vertical-menu-modern semi-dark-layout 1-column  navbar-floating footer-static bg-full-screen-image  blank-page blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column" data-layout="semi-dark-layout">
        {{-- BEGIN: Content--}}
        <div class="app-content content">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <section class="row flexbox-container">
                        <div class="col-xl-8 col-11 d-flex justify-content-center">
                            <div class="card bg-authentication rounded-0 mb-0">
                                <div class="row m-0">
                                    <div class="col-lg-6 d-lg-block d-none text-center align-self-center px-1 py-0">
                                        <img src="{!!asset('assets/admin/images/pages/login.png')!!}" alt="branding logo">
                                    </div>
                                    <div class="col-lg-6 col-12 p-0">
                                        <div class="card rounded-0 mb-0 px-2">
                                            <div class="card-header pb-1">
                                                <div class="card-title">
                                                    <h4 class="mb-0">Forgot Password</h4>
                                                </div>
                                            </div>
                                            <p class="px-2">Please provide your registered email address, we will send you an instruction on your email how to reset your password.</p>
                                            <div class="card-content">
                                                <div class="card-body pt-1">
                                                    {{-- Notifications --}}
                                                    @include('admin.includes.notifications')
                                                    
                                                    {!! Form::open(array('url' => ADMIN_SLUG.'/password/email', 'id' => 'password-form', 'name' => 'password-form')) !!}
                                                        <fieldset class="form-label-group form-group position-relative has-icon-left">
                                                            {!! Form::text('email', old('email'),array('class'=>'form-control', 'placeholder' => 'Email')) !!}
                                                            <div class="form-control-position">
                                                                <i class="fa fa-envelope"></i>
                                                            </div>
                                                            <label for="email">Email</label>
                                                        </fieldset>

                                                        <div class="form-group d-flex align-items-center">
                                                            <div class="text-left mr-2">
                                                                <button type="submit" class="btn btn-primary float-right btn-inline">Submit</button>
                                                            </div>
                                                            <div class="text-right">
                                                                <a href="{!!URL::to(ADMIN_SLUG.'/')!!}" class="btn btn-outline-warning">Cancel</a>
                                                            </div>
                                                        </div>
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>{{-- END: Content--}}

        {{-- BEGIN: Vendor JS--}}
        <script src="{!!asset('assets/admin/vendors/js/vendors.min.js')!!}"></script>
        {{-- END Vendor JS--}}
        
        {{-- jQuery Validation js --}}
        <script src="{!!asset('assets/admin/vendors/validation/jquery.validate.min.js')!!}" type="text/javascript"></script>
        <script src="{!!asset('assets/admin/vendors/validation/additional-methods.js')!!}" type="text/javascript"></script>
        @if(config('app.locale')!='en')
        <script src="{!!asset('assets/admin/vendors/validation/localization/messages_'.config('app.locale').'.js')!!}" type="text/javascript"></script>
        @endif
        <script src="{!!asset('assets/admin/js/common.js')!!}" type="text/javascript"></script>
        {{-- END jQuery Validation js --}}
    </body>

</html>
<script>
$(function () {
    //hide alert message when click on remove icon
    $(".close").click(function () {
        $(this).closest('.alert').addClass('d-none');
    });
});
</script>