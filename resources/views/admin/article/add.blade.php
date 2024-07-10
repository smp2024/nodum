@extends('admin.master')
@section('title', 'Articulos')

@section('breadcrumb')

    <li class="breadcrumb-item">
        <a href="{{ url('/admin/articles/all') }}">
            <i class="fas fa-article"></i>
            Articulos
        </a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/articles/add/') }}">
            <i class="fas fa-plus"></i>
            Agregar articulo
        </a>
    </li>

@endsection

@section('content')

    <div class="container-fluid">

        <div class="row">

            <div class="col-12">
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title">
                            <i class="fas fa-plus"></i>
                            Agregar articulo
                        </h2>
                    </div>
                    <div class="inside">

                        @if (kvfj(Auth::user()->permissions, 'article_add'))

                            {!! Form::open(['url' => '/admin/article/add', 'files' => true]) !!}

                                <div class="row" style="padding: 16px;">

                                    <div class="col-md-4 col-12">

                                        {!! Form::label('name','Nombre:') !!}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-signature"></i>
                                                </span>
                                            </div>
                                            {!! Form::text('name', null, [ 'class' => 'form-control']) !!}
                                        </div>

                                    </div>
                                    <div class="col-md-4 col-12">

                                        {!! Form::label('artist_id','Artista:') !!}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fal fa-head-side-brain"></i>
                                                </span>
                                            </div>
                                            <select class="custom-select" id="artist_id" name="artist_id">
                                                @foreach ($artists as $key => $artist)
                                                    <option id="{{ $artist->id }}" name="{{ $artist->id }}" value="{{ $artist->id }}">{{ $artist->name }} {{ $artist->lastname }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>

                                    <div class="col-md-4 col-12">

                                        {!! Form::label('category_id','Categoria:') !!}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-school"></i>
                                                </span>
                                            </div>
                                            <select class="custom-select" id="category_id" name="category_id">
                                                @foreach ($categories as $key => $subclasificacion)
                                                    <option id="{{ $subclasificacion->id }}" name="{{ $subclasificacion->id }}" value="{{ $subclasificacion->id }}">{{ $subclasificacion->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-md-4 col-12">

                                        {!! Form::label('technic','Técnica:') !!}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-signature"></i>
                                                </span>
                                            </div>
                                            {!! Form::text('technic', null, [ 'class' => 'form-control', 'id' => 'autocompleteInput']) !!}
                                        </div>
                                        <ul id="suggestionsList"></ul>
                                    </div>


                                    <div class="col-md-2 col-12">

                                        {!! Form::label('height','Alto:') !!}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-percent"></i>
                                                </span>
                                            </div>
                                            {!! Form::number('height', null, [ 'class' => 'form-control']) !!}
                                        </div>

                                    </div>

                                    <div class="col-md-2 col-12">

                                        {!! Form::label('width','Ancho:') !!}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-percent"></i>
                                                </span>
                                            </div>
                                            {!! Form::number('width', null, [ 'class' => 'form-control']) !!}
                                        </div>

                                    </div>

                                    <div class="col-md-3 col-12">

                                        {!! Form::label('price_min','Precio min:') !!}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            {!! Form::text('price_min', null, [ 'class' => 'form-control']) !!}
                                        </div>

                                    </div>

                                    <div class="col-md-3 col-12">

                                        {!! Form::label('price_max','Precio Max:') !!}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            {!! Form::text('price_max', null, [ 'class' => 'form-control']) !!}
                                        </div>

                                    </div>

                                    <div class="col-md-2 col-12">

                                        {!! Form::label('year','Año:') !!}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-percent"></i>
                                                </span>
                                            </div>
                                            {!! Form::number('year', null, [ 'class' => 'form-control']) !!}
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

                                </div>

                                {{-- <div class="row" style="padding: 16px;">
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

                                </div> --}}



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
    $(document).ready(function () {
        $('#autocompleteInput').on('input', function () {
            var query = $(this).val();

            $.ajax({
                url: '/autocomplete',
                type: 'GET',
                data: {query: query},
                success: function (data) {
                    displaySuggestions(data);
                }
            });
        });

        function displaySuggestions(suggestions) {
            var list = $('#suggestionsList');
            list.empty();

            suggestions.forEach(function (suggestion) {
                var listItem = $('<li>').text(suggestion.name );
                listItem.click(function () {
                    $('#autocompleteInput').val(suggestion.name );
                    list.empty();
                });

                list.append(listItem);
            });
        }
    });
</script>
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
