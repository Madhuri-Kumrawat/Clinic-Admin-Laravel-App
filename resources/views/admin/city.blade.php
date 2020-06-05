@extends('layouts.admin.master')
@section('title', 'City')
@section("mnuCity", "active")
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4 class="m-0 text-dark">City</h4>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url("/") }}">Home</a></li>
                    <li class="breadcrumb-item active">City</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-right mb-3">
                                <button type="button" class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#mdAddCity">Add New City</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table id="tblCity" class="table dt-responsive table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>City</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>                        
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <div id="mdAddCity" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"> City </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body p-4">
                        <form name="frmAddCity" id="frmAddCity">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cityName" class="control-label">{{ __('City Name') }}</label>
                                        <input type="text" id="cityName" name="cityName"  class="form-control" placeholder="Enter City" required="">
                                    </div>
                                </div>
                            </div> 
                            <input type="hidden" name="cityId" id="cityId" value="">
                        </form>
                    </div>
                    <div class="modal-footer text-right">
                        <button data-complete-text="Submitted!!" data-loading-text="Submitting..." id="btnAddCity" class="btn btn-info waves-effect waves-light">
                            Submit
                        </button>
                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    </div>
                </div>        
            </div>
        </div>
    </div>

    <!-- /.row -->
</section>
<!-- /.content -->
@endsection
<!-- page script -->
@section('script-bottom')
<script src="{{ asset('public/js/city.js?JS_VERSION')}}"></script>
@endsection
