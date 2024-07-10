@extends('admin.master')
@section('title', 'Dashboard')

@section('content')

    <div class="container-fluid">
        @if (kvfj(Auth::user()->permissions, 'dashboard_small_stats'))
            <div class="panel shadow">

                <div class="header">
                    <h2 class="title">
                        <i class="fas fa-chart-bar"></i>
                        Estadísticas {!! html_entity_decode($company[0]->company_name, ENT_QUOTES | ENT_XML1, 'UTF-8') !!}
                    </h2>
                </div>

            </div>

            <div class="d-flex mt16 justify-content-center align-content-center ">

                @include('admin.partials.cont_estast')

            </div>

        @endif
    </div>

@endsection
