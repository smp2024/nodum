@extends('admin.master')
@section('title', 'Artistas')

@section('breadcrumb')

    <li class="breadcrumb-item">
        <a href="{{ url('/admin/artists/all') }}">
            <i class="fal fa-head-side-brain"></i>
            Artistas
        </a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/artist/add/') }}">
            <i class="fal fa-brain"></i>
            Agregar Artista
        </a>
    </li>

@endsection
@section('css')

@endsection

@section('content')

    <div class="container-fluid">

        <div class="row">

            <div class="col-12">
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title">
                            <i class="fal fa-brain"></i>
                            Agregar Artista
                        </h2>
                    </div>
                    <div class="inside">

                        @if (kvfj(Auth::user()->permissions, 'artist_add'))

                            {!! Form::open(['url' => '/admin/artist/add', 'files' => true]) !!}

                                <div class="row" style="padding: 16px; padding-top: 0px !important;">

                                    <div class="col-md-6 col-12 mt-1">

                                        {!! Form::label('name','Nombre(s):') !!}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-signature"></i>
                                                </span>
                                            </div>
                                            {!! Form::text('name', null, [ 'class' => 'form-control', 'required' => true]) !!}
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
                                            {!! Form::text('lastname', null, [ 'class' => 'form-control', 'required' => true]) !!}
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
                                            {!! Form::email('email', null, [ 'class' => 'form-control', 'required' => true]) !!}
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
                                            {!! Form::number('phone', null, [ 'class' => 'form-control', 'required' => true]) !!}
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
                                            {!! Form::date('birthday', null, [ 'class' => 'form-control', 'required' => true]) !!}
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
                                            {!! Form::text('country', null, [ 'class' => 'form-control', 'required' => true]) !!}
                                        </div>

                                    </div>



                                </div>
                                <div class="row"style="padding: 16px; padding-top: 1px;">
                                    <div class="col-11">

                                        {!! Form::label('file','Imagen:') !!}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-id-badge"></i>
                                                </span>
                                            </div>
                                            <div class="custom-file">
                                                {!! Form::file('file', ['class' => 'custom-file-input', 'id' => 'customFile', 'required' => true]) !!}
                                                <label class="custom-file-label h-100 m-0" for="customFile">Choose File</label>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-1">
                                        <p id="confirm_img" class="h-100 m-0 d-flex justify-content-center align-items-end">
                                            <i class="fas fa-times text-danger"></i>
                                        </p>
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
                                                            <input type="checkbox" class="brand_id" id="{{$category_id}}" name="categories[]" value="{{@(!empty($category->id) ? $category->id : "")}}"/>
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

                                            {{ Form::label('tags','Etiquetas:') }}
                                            <div class="d-flex">
                                                <tr>

                                                    @foreach($tags as  $brand)
                                                        <label class="container ">{!! $brand->name !!}
                                                            <input type="checkbox" class="brand_id" id="brand_id" name="tags[]" value="{{@(!empty($brand->id) ? $brand->id : "")}}"/>
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
                                                {!! Form::textarea('description_large', null, ['class' => 'form-control Ckeditor', 'id' => 'ckeditor', 'required' => true]) !!}
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

        </div>

    </div>

@stop


@section('scripts')
    <script>
    $(document).ready(function() {
      $('#customFile').change(function() {
        var fileName = $(this).val().split('\\').pop();
        console.log(fileName);
        if (fileName) {
          $('#confirm_img').html('<i class="fas fa-check text-success"></i>');
        } else {
          $('#confirm_img').html('<i class="fas fa-times text-danger"></i>');
        }
      });
    });
    </script>


@endsection
