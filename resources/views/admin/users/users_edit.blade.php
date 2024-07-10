@extends('admin.master')
@section('title', 'Editar usuario')
@section('breadcrumb')

    <li class="breadcrumb-item">
        <a href="{{ url('/admin/users') }}">
            <i class="fal fa-users"></i>
            Usuarios
        </a>
    </li>

@endsection
@section('content')
    <div class="container-fluid">
        <div class="page_user">
            <div class="row">

                <div class="col-md-4">
                    <div class="container-fluid">
                        <div class="panel shadow">

                            <div class="header">
                                <h2 class="title">
                                    <i class="fas fa-user"></i>
                                    Información del usuario
                                </h2>
                            </div>

                            <div class="inside">
                                <div class="mini_profile">

                                    @if (is_null($user->avatar))
                                        <img src="{{ url('/media/imagenes/default_avatar.png') }}" class="avatar">
                                    @else
                                        <img src="{{ url('/multimedia/avatar/'.$user->id.'/'.$user->avatar) }}" class="avatar">
                                    @endif

                                    <div class="info">
                                        <span class="title">
                                            <i class="far fa-address-card"></i>
                                            Nombre:
                                        </span>
                                        <span class="text">
                                            {{ $user->name }} {{ $user->lastname }}
                                        </span>
                                        <span class="title">
                                            <i class="fas fa-user-tie"></i>
                                            Estado de usuario:
                                        </span>
                                        <span class="text">
                                            {{ getUserStatusArray(null,$user->status) }}
                                        </span>
                                        <span class="title">
                                            <i class="far fa-envelope"></i>
                                            Correo electrónico:
                                        </span>
                                        <span class="text">
                                            {{ $user->email }}
                                        </span>
                                        <span class="title">
                                            <i class="far fa-calendar-alt"></i>
                                            Fecha de registro:
                                        </span>
                                        <span class="text">
                                            {{ $user->created_at  }}
                                        </span>
                                        <span class="title">
                                            <i class="fas fa-user-shield"></i>
                                            Role de usuario:
                                        </span>
                                        <span class="text">
                                            {{ getRoleUserArray(null,$user->role) }}
                                        </span>
                                    </div>
                                    @if (kvfj(Auth::user()->permissions, 'user_banned'))
                                        @if($user->status == "100")
                                            <a href="{{ url('/admin/user/'.$user->id.'/banned') }}" class="btn btn-success mt16">Activar Usuario</a>
                                        @else
                                            <a href="{{ url('/admin/user/'.$user->id.'/banned') }}" class="btn btn-danger mt16">Suspender Usuario</a>
                                        @endif
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="container-fluid">
                        <div class="panel shadow">

                            <div class="header">
                                <h2 class="title">
                                    <i class="fas fa-user-edit"></i>
                                    Editar información del usuario
                                </h2>
                            </div>

                            <div class="inside">

                                @if (kvfj(Auth::user()->permissions, 'user_edit'))

                                    {!! Form::open(['url', '/admin/user/'.$user->id.'/edit']) !!}

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="module">Tipo de Usuario</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="far fa-keyboard"></i>
                                                        </span>
                                                    </div>
                                                    {!! Form::select('user_type', getRoleUserArray('list', null), $user->role, ['class' => 'custom-select']) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt16">
                                            <div class="col-md-12">
                                                {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                                            </div>
                                        </div>

                                    {!! Form::close() !!}

                                @endif

                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
