@extends('layouts.admin.master') @section('title', 'Notification Setting')
@section("mnuNotificationSetting", "active") @section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Notification Setting</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Notification Setting</li>
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
            <div class="card card-info">
                <!-- /.card-header -->
                <div class="card-header">
                    <h3 class="card-title">Filling Up Notification Detail</h3>
                </div>
                <div class="card-body">
                    <form name="frmNotificationSetting" id="frmNotificationSetting" method="post" action="{{ url('admin/save-notification-setting')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="apikey" class="control-label">{{__('Google API Key')}}</label>
                                    <input type="text" name="apikey" id="apikey" class="form-control required" required="" value="{{ old('apikey', @$notification->apikey) }}" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="passphrace" class="control-label">{{__('Apns Passphrace')}}</label>
                                    <input type="text" name="passphrace" id="passphrace"  value="{{old('passphrace', @$notification->passphrace)}}" class="form-control required" required="" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="file" class="control-label">{{__('Upload Certificate')}}</label>
                                    <input type="file" class="form-control required" name="file" id="file" accept=".pem" required />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="linkedin" class="control-label">{{__('Environment')}}</label>
                                    <select class="form-control required" name="environment" id="environment" required>
                                        <option value="">Select </option>
                                        <option value="gateway.push.apple.com" {{old('environment', @$notification->environment) == "gateway.push.apple.com" ? "selected": ""}}>Live</option>
                                        <option value="gateway.sandbox.push.apple.com" {{old('environment', @$notification->environment)  == "gateway.sandbox.push.apple.com" ? "selected": ""}}>Sandbox</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" data-complete-text="Submitted!!" data-loading-text="Submitting..." id="btnAddProfile" class="btn btn-info waves-effect waves-light">Submit</button>
                        </div>
                    </form>
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
@endsection
<!-- page script -->
@section('script-bottom')
<script type="text/javascript" src="{{ URL::asset('public/js/notification_setting.js?JS_VERSION')}}"></script>
@endsection
