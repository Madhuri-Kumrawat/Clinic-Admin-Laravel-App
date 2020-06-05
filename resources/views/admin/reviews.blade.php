@extends('layouts.admin.master')
@section('title', 'Reviews')
@section("mnuReview", "active")
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4 class="m-0 text-dark">Reviews</h4>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url("/") }}">Home</a></li>
                    <li class="breadcrumb-item active">Reviews</li>
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
                            <div class="col-md-12">
                                <table id="tblReviews" class="table dt-responsive table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Profile</th>
                                            <th>Review</th>
                                            <th>Ratting</th>
                                            <th>User</th>
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
      </div>

    <!-- /.row -->
</section>
<!-- /.content -->
@endsection
<!-- page script -->
@section('script-bottom')
<script src="{{ asset('public/js/review.js?JS_VERSION')}}"></script>
@endsection
