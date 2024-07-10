@extends('emails.master')

@section('content')

    <p>Hola: <strong>{{ $name }}</strong></p>
    <p>Este es un correo electrónico que le ayudara a reestablecer la contraseña de su cuenta en nuestra plataforma.</p>
    <p>Para continuar haga clic en el siguente boton e ingrese el siguiente codigo: <h2>{{ $code }}</h2></p>
    <p>
        <a href="{{ url('/reset?email='.$email) }}"
                style="display:
                inline-block;
                background-color: #151e45;
                color: #fff;
                padding: 12px;
                border-radius: 4px;
                text-decoration: none;">
            Restablecer mi contraseña
        </a>
    </p>
    <p>Si el boton anterior no funciona, copíe y pegue la siguente url en su navegador:</p>
    <p>{{ url('/reset?email='.$email) }}</p>


@endsection
