@extends('admin.master')
@section('title', 'Agregar Artículo')

@section('breadcrumb')

    <li class="breadcrumb-item">
        <a href="{{ url('/admin/articulos/1') }}">
            <i class="fal fa-newspaper"></i>
            Artículo
        </a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/article/add/') }}">
            <i class="fas fa-plus"></i>
            Agregar artículo
        </a>
    </li>

@endsection

@section('content')

    <div class="container-fluid">


    </div>

@stop

@section('scripts')

    <script src="{{ asset('/libs/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace( 'editor' );
    </script>
    <script src="{{ asset('js/admin.js') }}"></script>

@endsection
