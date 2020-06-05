@extends('layouts.admin.master')
@section('title', 'Specialists')
@section("mnuSpecialists", "active")
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Specialists</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url("/") }}">Home</a></li>
                    <li class="breadcrumb-item active">Specialists</li>
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                @if(@$specialistTypes) 
                                <select class="form-control"
                                        name="specialistType" id="specialistType">
                                    <option value="">Select Category</option>
                                    @foreach($specialistTypes as $type)
                                    <option value="{{$type}}">{{$type}}</option> @endforeach
                                </select> 
                                @endif
                            </div>
                            <div class="col-md-8 text-right">
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#mdAddSpecialist">
                                    Add New Specialist
                                </button>
                            </div>
                        </div>		
                        <table id="tblSpecialist" class="table dt-responsive table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Icon</th>
                                    <th>Name</th>
                                    <th>Type</th>
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
    </div>
</section>
<!-- /.content -->
<div id="mdAddSpecialist" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Specialist</h4>
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">
                <form name="frmAddCity" id="frmAddSpecialist">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="specialistName" class="control-label">{{ __('Specialist Name')
                                    }}</label> <input type="text" id="specialistName" name="specialistName"
                                                  class="form-control" placeholder="Enter Specialist Name" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                @if(@$specialistTypes)
                                <label for="specialistName" class="control-label">{{ __('Specialist Name')}}</label> 
                                <select class="form-control" name="specialist_type" id="specialist_type" required="">
                                    <option value="">Select Category</option>
                                    @foreach($specialistTypes as $type)
                                    <option value="{{$type}}">{{$type}}</option> 
                                    @endforeach
                                </select>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="imageFile" class="control-label">Upload Image</label>
                                <input class="form-control" name="imageFile" type="file"
                                       id="imageFile" accept="image/*"> 

                            </div>
                        </div>
                        <div class="col-md-6 divPreview" style="display:none;">
                            <div class="form-group">
                                <img class="col-sm-6" id="preview" src="" width="100" height="100">
                            </div>
                        </div>								
                    </div>
                    <input type="hidden" name="specialistImage" id="specialistImage"  value="">
                    <input type="hidden" name="specialistId" id="specialistId"
                           value="">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect"
                        data-dismiss="modal">Close</button>
                <button data-complete-text="Submitted!!"
                        data-loading-text="Submitting..." id="btnAddSpecialist"
                        class="btn btn-info waves-effect waves-light">Submit</button>
            </div>
        </div>
    </div>
</div>
@endsection
<!-- page script -->
@section('script-bottom')
<script src="{{ URL::asset('public/js/specialists.js?JS_VERSION')}}"></script>
@endsection
