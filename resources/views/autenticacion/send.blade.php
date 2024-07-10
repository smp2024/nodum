@extends('master')
@section ('content')

    <div id="email" class="row justify-content-center align-items-center Height100" style="padding: 4% 0% 0% 0%;">
        <div id="mandala-send" class="col-lg-12 col-sm-12 justify-content-center align-items-center Height60" style="padding: 0%;">
            <div class="mandala-send row justify-content-center align-items-center Height100" style="padding: 0;"></div>
        </div>

        <div class="col-lg-12 col-sm-12 justify-content-center align-items-center Height40" style="padding: 0%;">
            <div class="row justify-content-center align-items-center Height100" style="padding: 0;">
                <h4> Hemos enviado un correo electrónico a: {{ $userf->email }}</h4>
                 <h4>Con los ultimos pasos para restablecer su contraseña.</h4>
                

            </div>
         </div>
    </div>


@endsection
