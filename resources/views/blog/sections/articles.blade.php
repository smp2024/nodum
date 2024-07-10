@extends('master')
@section('title', $section)
@section('content')
    <div id="main_" class="row w-100 d-flex justify-content-center align-items-center m-0 h-100" style="padding-top: 0px;">

        @if ($section == 'artistas')
            @include('blog.sections.artistas')
        @elseif ($section == 'obras')
            @include('blog.sections.obras')
        @elseif ($section == 'proyectos')
            @include('blog.sections.proyectos')
        @elseif ($section == 'noticias')
            @include('blog.sections.noticias')
        @elseif ($section == 'contactos')
            @include('blog.sections.contactos')
        @elseif ($section == 'nosotros')
            @include('blog.sections.nosotros')
        @endif

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
