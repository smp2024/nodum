@extends('master')

@section('title',  $vpn->name )

@section('content')
    {{-- vista general de la obra --}}
    <div id="Obra"  class="col-12" style="padding-top: 5%; margin-bottom: 10%;">
        <div class="row " >
            <div id="img-obra" class="col-lg-7 col-md-12 col-12 d-flex justify-content-center align-items-center p-0 w-100" >
                <div class="content-obra-img" style="background-size: 100% auto !important; background-color: #fff !important; ');" >
                    {{-- <img class="w-100 h-100 grayscale " src="{{ url('multimedia'.$vpn->file_path.'/'.$vpn->slug.'/'.$vpn->file) }}" alt="{{ $article->name }}" class="" style="filter: grayscale(100%);" > --}}
                    <img id="fullscreen-img" class="w-100  grayscale clickable" src="{{ url('multimedia'.$vpn->file_path.'/'.$vpn->slug.'/'.$vpn->file) }}" alt="{{ $article->name }}" style="    margin-bottom: 10%;" >

                </div>
            </div>
            <div class="col-lg-5  col-md-12 col-12" style="padding-top: 5rem !important;" >
                <p class="w-100 artist-name">{!!  html_entity_decode($vpn->name, ENT_QUOTES | ENT_XML1, 'UTF-8')  !!} {!!  html_entity_decode($vpn->lastname, ENT_QUOTES | ENT_XML1, 'UTF-8')  !!}</p>
                @foreach ($artistas_ as $artista)
                    @if ($artista->id == $vpn->artist_id)

                        <p class="w-100 artist-year">{{ $artista->name }} {{ $artista->lastname }}</p>
                    @endif
                @endforeach

                @foreach ($tecnicas as $item)
                    @if ( $vpn->subcategory_id == $item->id)
                        <p class="w-100 artist-year">{{ $item->name }}</p>
                    @endif
                @endforeach
                <p class="w-100 artist-year">{{ $vpn->year }}</p>
                <p class="w-100 artist-year">{{ $vpn->width }} x {{ $vpn->height }}  cm</p>
                <br>
                <br>
                <button  type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#modalSelectContacto" data-whatever=" + info">
                    + info
                </button>

            </div>
        </div>
    </div>
    {{-- modal enviar email --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pedir información de {{ $vpn->name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::open(['url' => '/descargar-contacto', 'files' => true]) !!}

                    <div class="row" >

                        <div class="col-md-6 col-12 mt-1">

                            {!! Form::label('name','*Nombre(s):') !!}
                            <div class="input-group">
                                {!! Form::text('name', null, [ 'class' => 'form-control', 'required' => 'required']) !!}
                            </div>

                        </div>
                        <div class="col-md-6 col-12 mt-1">

                            {!! Form::label('lastname','*Apellidos:') !!}
                            <div class="input-group">
                                {!! Form::text('lastname', null, [ 'class' => 'form-control', 'required' => 'required']) !!}
                            </div>

                        </div>
                        <div class="col-md-6 col-12 mt-1">

                            {!! Form::label('email','*Correo electrónico:') !!}
                            <div class="input-group">
                                {!! Form::text('email', null, [ 'class' => 'form-control', 'required' => 'required']) !!}
                            </div>

                        </div>
                        <div class="col-md-6 col-12 mt-1">

                            {!! Form::label('phone','*Teléfono:') !!}
                            <div class="input-group">
                                {!! Form::text('phone', null, [ 'class' => 'form-control', 'required' => 'required']) !!}
                            </div>

                        </div>
                        <div class="col-12 mt-1 d-none">

                            {!! Form::label('description','*Descripción:') !!}
                            <div class="input-group">
                                {!! Form::textarea('description', 'Solicita información acerca de la siguiente obra: ' .$vpn->name, [
                                    'class'      => 'form-control ',
                                    'rows'       => 3,
                                    'name'       => 'description',
                                    'id'         => 'description',
                                    'value'      => 'Solicita información acerca de la siguiente obra: ' .$vpn->name ,
                                ])!!}
                            </div>

                        </div>

                        <div class="col-12 mt-2 justify-content-center align-items-center">
                        {!! Form::submit('Enviar', ['class' => 'btn btn-success mt16  float-right']) !!}
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
            </div>
        </div>
    </div>
    {{-- modal seleccionar forma de contacto --}}
    <div class="modal fade" id="modalSelectContacto" tabindex="-1" aria-labelledby="modalSelectContactoLabel" aria-hidden="true">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSelectContactoLabel">Pedir información de <span id="article_name">{{ $vpn->name }}</span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row" >

                        <div class="col-md-6 col-12 mt-1">
                            <button  type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#exampleModal" data-whatever="Email" aria-label="Close" data-dismiss="modal">
                                Email
                            </button>
                        </div>
                        <div class="col-md-6 col-12 mt-1">
                            <button id="refSharedWhatsApp"  type="button" class="btn btn-outline-dark" data-whatever="WhatsApp ">
                                WhatsApp
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
          $(document).ready(function(){

        var urlElements = window.location.pathname.split('/').filter(function(element) {
            return element !== '';
        });

        var element1 = urlElements[0];
        var element2 = urlElements[1];
        var navbarElements = document.querySelectorAll('.nav-item a');


        var url = window.location.href;
        var urlParts = url.split('/');
        urlParts.pop();
        const finURL = urlParts.join('/');

        navbarElements.forEach(function(element) {
            const urr = element.attributes[1].nodeValue

            if (urr === finURL) {
                element.classList.add('active');
            }

        });

        $('.image-container').mousemove(function(e){
            var x = e.pageX - $(this).offset().left;
            var y = e.pageY - $(this).offset().top;
            $(this).children('img').css({'transform-origin': x + 'px ' + y + 'px'});
            $(this).children('img').css({'transform': 'scale(2)'});
        });
        $('.image-container').mouseleave(function(e){
            $(this).children('img').css({'transform': 'scale(1)'});
        });
        });


        document.addEventListener('DOMContentLoaded', function() {
            var img = document.getElementById('fullscreen-img');

            // Agregar evento de clic a la imagen
            img.addEventListener('click', function() {
                toggleFullScreen(img);
            });

            // Función para alternar entre pantalla completa
            function toggleFullScreen(element) {
                if (!document.fullscreenElement) {
                    if (element.requestFullscreen) {
                        element.requestFullscreen();
                    } else if (element.webkitRequestFullscreen) { // Safari
                        element.webkitRequestFullscreen();
                    } else if (element.msRequestFullscreen) { // IE11
                        element.msRequestFullscreen();
                    }
                } else {
                    if (document.exitFullscreen) {
                        document.exitFullscreen();
                    } else if (document.webkitExitFullscreen) { // Safari
                        document.webkitExitFullscreen();
                    } else if (document.msExitFullscreen) { // IE11
                        document.msExitFullscreen();
                    }
                }
            }
        });
        $("#refSharedWhatsApp").on('click', function (){
            var name_article = $("#article_name").text();
            var telefono = 5576096560;
            var mensaje = 'Se pide inforación de la siguiente obra ' + name_article;
            window.open('https://wa.me/' + telefono + '?text=' + mensaje);
        });

    </script>
@endsection

