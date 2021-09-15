<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel Test</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.12/css/bootstrap-select.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

        @yield('before-css')

        <style>
            #loader {
                position: fixed;
                /* Sit on top of the page content */
                display: block;
                /* Hidden by default */
                width: 100%;
                /* Full width (cover the whole page) */
                height: 100%;
                /* Full height (cover the whole page) */
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                //background-color: rgba(0, 0, 0, 0.865);
                /* Black background with opacity */
                z-index: 2;
                /* Specify a stack order in case you're using a different order for other elements */
                cursor: pointer;
                /* Add a pointer on hover */
            }
        </style>
        @yield('page-css')
    </head>

    <body>
        <div class="container-fluid">

            @include('layouts.header-menu')

            <div class="d-flex flex-column" style="margin-top: 100px;">
                @yield('main-content')

                @include('layouts.footer')


            </div>

        </div>

    </body>

</html>