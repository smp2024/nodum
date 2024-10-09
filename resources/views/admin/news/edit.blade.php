@extends('admin.master')
@section('title', 'Editar Noticia')

@section('breadcrumb')

    <li class="breadcrumb-item">
        <a href="{{ url('/admin/news/1') }}">
            <i class="fal fa-newspaper"></i>
            Noticias
        </a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/news/'.$product->id.'/edit ') }}">
            <i class="far fa-folder-open"></i>
            Editar noticia
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
                            Editar noticia
                        </h2>
                    </div>

                    <div class="inside">


                        {!! Form::open(['url' => '/admin/new/'.$product->id.'/edit', 'files' => true, 'method' => 'post', 'novalidate']) !!}
                        @csrf
                            <div class="row" style="padding: 16px;">

                                <div class="col-md-9">
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

                                <div class="col-md-3 .FechaN">
                                    {!! Form::label('date','Fecha:') !!}
                                    <div class="input-group" style="    height: 56%;">

                                        {!! Form::date('date', $product->date,['class' => 'date', 'style' => 'border: 1px solid #ced4da !important;']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row mt16">

                                <div class="col-md-9">
                                    <div class="container-fluid">
                                        <label for="name">Imagen destacada:</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                {!! Form::file('file', ['class' => 'custom-file-input', 'id' => 'customFile']) !!}
                                                <label class="custom-file-label" for="customFile">Choose File</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="container-fluid">
                                        {!! Form::label('status ','Estado:') !!}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                {!! Form::select('status', [ '0' => 'Borrador', '1' => 'Publicado'], $product->status, ['class' => 'custom-select']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            @for ($i=1 ; $i<=$product->sections; $i++)

                                <div name="" class="row mt16" style="padding: 16px;" >
                                    <div class="col-md-12">
                                        <div class="form-group">

                                            {{ Form::label('description','Descripcion:') }}
                                            <div class="input-group-prepend">
                                                @foreach ($descriptions as $description)
                                                    @if ($description->section == $i)
                                                        {!! Form::textarea('description[]', $description->content, ['class' => 'form-control ', 'id' => 'editor_'.$i]) !!}
                                                    @endif
                                                @endforeach
                                            </div>

                                        </div>
                                    </div>
                                </div>
{{--
                                <div class="row mt16" style="padding: 16px;">
                                    <div class="col-md-12">
                                        <div class="form-group">

                                            {{ Form::label('video','Video:') }}
                                            <div class="input-group-prepend">
                                                @foreach ($videos as $video)
                                                    @if ($video->section == $i)
                                                        {!! Form::textarea('video[]', $video->content, ['class' => 'form-control ', 'id' => 'video_'.$i]) !!}
                                                    @endif
                                                @endforeach

                                            </div>

                                        </div>
                                    </div>
                                </div> --}}

                            @endfor

                            {!! Form::submit('Guardar', ['class' => 'btn btn-success mt16']) !!}

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
                            <img src="{{ url('/multimedia'.$product->file_path.'/'.$product->slug.'/'.$product->file) }}" class="img-fluid">
                        </div>

                    </div>
                </div>

                @for ($i=1 ; $i<=$product->sections; $i++)
                    <div class="container-fluid">
                        <div class="panel shadow mt16">

                            <div class="header">
                                <h2 class="title">
                                    <i class="far fa-images"></i>
                                    Galeria {{$i}}
                                </h2>
                            </div>

                            <div class="inside product_gallery">

                                {!! Form::open(['url' => '/admin/'.$product->module.'/'.$product->id.'/gallery/add/'.$i, 'files' => true, 'id' => 'form_product_gallery_'.$i]) !!}

                                    {!! Form::file('file', ['id' => 'product_file_image_'.$i, 'accept' => 'image/*', 'style' => 'display:none;', 'required']) !!}

                                {!! Form::close() !!}

                                <div class="btn-submit">
                                    <a href="#" id="btn_product_file_image_{{$i}}" onclick="Ngallery0{{$i}}()"><i class="fas fa-plus"></i></a>
                                </div>

                                <div class="tumbs">
                                    @foreach ($galerias as $ima)
                                        @if ($ima->after == $i)
                                            <div class="tumb">

                                                <a href="{{ url('/admin/new/'.$product->id.'/gallery/'.$ima->id.'/delete') }}" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>

                                                <img src="{{ url('/multimedia/'.$ima->file_path.'/t_'.$ima->file_name) }}" class="img-fluid" />
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>
                @endfor

            </div>

        </div>

    </div>

@stop

@section('scripts')

    <script src="{{ asset('/libs/ckeditor/ckeditor.js') }}"></script>
    @for ($i = 0; $i <= $product->sections; $i++)
        <script>

            CKEDITOR.replace( 'editor_{{$i}}');

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
