@extends('admin.master')
@section('title', 'Dashboard')
@section('breadcrumb')

    <li class="breadcrumb-item">
        <a href="{{ url('/admin') }}">
            <i class="fas fa-chart-bar"></i>
            Estadísticas
        </a>
    </li>

@endsection
@section('css')
    <style>
        .col-sm-4 .mb-3{
            color: #195875;
        }
    </style>
@endsection
@section('content')

    <div class="container-fluid">
        @if (kvfj(Auth::user()->permissions, 'dashboard_small_stats'))

            <div class="row mt16 justify-content-center align-content-center ">

                @include('admin.partials.cont_estast')

            </div>

        @endif
    </div>

@endsection
