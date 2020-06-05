@extends('layouts.admin.master') @section('title', 'Profile')
@section("mnuProfile", "active") @section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Profile Detail</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item">Profile</li>
                    <li class="breadcrumb-item active">Profile Detail</li>
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
                <div class="card-body">
                    <form name="frmAddProfile" id="frmAddProfile" method="post" action="{{url('admin/save-profile')}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="profileId" name="profileId" value="{{ $profile->id}}" />
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    @if(@$specialistTypes) 
                                    <label for="specialist_type" class="control-label">{{ __('Specialist Type')}}</label>
                                    <select class="form-control" name="specialist_type" id="specialist_type" required="">
                                        <option value="">Select Type</option>
                                        @foreach($specialistTypes as $type)
                                        <?php $selected = (old('specialist_type', $profile->specialist_type) == $type) ? " selected " : ''; ?>  
                                        <option value="{{$type}}" <?php echo $selected; ?> >{{$type}}</option> 
                                        @endforeach
                                    </select> 
                                    @endif
                                    @if ($errors->has('specialist_type'))
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required"><strong>{{$errors->first('specialist_type') }}</strong></li>
                                    </ul>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="specialist_id" class="control-label">{{ __('Specialist Name')}}</label>
                                    <select class="form-control" name="specialist_id" id="specialist_id" data-selected-value="{{ old('specialist_id',$profile->specialist_id) }}">
                                        <option value="">Select Name</option>
                                    </select>
                                    @if ($errors->has('specialist_id'))
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required"><strong>{{$errors->first('specialist_id') }}</strong></li>
                                    </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="about" class="control-label">{{__('Name')}}</label> 
                                    <input type="text" name="name" id="name" value="{{ old("name", $profile->name)}}" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="imageFile" class="control-label">Upload Image</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="hidden" name="hdnImageFile" value="{{ $profile->icon }}" />
                                            <input type="file" class="custom-file-input" name="imageFile" id="imageFile" accept="image/*" />
                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 divPreview">
                                <div class="form-group">
                                    <?php
                                    $imgSrc = 'storage/uploads/default_user.jpg';
                                    if ($profile->icon) {
                                        $imgSrc = $profile->icon;
                                    }
                                    ?>                                    
                                    <img id="preview" class="img-thumbnail" src="{{ url($imgSrc) }}" alt="" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="profile_email" class="control-label">{{__('Email')}}</label>
                                    <input type="email" id="profile_email" name="profile_email" class="form-control{{ $errors->has('profile_email') ? ' is-invalid ' : '' }}" required="" value="{{old('profile_email',$profile->email)}}" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="phone" class="control-label">{{__('Phone')}}</label>
                                    <input type="text" class="form-control" name="phone" id="phone" value="{{old('phone',$profile->phone)}}" required data-inputmask="'mask': ['999-999-9999 [x99999]', '+099 99 99 9999[9]-9999']" data-mask="" />
                                    @if ($errors->has('phone'))
                                    <ul class="parsley-errors-list filled">
                                        <li class="parsley-required"><strong>{{$errors->first('phone') }}</strong></li>
                                    </ul>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="services" class="control-label">{{__('Services')}}</label>
                                    <input type="text" name="services" id="services" class="form-control" value="{{ old('services', $profile->services) }}" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="about" class="control-label">{{__('About/Description')}}</label>
                                    <input type="text" name="about"id="about" class="form-control" value="{{ old('about',$profile->about) }}" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="start_office_hours" class="control-label">{{__('Start Office Hours') }}</label>
                                <div class="input-group date" id="start_office_hours" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#start_office_hours" id="start_office_hours" name="start_office_hours" placeholder="Schedule Time.." value="{{ old('start_office_hours',$profile->start_hours) }}" />
                                    <div class="input-group-append" data-target="#start_office_hours" data-toggle="datetimepicker" />
                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                </div>
                            </div>
                            @if ($errors->has('start_office_hours'))
                            <ul class="parsley-errors-list filled">
                                <li class="parsley-required"><strong>{{$errors->first('start_office_hours') }}</strong></li>
                            </ul>
                            @endif
                        </div>
                        <div class="col-md-3">
                            <label for="end_office_hours" class="control-label">{{__('End Office Hours') }}</label>
                            <div class="input-group date" id="end_office_hours" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#end_office_hours" id="end_office_hours" name="end_office_hours" placeholder="Schedule Time.." value="{{ old('end_office_hours',$profile->end_hours) }}" />
                                <div class="input-group-append" data-target="#end_office_hours" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                </div>
                            </div>
                            @if ($errors->has('end_office_hours'))
                            <ul class="parsley-errors-list filled">
                                <li class="parsley-required"><strong>{{$errors->first('end_office_hours') }}</strong></li>
                            </ul>
                            @endif
                        </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            @if(@$cities) 
                            <label for="city" class="control-label">{{ __('City') }}</label>
                            <select class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}" name="city" id="city" required="" style="width: 100%;" placeholder="Select City">
                                <option value="">Select City</option>
                                @foreach($cities as $city)
<?php $selected = (old('city', $profile->cityId) == $city->id) ? " selected " : ''; ?>                                       
                                <option value="{{$city->id}}"  <?php echo $selected; ?>>{{$city->name}}</option>
                                @endforeach
                            </select> 
                            @endif
                            @if ($errors->has('city'))
                            <ul class="parsley-errors-list filled">
                                <li class="parsley-required"><strong>{{$errors->first('city') }}</strong></li>
                            </ul>
                            @endif
                        </div>                                
                        <div class="form-group">
                            <label for="address" class="control-label">{{__('Address')}}</label>
                            <input type="text" name="address" id="address"  value="{{old('address',$profile->address)}}"  class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="lat" class="control-label">{{__('Latitude')}}</label>
                            <input type="text" name="lat" id="lat"  value="{{old('lat',$profile->lat)}}" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="lon" class="control-label">{{__('Longitude')}}</label>
                            <input type="text" name="lon" id="lon" value="{{old('lon',$profile->lon)}}" class="form-control" />
                        </div>
                    </div>                            
                    <div class="col-md-6">
                        <div id="googleMap" style="width:100%;height: 95%;border:1px solid #000;"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="google_plus" class="control-label">{{__('Google Plus')}}</label> 
                            <input type="text" name="google_plus" id="google_plus" class="form-control" value="{{old('google_plus',$profile->google_plus)}}" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="facebook" class="control-label">{{__('Facebook')}}</label>
                            <input type="text" name="facebook" id="facebook" class="form-control" value="{{old('facebook',$profile->facebook)}}" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="twiter" class="control-label">{{__('Twiter')}}</label>
                            <input type="text" name="twiter" id="twiter" class="form-control" value="{{old('twiter',$profile->twiter)}}" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="linkedin" class="control-label">{{__('Linkedin')}}</label>
                            <input type="text" name="linkedin" id="linkedin"  value="{{old('linkedin',$profile->linkedin)}}" class="form-control" />
                        </div>
                    </div>
                </div>
                <button type="submit" data-complete-text="Submitted!!" data-loading-text="Submitting..." id="btnAddProfile" class="btn btn-info waves-effect waves-light">Submit</button>
                <button type="reset" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
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
<script type="text/javascript" src='http://maps.google.com/maps/api/js?key=dfgsfgsjhf&libraries=places'></script>
<script type="text/javascript" src="{{ URL::asset('public/js/locationpicker.js?JS_VERSION')}}"></script>
<script type="text/javascript" src="{{ URL::asset('public/js/profile_detail.js?JS_VERSION')}}"></script>
@endsection
