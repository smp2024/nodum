@extends('emails.master')

@section('content')

    <p>Hola: <strong>{{ $name }}</strong></p>
    <p>La nueva contraseña asiganda es:</p>
    <p>{{ $password }}</p>
    <p>Para iniciar sesión haga clic en el siguiente botón</p>
    <p>
        <a href="{{ url('/login') }}"
                style="display:
                inline-block;
                background-color: #151e45;
                color: #fff;
                padding: 12px;
                border-radius: 4px;
                text-decoration: none;">
            Ingresar a mi cuenta
        </a>
    </p>
    <p>{{ url('/login') }}</p>

@endsection
