@extends('master')
@section('title', $section)
@section('content')
    <div id="main_">
        <div class="row justify-content-center align-items-center  w-100">
            {{-- <div class="col-lg-6  col-12 justify-content-center align-items-center " style="padding:5% 6% 0% 7%;">
                <div class="row justify-content-center align-items-center  ">
                    <h2 class="">Contacto </h2>
                </div>
                <div class="row justify-content-start align-items-centar pl-5 ">
                    <h5 >{{ config('app.name') }}</h5>
                </div>
                {{-- <div class="row justify-content-center align-items-center  ">
                    <div class="contacto-p">
                        @foreach ($contacto as $contact )
                            {!! html_entity_decode($contact->direction, ENT_QUOTES | ENT_XML1, 'UTF-8')!!}

                            <p >Phone(s): {{ $contact->phone }} |  {{ $contact->phone2 }}</p>
                            <p > {{ $contact->email }}</p>
                        @endforeach
                    </div>
                </div> --}}

            {{-- </div> --}}
            <div class="col-lg-6 col-12 justify-content-center align-items-center" style="padding:5% 6% 0% 7%;">
                <div class=" justify-content-center align-items-center  ">
                    <h2 class="text-center">Escríbenos</h2>
                </div>
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
                        {!! Form::submit('Enviar', ['class' => 'btn btn-success mt16  float-right']) !!}
                        </div>
                    </div>
                {!! Form::close() !!}
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
@endsection
