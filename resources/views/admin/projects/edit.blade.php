@extends('admin.master')
@section('title', 'Editar Proyecto')

@section('breadcrumb')

    <li class="breadcrumb-item">
        <a href="{{ url('/admin/projects/1') }}">
            <i class="fal fa-books"></i>
            Proyectos
        </a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/projects/'.$product->id.'/edit ') }}">
            <i class="far fa-folder-open"></i>
            Editar proyecto
        </a>
    </li>

@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">

            <div class="col-md-9">
                <div class="panel shadow">

                    <div class="header">
                        <h2 class="title">
                            <i class="far fa-edit"></i>
                            Editar proyecto
                        </h2>
                    </div>

                    <div class="inside">


                        {!! Form::open(['url' => '/admin/project/'.$product->id.'/edit', 'files' => true, 'method' => 'post', 'novalidate']) !!}
                        @csrf
                            <div class="row" style="padding: 16px;">

                                <div class="col-md-9 col-12">
                                    {!! Form::label('name','Nombre:') !!}
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-keyboard"></i>
                                            </span>
                                        </div>
                                        {!! Form::text('name', $product->name, [ 'class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="col-md-3 col-12">
                                    <div class="container-fluid">
                                        {!! Form::label('status ','Estado:') !!}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                {!! Form::select('status', [ '0' => 'Borrador', '1' => 'Publicado'], $product->status, ['class' => ' form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    {!! Form::label('file','Imagen de portada:', [ 'class' => 'mt-3']) !!}
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fal fa-file-image"></i>
                                            </span>
                                        </div>
                                        {!! Form::file('file', [ 'class' => 'form-control', 'style' => 'padding: 4px;']) !!}
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    {!! Form::label('pdf','PDF:', [ 'class' => 'mt-3']) !!}
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fal fa-file-pdf"></i>
                                            </span>
                                        </div>
                                        {!! Form::file('pdf', [ 'class' => 'form-control', 'style' => 'padding: 4px;']) !!}
                                    </div>
                                </div>

                            </div>

                            {!! Form::submit('Guardar', ['class' => 'btn btn-success mt16', 'style' => 'float: right; bottom: 0;']) !!}

                        {!! Form::close() !!}

                    </div>

                </div>
            </div>

            <div class="col-md-3 p-0">

                <div class="container-fluid">
                    <div class="panel shadow">

                        <div class="header">
                            <h2 class="title">
                                <i class="far fa-image "></i>
                                Imagen destacada
                            </h2>
                        </div>
                        <div class="inside">
                            <img src="{{ url('multimedia/'.$product->file_path.'/t_'.$product->file) }}" class="img-fluid">
                        </div>

                    </div>
                </div>
                <div class="container-fluid mt-2">
                    <div class="panel shadow">

                        <div class="header">
                            <h2 class="title">
                                <i class="far fa-image "></i>
                                PDF
                            </h2>
                        </div>
                        <div class="inside">
                            <a target="_blank" href="{{ url('multimedia/'.$product->file_path.'/'.$product->pdf) }}" class="Link_Not">
                                Descargar
                            </a>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>

@stop

@section('scripts')

    {{-- <script src="{{ asset('/libs/ckeditor/ckeditor.js') }}"></script> --}}
    @for ($i = 1; $i <= $product->sections; $i++)
        <script>

            CKEDITOR.replace( 'editor_{{$i}}');
            $('#editor_{{$i}} ').addClass('d-none');

        </script>
    @endfor
    @for ($i = 1; $i <= $product->sections; $i++)
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            var btn_gallery_{{$i}} = document.getElementById('btn_product_file_image_{{$i}}');
            var input_file_{{$i}} = document.getElementById('product_file_image_{{$i}}');
            if (btn_gallery_{{$i}}) {
                btn_gallery_{{$i}}.addEventListener('click', function(e) {
                    e.preventDefault();
                    input_file_{{$i}}.click();
                });
            }

        });

        function Ngallery0{{$i}}(e) {
            var input_file_{{$i}} = document.getElementById('product_file_image_{{$i}}');
            input_file_{{$i}}.addEventListener('change', function() {
                document.getElementById('form_product_gallery_{{$i}}').submit();
            });
        }

    </script>
@endfor


@endsection
