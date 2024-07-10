@extends('master')

@section('title', 'Login')

@section('content')

    <div class=" text-center justify-content-center align-items-center Height100">
        <div class="card-body justify-content-center align-items-center Height100" style="width: 100%;">

            <h1 class="Title_Login">¡Bienvenido a {{ config('app.name') }}!</h1>

            <form method="POST" action="{{ route('login') }}" style=" " class="Acceso Title_Login">
                @csrf

                <div class=" form-group row justify-content-center align-items-center">
                    <div class="col-12 col-lg-6 ml">
                        <p >Usuario (correo electrónico) </p>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row justify-content-center align-items-center">

                    <div class="col-12 col-lg-6 ml">
                        <p >Contraseña</p>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="" required autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row justify-content-center align-items-center mb-0" style="margin-top: 30px;">
                    <div class="col-12 Title_Login">
                        <button type="submit" class="btn btn-info">
                            {{ __('Iniciar sesión') }}
                        </button>
                    </div>
                    <div class="col-12 Title_Login">

                        <a class="btn btn-link" href="{{ url('/recover') }}" >
                            {{ __('No recuerdas tu contraseña?') }}
                        </a>

                    </div>
                </div>

            </form>
            <div class="col-12 Title_Login">
                <p >¿No tienes cuenta? <a href="{{ route('register') }}" >Crear cuenta aquí</a></p>
            </div>
        </div>
    </div>

@stop

@section('scripts')



@endsection
