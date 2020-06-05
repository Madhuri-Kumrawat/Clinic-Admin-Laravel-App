@extends('layouts.app')
@section('title', 'Create City')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Create City</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url("/") }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url("/city") }}">City</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-12">
            <form id="frmCity" action="{{ url("city/store") }}" method="post" role="form">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">City Name</label>
                            <input type="name" class="form-control required" required="" id="name" placeholder="Enter Name">
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </div>
            </form>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
@endsection
<!-- page script -->
@section("footer")
<script>
    $(function () {
        $('#tblCity').DataTable();
    });
</script>
@endsection
