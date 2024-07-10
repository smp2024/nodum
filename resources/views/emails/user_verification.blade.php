@extends('emails.master')

@section('content')

    <h2>Le damos la bienvenida a la Ciudad Océano</h2>
    <p>Hola: <strong>{{ $name }}</strong></p>
    <p>Este es un correo electrónico que le ayudara a activar su cuenta en nuestra plataforma.</p>
    <p>Para activar su cuenta haga clic en el siguente boton e ingrese el siguiente codigo: <h2>{{ $code }}</h2></p>
    <p>
    <p>
        <a href="{{ url('/verification?email='.$email) }}"
                style="display: inline-block;
                background-color: #151e45;
                color: #fff;
                padding: 12px;
                border-radius: 4px;
                text-decoration: none;
                width: 500px;
                font-size: 38px;
                text-align: center;">
            VERIFICAR
        </a>
    </p>
    <p>Si el boton anterior no funciona, copíe y pegue la siguente url en su navegador:</p>
    <p>{{ url('/verification?email='.$email) }}</p>


@endsection
