@extends('layouts.admin.master')
@section('title', 'Profile')
@section("mnuProfile", "active")
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Profile</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url("/") }}">Home</a></li>
                    <li class="breadcrumb-item active">Profile</li>
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
                    <a href="{{url('admin/profile_detail')}}" class="btn btn-success float-right">Add New Profile</a>
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
                    <table id="tblProfile" class="table dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>Icon</th>
                                <th>Profile Name</th>
                                <th>Specialist</th>
                                <th>Contact Info</th>
                                <th>Hours</th>
                                <th>Created At</th>
                                <th>Action</th>
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
<div id="mdAddProfile" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Profile</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">
                <form name="frmAddProfile" id="frmAddProfile" method="post">
                		
                    <input type="hidden" id="profileId" name="profileId" value="" />
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                @if(@$specialistTypes)
                                <label for="specialist_type" class="control-label">{{ __('Specialist Type')}}</label> 
                                <select class="form-control" name="specialist_type" id="specialist_type" required="">
                                    <option value="">Select Type</option>
                                    @foreach($specialistTypes as $type)
                                    <option value="{{$type}}">{{$type}}</option> 
                                    @endforeach
                                </select>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="specialist_id" class="control-label">{{ __('Specialist Name')}}</label> 
                                <select class="form-control" name="specialist_id" id="specialist_id" required="">
                                    <option value="">Select Name</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button data-complete-text="Submitted!!" data-loading-text="Submitting..." id="btnAddProfile" class="btn btn-info waves-effect waves-light">Submit</button>
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
<!-- page script -->
@section('script-bottom')
<script src="{{ URL::asset('public/js/profile.js?JS_VERSION')}}"></script>
@endsection
