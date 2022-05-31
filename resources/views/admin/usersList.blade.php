@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title')
@parent :: {!! 'Users List' !!}
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
                        <h2 class="content-header-title float-left mb-0">Users List</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/{!! ADMIN_SLUG !!}">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Users List
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-header-right text-md-right text-center col-md-3 col-12 mb-2">
                <a href="{!! URL::to(ADMIN_SLUG.'/users/create') !!}" class="btn-icon btn btn-primary dropdown-toggle waves-effect waves-light"><i class="fa fa-plus-square"></i> Add User </a>
            </div>
            
        </div>
        <div class="content-body">
            
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    {{-- Notifications --}}
                                    @include('admin.includes.notifications')
                                    
                                    <div class="table-responsive">
                                        <table class="table zero-configuration table-striped table-bordered" id="pages_list">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th width="10%">Status</th>
                                                    <th width="10%">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@stop
{{-- Scripts --}}
@section('scripts')
<script type="text/javascript">
    var oTable;
    $(document).ready(function () {
        oTable = $('#pages_list').DataTable({
            "dom": "<'row no-gutters'<'col-md-4'l><'col-md-4'r><'col-md-4'f>>t<'row no-gutters'<'col-md-4'i><'col-md-4'><'col-md-4'p>>",
            "processing": true,
            "serverSide": true,
            "ajax": "{!! URL(ADMIN_SLUG.'/users/UsersData') !!}",
            "columnDefs": [
                {"orderable": false, "targets": [1,2,3]},
            ],
            "order": [[0, "asc"]]
        });

        $("#pages_list").on('click', '.delete-btn', function () {
            var id = $(this).attr('id');
            var r = confirm("Are you sure to delete this?");
            if (!r) {
                return false
            }
            $.ajax({
                type: "POST",
                url: "/{!! ADMIN_SLUG !!}/users/" + id,
                data: {
                    _method: 'DELETE',
                    _token: "{!! csrf_token() !!}"
                },
                dataType: 'json',
                beforeSend: function () {
                    $(this).attr('disabled', true);
                    $('.alert .msg-content').html('');
                    $('.alert').hide();
                },
                success: function (resp) {
                    $('.alert:not(".session-box")').show();
                    if (resp.success) {
                        $('.alert-success .msg-content').html(resp.message);
                        $('.alert-success').removeClass('hide');
                    } else {
                        $('.alert-danger .msg-content').html(resp.message);
                        $('.alert-danger').removeClass('hide');
                    }
                    $(this).attr('disabled', false);
                    oTable.draw();
                },
                error: function (e) {
                    alert('Error: ' + e);
                }
            });
        });

        $("#pages_list").on('click', '.status-btn', function () {
            var id = $(this).attr('id');
            var r = confirm("Are you sure to change status?");
            if (!r) {
                return false
            }
            $.ajax({
                type: "POST",
                url: "/{!! ADMIN_SLUG !!}/users/changeStatus",
                data: {
                    id: id,
                    _token: "{!! csrf_token() !!}"
                },
                dataType: 'json',
                beforeSend: function () {
                    $(this).attr('disabled', true);
                    $('.alert .msg-content').html('');
                    $('.alert').hide();
                },
                success: function (resp) {
                    $('.alert:not(".session-box")').show();
                    if (resp.success) {
                        $('.alert-success .msg-content').html(resp.message);
                        $('.alert-success').removeClass('hide');
                    } else {
                        $('.alert-danger .msg-content').html(resp.message);
                        $('.alert-danger').removeClass('hide');
                    }
                    $(this).attr('disabled', false);
                    oTable.draw();
                },
                error: function (e) {
                    alert('Error: ' + e);
                }
            });
        });

    });
</script>
@stop