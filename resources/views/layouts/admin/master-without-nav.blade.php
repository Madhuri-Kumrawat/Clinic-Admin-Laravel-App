<!DOCTYPE html>
<html lang="en">
    <head>
       	<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Clinic Admin Panel Login Witch control android and ios application data.">
        <meta name="keyword" content="Mobile App With Web development and design technology">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>
        <link rel="shortcut icon" href="{{ url("storage/uploads/logo.png") }}" type="image/png" /> 

        @include('layouts.admin.head')
    </head>

    @yield('body')

    @yield('content')

    @include('layouts.admin.footer-script') 
    <script>
        var APP_URL = {!! json_encode(url('/')) !!}
        ;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</body>
</html>