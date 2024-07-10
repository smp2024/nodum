@extends('master')

@section('title',  $post->name )

@section('content')

    @if ($section == 'artistas')
        @include('blog.partials.artistas')
    @elseif ($section == 'obras')
        @include('blog.partials.obras')
    @elseif ($section == 'proyectos')
        @include('blog.partials.proyectos')
    @elseif ($section == 'noticias')
        @include('blog.partials.noticias')
    @endif

@endsection

@section('scripts')
@endsection
