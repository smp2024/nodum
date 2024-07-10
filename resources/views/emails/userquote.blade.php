@extends('emails.master')

@section('content')

    <p>Hola: <strong>{{  $user1->name  }}</strong></p>
    <p>Este es el formato en extension PDF que se generó en tu consulta.</p>
    <p>Pronto se pondrá en contacto alguno de nuestros ejecutivos, que tengas un excelente dia.</p>

    <p> Gracias por tu preferencia.</p>
    <p style="padding: 0 20% 0 0">
        <span style="width: 30%;">
            <div class=" col-12     Height100" style="padding: 0%;">
                <div class="row   Height100">
                    <a href="/"  class="EFD_Logo">
                    </a>
                </div>
            </div>
        </span>
        <span style="width: 70%;">
            <div class=" col-12     Height100" style="padding: 0%;">
                <div class="row   Height100">
                    <p style="margin: 0;">Electrón 28, Col. Parque Industrial,
                        <br> Naucalpan de Juárez, Estado de México, 53370.
                        <br>Tel: (+52) 55 56597959
                        <br>Mail: programacion@efd.com.mx</p>
                </div>
            </div>
        </span>
    </p>



@endsection
