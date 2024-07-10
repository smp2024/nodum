@extends('admin.master')
@section('title', 'Editar Articulo')

@section('breadcrumb')

    <li class="breadcrumb-item">
        <a href="{{ url('/admin/articles/all') }}">
            <i class="fas fa-article"></i>
            Articulos
        </a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/article/'.$product->id.'/edit/') }}">
            <i class="fas fa-plus"></i>
            Editar articulo {{ $product->name  }}
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
                            Editar articulo
                        </h2>
                    </div>
                    <div class="inside">

                        @if (kvfj(Auth::user()->permissions, 'article_add'))

                            {!! Form::open(['url' => '/admin/article/'.$product->id.'/edit', 'files' => true]) !!}

                                <div class="row" style="padding: 16px;">

                                    <div class="col-md-6 col-12">

                                        {!! Form::label('name','Nombre:') !!}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-signature"></i>
                                                </span>
                                            </div>
                                            {!! Form::text('name', $product->name, [ 'class' => 'form-control']) !!}
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
                                            {{ Form::select('category_id', $subclasi, $product->category_id, ['class'=>'form-control']) }}
                                        </div>

                                    </div>
                                    
                                    <div class="col-md-4 col-12">

                                        {!! Form::label('artist_id','Artista:') !!}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-school"></i>
                                                </span>
                                            </div>
                                            {{ Form::select('artist_id', $artists, $product->artist_id, ['class'=>'form-control']) }}
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
                                            {!! Form::text('technic', $product->getSubCategory->name, [ 'class' => 'form-control', 'id' => 'autocompleteInput']) !!}
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
                                            {!! Form::number('height', $product->height, [ 'class' => 'form-control']) !!}
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
                                            {!! Form::number('width', $product->width, [ 'class' => 'form-control']) !!}
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
                                            {!! Form::text('price_min', $product->price_min, [ 'class' => 'form-control']) !!}
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
                                            {!! Form::text('price_max', $product->price_max, [ 'class' => 'form-control']) !!}
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
                                            {!! Form::number('year', $product->year, [ 'class' => 'form-control']) !!}
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
                                                {!! Form::file('file', ['class' => 'custom-file-input', 'id' => 'customFile', 'required' => false]) !!}
                                                <label class="custom-file-label h-100 m-0" for="customFile">Choose File</label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-3">
                                        {!! Form::label('status ','Estado:') !!}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                {!! Form::select('status', [ '0' => 'Borrador', '1' => 'Publicado'], $product->status, ['class' => 'custom-select']) !!}
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                {{-- <div class="row" style="padding: 16px;">
                                    <div class="col-md-12">
                                        <div class="form-group">

                                            {{ Form::label('tags','Etiquetas:') }}
                                            <div>
                                                <tr>

                                                    @foreach($tags as  $brand)
                                                        <label class="container col-sm-3">{!! $brand->name !!}
                                                            <input type="checkbox" class="brand_id" id="{{$brand->id}}" name="tags[]"
                                                            value="{{@(!empty($brand->id) ? $brand->id : "")}}"
                                                                @foreach($foods0 as $_sel0)
                                                                    {{($brand->id == $_sel0->tag_id ? "checked='checked'": '')}}
                                                                @endforeach
                                                            />
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    @endforeach

                                                </tr>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                {{-- <div class="row" style="padding: 16px;">
                                    <div class="col-md-12">
                                        <div class="form-group">

                                            {{ Form::label('description','Descripción:') }}
                                            <div class="input-group-prepend">
                                                {!! Form::textarea('description', $product->description, ['class' => 'form-control Ckeditor', 'id' => 'ckeditor']) !!}
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
                            <img src="{{ url('/multimedia'.$product->file_path.'/'.$product->slug.'/'.$product->file) }}" class="img-fluid">
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

 //Funcion Autocomplete
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
    //
  </script>
@endsection
