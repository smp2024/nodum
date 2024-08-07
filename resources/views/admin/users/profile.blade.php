@extends('admin.master')
@section('title', 'Perfil')
@section('breadcrumb')

    <li class="breadcrumb-item">
        <a href="{{ url('/admin/user-profile') }}">
            <i class="fal fa-id-badge"></i>
            Perfil de usuario
        </a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/user-profile') }}">
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
                <a href="{{ url('/admin/user-profile/edit') }}" data-toggle="tooltip" data-placement="top" title="Editar perfil" class="btn btn-warning" style="float: right;">
                    <i class="fas fa-edit" style="color: #fff;"></i>
                </a>

            </div>
            <div class="inside">
                <div class="row" style="padding: 16px; padding-top: 0px !important;">
                    <div class="col-9">
                        <div class="row" style="padding: 16px; padding-top: 0px !important;">

                            <div class="col-md-6 col-12 mt-1">

                                {!! Form::label('name','Nombre(s):') !!}
                                <div class="input-group">

                                    <p>{{$user->name}}</p>
                                </div>

                            </div>

                            <div class="col-md-6 col-12 mt-1">

                                {!! Form::label('lastname','Apellidos:') !!}
                                <div class="input-group">
                                    <p>{{$user->lastname}}</p>
                                </div>

                            </div>

                            <div class="col-md-6 col-12 mt-1">

                                {!! Form::label('email','Correo electrónico:') !!}
                                <div class="input-group">
                                    <p>{{$user->email}}</p>
                                </div>

                            </div>

                            <div class="col-md-6 col-12 mt-1">

                                {!! Form::label('phone','Teléfono:') !!}
                                <div class="input-group">
                                    <p>{{$user->phone}}</p>
                                </div>

                            </div>

                            <div class="col-md-6 col-12 mt-1">

                                {!! Form::label('birthday','Fecha de nacimiento:') !!}
                                <div class="input-group">
                                    <p>{{$user->birthday}}</p>
                                </div>

                            </div>

                            <div class="col-md-6 col-12 mt-1">

                                {!! Form::label('country','Pais:') !!}
                                <div class="input-group">
                                    <p>{{$user->country}}</p>
                                </div>

                            </div>
                            @if($user->role == 2)
                                <div class="col-md-12 mt-1">

                                    {!! Form::label('description ','Descripción:') !!}
                                    <div class="input-group">
                                        {!! html_entity_decode($user->description_large, ENT_QUOTES | ENT_XML1, 'UTF-8') !!}
                                    </div>

                                </div>

                            @endif
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="row" style="padding: 16px; padding-top: 0px !important;">
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

                <button type="button" class="btn btn-primary btn-change-password" data-toggle="modal" data-target="#changePasswordModal">
                    Cambiar Contraseña
                </button>
            </div>
        </div>
    </div>

    <!-- Modal para cambiar la contraseña -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Cambiar Contraseña</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="password-instructions">
                        La nueva contraseña debe contener al menos una letra mayúscula, un número y un signo especial.
                    </p>


                        {!! Form::open(['url' => '/account/password/edit']) !!}
                        <div class="row">
                            <div class="col-md-12">

                                {!! Form::label('apassword','Cotraseña actual:') !!}
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-key"></i>
                                        </span>
                                    </div>
                                    {!! Form::password('apassword', [ 'class' => 'form-control']) !!}
                                </div>

                            </div>
                        </div>
                        <div class="row mt16">
                            <div class="col-md-12">

                                {!! Form::label('password','Nueva contraseña:') !!}
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-key"></i>
                                        </span>
                                    </div>
                                    {!! Form::password('password', [ 'class' => 'form-control']) !!}
                                </div>

                            </div>
                        </div>
                        <div class="row mt16">
                            <div class="col-md-12">

                                {!! Form::label('cpassword','Repetir contraseña:') !!}
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-key"></i>
                                        </span>
                                    </div>
                                    {!! Form::password('cpassword', [ 'class' => 'form-control']) !!}
                                </div>

                            </div>

                        </div>
                        <div class="row mt16">
                            <div class="col-md-12">
                                {!! Form::submit('Guardar', ['class' => 'btn btn-primary', 'style'=>'background-color: #707791; border-color: #707791;']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            // $('#changePasswordModal').on('shown.bs.modal', function () {
            //     $('#current_password').focus();
            // });

            // $('#changePasswordForm').on('submit', function(event) {
            //     let newPassword = $('input[name="new_password"]').val();
            //     let confirmNewPassword = $('input[name="confirm_new_password"]').val();
            //     let passwordAlert = $('#passwordAlert');
            //     let passwordPattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

            //     if (newPassword !== confirmNewPassword) {
            //         event.preventDefault();
            //         passwordAlert.text('Las contraseñas no coinciden.').show();
            //     } else if (!passwordPattern.test(newPassword)) {
            //         event.preventDefault();
            //         passwordAlert.text('La nueva contraseña debe contener al menos una letra mayúscula, un número y un signo especial.').show();
            //     } else {
            //         passwordAlert.hide();
            //     }
            // });
        });
    </script>
@endsection
