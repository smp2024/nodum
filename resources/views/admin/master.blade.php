<!DOCTYPE html>
<!--html-->
    <html lang="es">
        <!--head-->
            <head>

                <!--metas-->
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="ie=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <meta name="routeName" content="{{ Route::currentRouteName() }}">

                <!--icon-->
                    <link rel="icon" type="image/png" href="{{ url('multimedia'.$company[0]->file_path.'/'.$company[0]->file) }}" />

                <!--title-->
                    <title>@yield('title')</title>

                <!--CSS-->
                    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
                    <link rel="stylesheet" href="{{ url('/fontawesome/css/all.css') }}">
                    <link rel="stylesheet" href="{{ url('/css/admin.css?v='.time()) }}">
                    <link href="https://cdn.datatables.net/v/dt/dt-2.0.0/datatables.min.css" rel="stylesheet">
                    @yield('css')
            </head>
        <!--body-->
        <style>
            .img-loading {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background-size: 100% auto;
                z-index: 9999;
                width: 80%;
                /* height: 100%;
                justify-content: center;
                display: flex;
                align-items: center;
                text-align: center;
                 */
            }
            .d-none {
                display: none;
            }
        </style>
            <body>
                <div id="loading-animation" class="h-100 d-none" style="z-index: 999; background-color: #000; position:obsolute; width:80%;">
                    <img src="{{ asset('media/icons/loading-9.gif') }}" alt="Loading..." class="img-loading" />
                </div>
                <!--Body content-->
                    <div class="wrapper">

                        <!--Sidebar menu-->
                            <div id="Admin-sidebar" class="col1">
                                @include('admin.sidebar')
                            </div>

                        <!--Content Page-->
                            <div id="Admin-content" class="col2">

                                <!--Navbar-->
                                    @include('admin.navbar')

                                <!--Alert errors-->
                                    @if (Session::has('message'))
                                        <div class="container">
                                            <div class="alert alert-{{ Session::get('typealert') }}" style="display: none;">
                                                {{ Session::get('message') }}
                                                @if ($errors->any())
                                                <div class="alert alert-danger">
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                <!--Content Page-->
                                    @section('content')
                                        hola mundo
                                    @show

                            </div>

                    </div>

                <!--Script-->
                    <script src="{{ asset('js/jquery.js') }}"></script>
                    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
                    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
                    <script src="{{ asset('js/utils.js') }}"></script>
                    {{-- <script src="{{ asset('js/contador.js?v='.time()) }}"></script> --}}
                    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
                    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
                    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
                    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
                    <script src="https://cdn.datatables.net/v/dt/dt-2.0.0/datatables.min.js"></script>
                    <script>
                        $(document).ready(function() {
                            $('[data-toggle="tooltip"]').tooltip();
                        })
                    </script>
                   <script>
                        $('.alert').slideDown();
                        setTimeout(function() {
                            $('.alert').slideUp();
                        }, 3000);
                    </script>
                    <script src="{{ asset('/libs/ckeditor/ckeditor.js') }}"></script>
                    <script src="{{ asset('js/admin.js') }}"></script>


                    @yield('scripts')


            </body>
    </html>
