@extends('admin.master')
@section('title', 'Artista')

@section('breadcrumb')

    <li class="breadcrumb-item">
        <a href="{{ url('/admin/artists/all') }}">
            <i class="fal fa-head-side-brain"></i>
            Artistas
        </a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/artist/'.$artist->id.'/show/') }}">
            <i class="fal fa-brain"></i>
            Ver artista {{ $artist->name  }} {{ $artist->lastname }}
        </a>
    </li>

@endsection

@section('content')

    <div class="container-fluid">

        <div class="row">



        </div>

    </div>

@stop


@section('scripts')



@endsection
