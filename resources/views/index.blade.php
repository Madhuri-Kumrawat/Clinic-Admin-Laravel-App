<?php
use App\Models\Specialist;
use App\Models\City;
use App\Models\Review;
use App\User;
?>
@extends('layouts.admin.master')
@section('title', 'Dashboard')
@section("mnuDashboard", "active")
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dashboard</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-user-md"></i></span>
                    <div class="info-box-content text-right">
                        <h5 class="info-box-text">Doctors</h5>
                        <span class="info-box-number">
                            <?php 
                                echo Specialist::where('specialist_type','Doctor')->whereNull('deleted_at')->count();
                            ?>
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div>
            <!-- ./col -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-prescription"></i></span>
                    <div class="info-box-content text-right">
                        <h5 class="info-box-text">Pharmacy</h5>
                        <span class="info-box-number">
                            <?php 
                                 echo Specialist::where('specialist_type','Pharmacy')->whereNull('deleted_at')->count();
                            ?>
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div>
            <!-- ./col -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-hospital"></i></span>
                    <div class="info-box-content text-right">
                        <h5 class="info-box-text">Hospitals</h5>
                        <span class="info-box-number">
                            <?php 
                                 echo Specialist::where('specialist_type','Hospital')->whereNull('deleted_at')->count();
                            ?>
                        </span>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-stethoscope"></i></span>
                    <div class="info-box-content text-right">
                        <h5 class="info-box-text">Specialties</h5>
                        <span class="info-box-number">
                            <?php 
                                 echo Specialist::whereNull('deleted_at')->count();
                            ?>
                        </span>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-pink elevation-1"><i class="fas fa-city"></i></span>
                    <div class="info-box-content text-right">
                        <h5 class="info-box-text">City</h5>
                        <span class="info-box-number">
                           <?php 
                                 echo City::whereNull('deleted_at')->count();
                            ?>
                        </span>
                    </div>
                </div>
            </div>
            <!-- ./col -->

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-blue elevation-1"><i class="fas fa-city"></i></span>
                    <div class="info-box-content text-right">
                        <h5 class="info-box-text">Reviews</h5>
                        <span class="info-box-number">
                            <?php 
                                 echo Review::whereNull('deleted_at')->count();
                            ?>
                        </span>
                    </div>
                </div>
            </div>
            <!-- ./col -->

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-users"></i></span>
                    <div class="info-box-content text-right">
                        <h5 class="info-box-text">App Users</h5>
                        <span class="info-box-number">
                            <?php 
                                 echo User::join('role_user','users.id','=','role_user.user_id')->where('role_id',1)->whereNull('deleted_at')->count();
                            ?>
                        </span>
                    </div>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
