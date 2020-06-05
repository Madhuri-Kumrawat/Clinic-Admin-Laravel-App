@extends('layouts.admin.master')
@section('title', 'Send Notification')
@section("mnuNotification", "active")
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Send Notification</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url("/") }}">Home</a></li>
                    <li class="breadcrumb-item active">Send Notification</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- /.card-header -->
                <div class="card-header">
                    @if (session('msg'))
                    <div class="alert alert-success">
                        {{ session('msg') }}
                    </div>
                    @endif
                    <a href="#mdSendNotification" class="btn btn-success float-right" data-toggle="modal">Send Notification</a>
                    <div class="row">
                        <div class="col-md-4">
                            @if(@$specialistTypes)
                            <select class="form-control" name="specialistType" id="specialistType">
                                <option value="">Select Category</option>
                                @foreach($specialistTypes as $type)
                                <option value="{{$type}}">{{$type}}</option> @endforeach
                            </select> 
                            @endif
                        </div>
                    </div>					
                </div>
                <div class="card-body">
                    <table id="tblNotification" class="table nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Message</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
<div id="mdSendNotification" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Notification Message" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Notification Message</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">
                <form name="frmSendNotification" id="frmSendNotification" method="post">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="message" class="control-label">{{ __('Message')}}</label> 
                                <textarea name="message" id="message" class="form-control required" required=""></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button data-complete-text="Submitted!!" data-loading-text="Submitting..." id="btnSendNotification" class="btn btn-info waves-effect waves-light">Submit</button>
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
<!-- page script -->
@section('script-bottom')
<script src="{{ URL::asset('public/js/notification.js?JS_VERSION')}}"></script>
@endsection
