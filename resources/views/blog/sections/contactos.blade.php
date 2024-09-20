@extends('master')
@section('title', $section)
@section('css')
<style>
    #map {
            height: 500px; /* Ajusta la altura del mapa */
            width: 100%;   /* Ajusta el ancho del mapa */
        }
</style>
@endsection
@section('content')
<div id="main_" class="row w-100 d-flex justify-content-center align-items-center m-0 h-100" >
    <div id="" class="col-md-6 col-12 h-100  p-3" >
        <div class="row h-100 justify-content-center align-items-center">

            <div id="map" style="filter: grayscale(1); width: 85%;"></div>
        </div>
    </div>
    @foreach ($sections as $politic)
        <div id="{{$politic->name}}" class="col-md-6 col-12 h-100 p-3" >
            <div class="row  justify-content-center align-content-center" style="padding: 0% 13% 0% 12%; height: 40%;" >
                <div id="" class="col-12 p-0 d-flex justify-content-end align-content-center h-100" style="text-align: end; " >
                    <img src="{{ url('multimedia'.$company[0]->file_path.'/'.$company[0]->file) }}" alt="" class="" >
                </div>
            </div>
            <div class="row  justify-content-center align-content-center" style="padding: 0% 13% 0% 12%" >
                @foreach ($contacto as $contact)
                    <h4 class="p-0 mb-2 w-100" style="font-weight: 700; text-align: start;">Contacto</h4>
                    <div id="" class="col-11 p-0  text-justify"  >
                        <p class="m-0" style="font-weight: 700;">Direccion</p>
                            {!! html_entity_decode($contact->direction, ENT_QUOTES | ENT_XML1, 'UTF-8') !!}
                    </div>
                    <div id="" class="col-1 p-0  justify-content-center align-content-center " style="text-align: center;" >
                        <i class="far fa-map-marker-alt"></i>
                    </div>
                    <div id="" class="col-11 p-0  text-justify"  >

                        <p class="m-0" style="font-weight: 700;">Teléfono</p>
                        <p class="m-0">{{$contact->phone}}</p>
                        @if ($contact->phone2)

                            <p class="m-0">{{$contact->phone2}}</p>
                        @endif
                    </div>
                    <div id="" class="col-1 p-0  justify-content-center align-content-center" style="text-align: center;" >
                        <i class="fal fa-phone-volume"></i>
                    </div>
                    <div id="" class="col-11 p-0  text-justify  mt-2"  >

                        <p class="m-0" style="font-weight: 700;">Correo</p>
                        <p>{{$contact->email}}</p>
                    </div>
                    <div id="" class="col-1 p-0  justify-content-center align-content-center " style="text-align: center;" >
                        <i class="fal fa-envelope"></i>
                    </div>
                @endforeach
            </div>
            <div class="row  justify-content-center align-content-center" style="padding: 0% 13% 0% 12%" >
                <div id="" class="col-12 p-0  text-justify mt-3" style="height: 10%;" >
                    <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModalCenter">Escribenos</button>
                </div>
            </div>

        </div>
    @endforeach
</div>
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Escríbenos</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class=" justify-content-center align-items-center  ">
                <p>Los campos que incluyen la estrella (*) son obligatorios.</p>
            </div>

            {!! Form::open(['url' => '/descargar-contacto', 'files' => true]) !!}

                <div class="row" >

                    <div class="col-md-6 col-12 mt-1">

                        {!! Form::label('name','*Nombre(s):') !!}
                        <div class="input-group">
                            {!! Form::text('name', null, [ 'class' => 'form-control']) !!}
                        </div>

                    </div>
                    <div class="col-md-6 col-12 mt-1">

                        {!! Form::label('lastname','*Apellidos:') !!}
                        <div class="input-group">
                            {!! Form::text('lastname', null, [ 'class' => 'form-control']) !!}
                        </div>

                    </div>
                    <div class="col-md-6 col-12 mt-1">

                        {!! Form::label('email','*Correo electrónico:') !!}
                        <div class="input-group">
                            {!! Form::text('email', null, [ 'class' => 'form-control']) !!}
                        </div>

                    </div>
                    <div class="col-md-6 col-12 mt-1">

                        {!! Form::label('phone','*Teléfono:') !!}
                        <div class="input-group">
                            {!! Form::text('phone', null, [ 'class' => 'form-control']) !!}
                        </div>

                    </div>
                    <div class="col-12 mt-1">

                        {!! Form::label('description','*Descripción:') !!}
                        <div class="input-group">
                            {{-- <textarea name="description" id="" cols="30" rows="3" class="Text_ justify-content-center align-items-center " style="border: 1px solid #ced4da; outline: none; width: 100%;"></textarea> --}}
                            {!! Form::textarea('description', null, [
                                'class'      => 'form-control',
                                'rows'       => 3,
                                'name'       => 'description',
                                'id'         => 'description'
                            ])!!}
                        </div>

                    </div>

                    <div class="col-12 mt-2 justify-content-center align-items-center">
                    {!! Form::submit('Enviar', ['class' => 'btn btn-outline-dark mt16  float-right']) !!}
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
        {{-- <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div> --}}
      </div>
    </div>
  </div>
@endsection

@section('scripts')

    <script>

        if (screen.width < 800) {
        console.log('oo');
        $('#main_').removeClass("row");
        }

    </script>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDXWZr25bYXm7fHl1-GFKflKvskqfOPRR4&callback=initMap"></script>
        <script>
            let panorama;

            function initMap() {
                const myLatLng = { lat: 19.4122744, lng: -99.1703113 };

                panorama = new google.maps.Map(document.getElementById('map'), {
                    zoom: 16,
                    center: myLatLng
                });

                var marker = new google.maps.Marker({
                    position: myLatLng,
                    map: panorama,
                });
            }

            window.initMap = initMap;
        </script>
@endsection
