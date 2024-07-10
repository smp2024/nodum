@extends('master')
@section ('content')

    <div id="email" class="row justify-content-center align-items-center Height100" style="padding: 4% 0% 0% 0%;">
        
        
        <div class="col-12 justify-content-center align-items-center Height40" style="padding: 0%;">
            <div class="row justify-content-center align-items-center Height100" style="padding: 0;">
                 <h1>Hola {{ $userf->name }}</h1>
                 <h4> Hemos enviado un correo electrónico a: {{ $userf->email }}</h4>
                 <h5> Con las instrucciones para activar su cuenta.</h5>
   
            </div>
         </div>
    </div>


@endsection 