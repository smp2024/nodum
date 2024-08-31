<!DOCTYPE html>
<!--html-->
    <html lang="es">
        <!--head-->
            <head>

                <!--metas-->
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="ie=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <meta name="routeName" content="{{ Route::currentRouteName() }}">
                    <meta name="description" content="{{$company[0]->description}}"/>

                <!--icon-->
                    <link rel="icon" type="image/png" href="{{ url('multimedia'.$company[0]->file_path.'/'.$company[0]->file) }}" />

                <!--title-->

                    <title> @yield('title')</title>

                <!--CSS-->
                    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
                    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
                    <link rel="stylesheet" href="{{ url('/fontawesome/css/all.css') }}">
                    <link rel="stylesheet" href="{{ url('/css/style.css?v='.time()) }}">

                    <link rel="stylesheet" href="{{ url('/css/font.css?v='.time()) }}">
                    <link rel="stylesheet" href="{{ url('/css/querys.css?v='.time()) }}">
                    <link rel="stylesheet" href="{{ url('/css/review.css?v='.time()) }}">
                    @yield('css')

            </head>
        <!--body-->
            <body>
                <!--CookieConsent-->
                    @include('cookieConsent::index')

                <!--NavBar-->
                    @include('blog.partials.navbar')

                <!--Alert errors-->
                    @if (Session::has('message'))
                        <div class="container mt-2">
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

                <!--Content-->
                <div class="cont__ "  >
                    @yield('content')
                </div>

                <!--Script-->
                    <script src="{{ asset('js/jquery.js') }}"></script>
                    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
                    <script src="{{ asset('js/utils.js') }}"></script>
                    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
                    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
                    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
                    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
                    <script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
                    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
                    <script src="{{ asset('js/site.js') }}"></script>
                    <script src="{{ asset('js/bold.js') }}"></script>
                    {{-- <script src="{{ asset('js/contador.js?v='.time()) }}"></script> --}}

                <!--individual-Script-page-->
                    @yield('scripts')

            </body>
    </html>

