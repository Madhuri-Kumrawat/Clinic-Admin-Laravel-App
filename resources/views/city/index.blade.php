@extends('layouts.app')
@section('title', 'City')
@section("mnuCity", "active")
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">City</h1>
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- /.card-header -->
                <div class="card-header">
                    <button type="button" class="btn btn-primary float-right" onclick="javascript:self.location='{{ url("city/create")}}'"><i class="fas fa-plus"></i> Add City</button>
                </div>
                <div class="card-body">
                    <table id="tblCity" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Rendering engine</th>
                                <th>Browser</th>
                                <th>Platform(s)</th>
                                <th>Engine version</th>
                                <th>CSS grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 4.0
                                </td>
                                <td>Win 95+</td>
                                <td> 4</td>                                
                                <td><a href="" class=""><i class="fas fa-edit"></i> Edit</a>  |  <a class=""><i class="fas fa-trash"></i> Delete</a></td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.0
                                </td>
                                <td>Win 95+</td>
                                <td>5</td>
                                <td>C</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 5.5
                                </td>
                                <td>Win 95+</td>
                                <td>5.5</td>
                                <td>A</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet
                                    Explorer 6
                                </td>
                                <td>Win 98+</td>
                                <td>6</td>
                                <td>A</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet Explorer 7</td>
                                <td>Win XP SP2+</td>
                                <td>7</td>
                                <td>A</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>AOL browser (AOL desktop)</td>
                                <td>Win XP</td>
                                <td>6</td>
                                <td>A</td>
                            </tr>
                            <tr>
                                <td>Gecko</td>
                                <td>Firefox 1.0</td>
                                <td>Win 98+ / OSX.2+</td>
                                <td>1.7</td>                                
                                <td><a href="" class="text-info"><i class="fas fa-edit"></i> Edit</a>  |  <a class="text-danger"><i class="fas fa-trash"></i> Delete</a></td>
                            </tr>
                            <tr>
                                <td>Gecko</td>
                                <td>Firefox 1.5</td>
                                <td>Win 98+ / OSX.2+</td>
                                <td>1.8</td>                                
                                <td><a href="" class="text-info"><i class="fas fa-edit"></i> Edit</a>  |  <a class="text-danger"><i class="fas fa-trash"></i> Delete</a></td>
                            </tr>
                            <tr>
                                <td>Gecko</td>
                                <td>Firefox 2.0</td>
                                <td>Win 98+ / OSX.2+</td>
                                <td>1.8</td>                                
                                <td><a href="" class="text-info"><i class="fas fa-edit"></i> Edit</a>  |  <a class="text-danger"><i class="fas fa-trash"></i> Delete</a></td>
                            </tr>
                            <tr>
                                <td>Gecko</td>
                                <td>Firefox 3.0</td>
                                <td>Win 2k+ / OSX.3+</td>
                                <td>1.9</td>                                
                                <td><a href="" class="text-info"><i class="fas fa-edit"></i> Edit</a>  |  <a class="text-danger"><i class="fas fa-trash"></i> Delete</a></td>
                            </tr>
                            <tr>
                                <td>Gecko</td>
                                <td>Camino 1.0</td>
                                <td>OSX.2+</td>
                                <td>1.8</td>                                
                                <td><a href="" class="text-info"><i class="fas fa-edit"></i> Edit</a>  |  <a class="text-danger"><i class="fas fa-trash"></i> Delete</a></td>
                            </tr>
                            <tr>
                                <td>Gecko</td>
                                <td>Camino 1.5</td>
                                <td>OSX.3+</td>
                                <td>1.8</td>                                
                                <td><a href="" class="text-info"><i class="fas fa-edit"></i> Edit</a>  |  <a class="text-danger"><i class="fas fa-trash"></i> Delete</a></td>
                            </tr>
                            <tr>
                                <td>Gecko</td>
                                <td>Netscape 7.2</td>
                                <td>Win 95+ / Mac OS 8.6-9.2</td>
                                <td>1.7</td>                                
                                <td><a href="" class="text-info"><i class="fas fa-edit"></i> Edit</a>  |  <a class="text-danger"><i class="fas fa-trash"></i> Delete</a></td>
                            </tr>
                            <tr>
                                <td>Gecko</td>
                                <td>Netscape Browser 8</td>
                                <td>Win 98SE+</td>
                                <td>1.7</td>                                
                                <td><a href="" class="text-info"><i class="fas fa-edit"></i> Edit</a>  |  <a class="text-danger"><i class="fas fa-trash"></i> Delete</a></td>
                            </tr>
                            <tr>
                                <td>Gecko</td>
                                <td>Netscape Navigator 9</td>
                                <td>Win 98+ / OSX.2+</td>
                                <td>1.8</td>                                
                                <td><a href="" class="text-info"><i class="fas fa-edit"></i> Edit</a>  |  <a class="text-danger"><i class="fas fa-trash"></i> Delete</a></td>
                            </tr>
                            <tr>
                                <td>Gecko</td>
                                <td>Mozilla 1.0</td>
                                <td>Win 95+ / OSX.1+</td>
                                <td>1</td>                                
                                <td><a href="" class="text-info"><i class="fas fa-edit"></i> Edit</a>  |  <a class="text-danger"><i class="fas fa-trash"></i> Delete</a></td>
                            </tr>
                            <tr>
                                <td>Gecko</td>
                                <td>Mozilla 1.1</td>
                                <td>Win 95+ / OSX.1+</td>
                                <td>1.1</td>
                                <td>A</td>
                            </tr>
                        </tbody>
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
@endsection
<!-- page script -->
@section("footer")
<script>
    $(function () {
        $('#tblCity').DataTable();
    });
</script>
@endsection
