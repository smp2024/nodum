@extends('admin.master')
@section('title', 'Perfil')
@section('breadcrumb')

    <li class="breadcrumb-item">
        <a href="{{ url('/admin/user-profile/edit') }}">
            <i class="fal fa-id-card"></i>
            Editar perfil
        </a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/user-profile/edit') }}">
            <i class="far fa-head-side"></i>
            {{$user->name}} {{$user->lastname}}
        </a>
    </li>

@endsection
@section('css')
    <style>
        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
        }

        .profile-info {
            margin-top: 20px;
        }

        .profile-info h3 {
            margin-bottom: 10px;
        }

        .profile-info p {
            margin: 5px 0;
        }

        .btn-change-password {
            margin-top: 20px;
        }

        .alert {
            color: red;
            font-weight: bold;
            margin-top: 10px;
        }

        .password-instructions {
            font-size: 0.9em;
            color: #6c757d;
        }
    </style>
@endsection
@section('content')

    <div class="container-fluid">
        <div class="panel shadow">
            <div class="header">
                <h2 class="title"><i class="fal fa-user-circle"></i> Perfil de Usuario</h2>
            </div>
            <div class="inside">
                <div class="row">

                    <div class="col-9">

                        @if (kvfj(Auth::user()->permissions, 'user_profile_edit') || kvfj(Auth::user()->permissions, 'artist_edit'))

                            {!! Form::open(['url' => '/admin/user-profile/edit', 'method' => 'POST', 'files' => true]) !!}

                                <div class="row" style="padding: 16px; padding-top: 0px !important;">

                                    <div class="col-md-6 col-12 mt-1">

                                        {!! Form::label('name','Nombre(s):') !!}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-signature"></i>
                                                </span>
                                            </div>
                                            {!! Form::text('name', $user->name, [ 'class' => 'form-control', 'required' => true]) !!}
                                        </div>

                                    </div>
                                    <div class="col-md-6 col-12 mt-1">

                                        {!! Form::label('lastname','Apellidos:') !!}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-signature"></i>
                                                </span>
                                            </div>
                                            {!! Form::text('lastname', $user->lastname, [ 'class' => 'form-control', 'required' => true]) !!}
                                        </div>

                                    </div>

                                    <div class="col-md-6 col-12 mt-1">

                                        {!! Form::label('email','Correo electrónico:') !!}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fal fa-at"></i>
                                                </span>
                                            </div>
                                            {!! Form::email('email', $user->email, [ 'class' => 'form-control', 'required' => true]) !!}
                                        </div>

                                    </div>

                                    <div class="col-md-6 col-12 mt-1">

                                        {!! Form::label('phone','Teléfono:') !!}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fal fa-phone"></i>
                                                </span>
                                            </div>
                                            {!! Form::number('phone', $user->phone, [ 'class' => 'form-control', 'required' => true]) !!}
                                        </div>

                                    </div>

                                    <div class="col-md-6 col-12 mt-1">

                                        {!! Form::label('birthday','Fecha de nacimiento:') !!}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fal fa-calendar-star"></i>
                                                </span>
                                            </div>
                                            {!! Form::date('birthday', $user->birthday, [ 'class' => 'form-control', 'required' => true]) !!}
                                        </div>

                                    </div>

                                    <div class="col-md-6 col-12 mt-1">

                                        {!! Form::label('country','Pais:') !!}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-globe-americas"></i>
                                                </span>
                                            </div>
                                            {!! Form::text('country', $user->country, [ 'class' => 'form-control', 'required' => true]) !!}
                                        </div>

                                    </div>

                                    <div class="col-9 mt-1">

                                        {!! Form::label('file','Imagen:') !!}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-id-badge"></i>
                                                </span>
                                            </div>
                                            <div class="custom-file">
                                                {!! Form::file('file', ['class' => 'custom-file-input', 'id' => 'customFile', 'required' => false]) !!}
                                                <label class="custom-file-label h-100 m-0" for="customFile">Choose File</label>
                                            </div>
                                        </div>

                                    </div>
                                    @if($user->role == 2)

                                        <div class="col-md-12 mt-1">
                                            <div class="form-group">

                                                {{ Form::label('description_large','Descripcion:') }}
                                                <div class="input-group-prepend">
                                                    {!! Form::textarea('description_large', $user->description_large, ['class' => 'form-control Ckeditor', 'id' => 'ckeditor']) !!}
                                                </div>

                                            </div>
                                        </div>
                                    @endif
                                </div>


                                {!! Form::submit('Guardar', ['class' => 'btn btn-success mt16']) !!}

                            {!! Form::close() !!}

                        @endif

                    </div>

                    <div class="col-md-3 mt-1">

                        <div class="container-fluid">
                            <div class="panel shadow">

                                <div class="header">
                                    <h2 class="title">
                                        <i class="far fa-image "></i>
                                        Imagen de perfil
                                    </h2>
                                </div>
                                <div class="inside">
                                    <img src="{{ url('/multimedia'.$user->file_path.'/'.$user->file) }}" class="img-fluid">
                                </div>

                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>



@endsection

@section('scripts')

@endsection
