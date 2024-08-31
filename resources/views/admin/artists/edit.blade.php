@extends('admin.master')
@section('title', 'Editar Artista')

@section('breadcrumb')

    <li class="breadcrumb-item">
        <a href="{{ url('/admin/artists/all') }}">
            <i class="fal fa-head-side-brain"></i>
            Artistas
        </a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/artist/'.$artist->id.'/edit/') }}">
            <i class="fal fa-brain"></i>
            Editar artista {{ $artist->name  }} {{ $artist->lastname }}
        </a>
    </li>

@endsection

@section('content')


    <div class="container-fluid">

        <div class="row">

            <div class="col-9">
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title">
                            <i class="fas fa-plus"></i>
                            Editar artista
                        </h2>
                    </div>
                    <div class="inside">

                        @if (kvfj(Auth::user()->permissions, 'artist_add'))

                            {!! Form::open(['url' => '/admin/artist/'.$artist->id.'/edit', 'files' => true]) !!}

                            <div class="row" style="padding: 16px; padding-top: 0px !important;">

                                <div class="col-md-6 col-12 mt-1">

                                    {!! Form::label('name','Nombre(s):') !!}
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-signature"></i>
                                            </span>
                                        </div>
                                        {!! Form::text('name', $artist->name, [ 'class' => 'form-control', 'required' => true]) !!}
                                    </div>

                                </div>
                                <div class="col-md-6 col-12 mt-1">

                                    {!! Form::label('lastname','Apellidos:') !!}
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-signature"></i>
                                            </span>
                                        </div>
                                        {!! Form::text('lastname', $artist->lastname, [ 'class' => 'form-control', 'required' => true]) !!}
                                    </div>

                                </div>

                                <div class="col-md-6 col-12 mt-1">

                                    {!! Form::label('email','Correo electrónico:') !!}
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fal fa-at"></i>
                                            </span>
                                        </div>
                                        {!! Form::email('email', $artist->email, [ 'class' => 'form-control', 'required' => true]) !!}
                                    </div>

                                </div>

                                <div class="col-md-6 col-12 mt-1">

                                    {!! Form::label('phone','Teléfono:') !!}
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fal fa-phone"></i>
                                            </span>
                                        </div>
                                        {!! Form::number('phone', $artist->phone, [ 'class' => 'form-control', 'required' => true]) !!}
                                    </div>

                                </div>

                                <div class="col-md-6 col-12 mt-1">

                                    {!! Form::label('birthday','Fecha de nacimiento:') !!}
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fal fa-calendar-star"></i>
                                            </span>
                                        </div>
                                        {!! Form::date('birthday', $artist->birthday, [ 'class' => 'form-control', 'required' => true]) !!}
                                    </div>

                                </div>

                                <div class="col-md-6 col-12 mt-1">

                                    {!! Form::label('country','Pais:') !!}
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-globe-americas"></i>
                                            </span>
                                        </div>
                                        {!! Form::text('country', $artist->country, [ 'class' => 'form-control', 'required' => true]) !!}
                                    </div>

                                </div>

                                <div class="col-9">

                                    {!! Form::label('file','Imagen:') !!}
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-id-badge"></i>
                                            </span>
                                        </div>
                                        <div class="custom-file">
                                            {!! Form::file('file', ['class' => 'custom-file-input', 'id' => 'customFile']) !!}
                                            <label class="custom-file-label h-100 m-0" for="customFile">Choose File</label>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-3">

                                    {!! Form::label('status ','Estado:') !!}
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fal fa-phone"></i>
                                            </span>
                                        </div>
                                        {!! Form::select('status', [ '0' => 'Borrador', '1' => 'Publicado'], $artist->status, ['class' => 'custom-select']) !!}
                                    </div>

                                </div>
                            </div>
                            <!--
                                <div class="row" style="padding: 16px;">
                                    <div class="col-md-12">
                                        <div class="form-group">

                                            {{ Form::label('categories','Categorias:') }}
                                            <div class="d-flex">
                                                <tr>

                                                    @foreach($categories as  $category)
                                                        <label class="container ">{!! $category->name !!}
                                                            <input type="checkbox" class="brand_id" id="{{$category->id}}" name="categories[]"
                                                            value="{{@(!empty($category->id) ? $category->id : "")}}"
                                                            @foreach($categories0 as $_sel0)
                                                                {{($category->id == $_sel0->category_id ? "checked='checked'": '')}}
                                                            @endforeach/>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    @endforeach

                                                </tr>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row" style="padding: 16px;">
                                    <div class="col-md-12">
                                        <div class="form-group">

                                            {{ Form::label('tags','Técnicas:') }}
                                            <div>
                                                <tr>

                                                    @foreach($tags as  $tag)
                                                        <label class="container col-sm-3">{!! $tag->name !!}
                                                            <input type="checkbox" class="brand_id" id="{{$tag->id}}" name="tags[]"
                                                            value="{{@(!empty($tag->id) ? $tag->id : "")}}"
                                                                @foreach($tags0 as $sel0)
                                                                    {{($tag->id == $sel0->tag_id ? "checked='checked'": '')}}
                                                                @endforeach
                                                            />
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    @endforeach

                                                </tr>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            -->
                                <div class="row" style="padding: 16px;">
                                    <div class="col-md-12">
                                        <div class="form-group">

                                            {{ Form::label('description_large','Descripcion:') }}
                                            <div class="input-group-prepend">
                                                {!! Form::textarea('description_large', $artist->description_large, ['class' => 'form-control Ckeditor', 'id' => 'ckeditor']) !!}
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                {!! Form::submit('Guardar', ['class' => 'btn btn-success mt16']) !!}

                            {!! Form::close() !!}

                        @endif

                    </div>

                </div>
            </div>

            <div class="col-md-3">

                <div class="container-fluid">
                    <div class="panel shadow">

                        <div class="header">
                            <h2 class="title">
                                <i class="far fa-image "></i>
                                Imagen destacada
                            </h2>
                        </div>
                        <div class="inside">
                            <img src="{{ url('/multimedia'.$artist->file_path.'/'.$artist->slug.'/'.$artist->file) }}" class="img-fluid">
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>
@stop


@section('scripts')


<script type="text/javascript">
    function check() {

      var testing = document.getElementsByClassName('check_box');
      for (int i=0; i< testing.length; i++) {
         console.log(testing[i].value);
      }
    }
  </script>
@endsection
