@extends('admin.master')
@section('title', 'Permisos de usuario')
@section('css')
    <style>
        .breadcrumb-item+.breadcrumb-item::before{
            color: #fff !important;
        }
    </style>
@endsection
@section('breadcrumb')

    <li class="breadcrumb-item">
        <a href="{{ url('/admin/users/'.$user->status) }}">
            <i class="fal fa-users"></i>
            Usuarios
        </a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/user/'.$user->id.'/permissions' ) }}">
            <i class="fas fa-cogs"></i>
            Permisos del usuario: {{ $user->name }} {{ $user->lastname }}
        </a>
    </li>

@endsection
@section('content')

    <div class="container-fluid">

        <div class="page_user">
            <form action="{{ url('/admin/user/'.$user->id.'/permissions') }}" method="POST">
                @csrf
                <div class="row">
                    @include('admin.users.permissions.module_permissions')
                </div>

                <div class="row mt16">

                    <div class="col-md-12">
                        <div class="container-fluid">
                            <div class="panel shadow">
                                <div class="inside">
                                    <input type="submit" value="Guardar" class="btn btn-primary">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </form>
        </div>

    </div>

@endsection

