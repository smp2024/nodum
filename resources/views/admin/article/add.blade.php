@extends('admin.master')
@section('title', 'Artículos')

@section('breadcrumb')

<li class="breadcrumb-item">
    <a href="{{ url('/admin/articles/all') }}">
        <i class="fas fa-article"></i>
        Artículos
    </a>
</li>
<li class="breadcrumb-item">
    <a href="{{ url('/admin/articles/add/') }}">
        <i class="fas fa-plus"></i>
        Agregar artículo
    </a>
</li>

@endsection
@section('css')
<style>
    .active {
        font-weight: 700;
    }
</style>
@endsection
@section('content')

<div class="container-fluid">

    <div class="row">

        <div class="col-12">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title">
                        <i class="fas fa-plus"></i>
                        Agregar artículo
                    </h2>
                </div>
                <div class="inside">

                    @if (kvfj(Auth::user()->permissions, 'article_add'))

                    {!! Form::open(['url' => '/admin/article/add', 'files' => true]) !!}

                    <div class="row" style="padding: 16px;">

                        <div class="col-md-7 col-12">

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
                        <div class="col-md-5 col-12">

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

                            {!! Form::label('category_id','Categoría:') !!}
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-school"></i>
                                    </span>
                                </div>
                                <select class="custom-select" id="category_id_" name="category_id">
                                    <option value="0" selected>Seleccionar categoría</option>
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
                                <select class="custom-select" id="technic" name="technic">
                                    <!-- Técnicas se llenarán dinámicamente -->
                                </select>
                            </div>
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

                        <div class="row" style="padding: 16px; padding-top: 1px;">
                            <div class="col-md-10 col-12">
                                {!! Form::label('file', 'Imagen:') !!}
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

                        <div id="imagePreview" style="margin-top: 10px; padding: 16px;" class="text-center">
                            <img id="previewImg" src="#" alt="Vista previa de la imagen" style="max-width: 30%; height: auto; display: none;" />
                        </div>
                    </div>

                    <div class="currency-selector" style="padding-left: 16px;">
                        <span id="mxTab" class="currency-tab active" onclick="showCurrency('mx')">MX</span>
                        <span id="usTab" class="currency-tab" onclick="showCurrency('us')">USA</span>
                    </div>

                    <div id="mxPrices" class="row" style="padding: 16px;">

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

                    </div>

                    <div id="usPrices" class="row" style="padding: 16px; display: none;">

                        <div class="col-md-3 col-12">

                            {!! Form::label('price_min_us','Price Min:') !!}
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-dollar-sign"></i>
                                    </span>
                                </div>
                                {!! Form::text('price_min_us', null, [ 'class' => 'form-control']) !!}
                            </div>

                        </div>

                        <div class="col-md-3 col-12">

                            {!! Form::label('price_max_us','Price Max:') !!}
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-dollar-sign"></i>
                                    </span>
                                </div>
                                {!! Form::text('price_max_us', null, [ 'class' => 'form-control']) !!}
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
                var listItem = $('<li>').text(suggestion.name);
                listItem.click(function () {
                    $('#autocompleteInput').val(suggestion.name);
                    list.empty();
                });

                list.append(listItem);
            });
        }

        $('#category_id_').on('change', function () {
            let categoryId = $(this).val();
            // console.log(categoryId);
            $.ajax({
                url: '/api/get-techniques-by-category',
                type: 'POST',
                data: {category_id: categoryId},
                success: function (data) {
                    console.log(data);
                    var techniqueSelect = $('#technic');
                    techniqueSelect.empty();

                    data.forEach(function (technique) {
                        techniqueSelect.append(
                            $('<option></option>')
                            .attr('value', technique.id)
                            .text(technique.name)
                        );
                    });
                }
            });
        });

        $('#customFile').change(function() {
        var fileName = $(this).val().split('\\').pop();
        console.log(fileName);

        if (fileName) {
            $('#confirm_img').html('<i class="fas fa-check text-success"></i>');
        } else {
            $('#confirm_img').html('<i class="fas fa-times text-danger"></i>');
        }

        let file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#previewImg').attr('src', e.target.result);
                $('#previewImg').show();
            }
            reader.readAsDataURL(file);
        } else {
            $('#previewImg').hide();
        }
    });
    });

    function showCurrency(currency) {
        if (currency === 'mx') {
            document.getElementById('mxTab').classList.add('active');
            document.getElementById('usTab').classList.remove('active');
            document.getElementById('mxPrices').style.display = 'flex';
            document.getElementById('usPrices').style.display = 'none';

        } else if (currency === 'us') {
            document.getElementById('usTab').classList.add('active');
            document.getElementById('mxTab').classList.remove('active');
            document.getElementById('mxPrices').style.display = 'none';
            document.getElementById('usPrices').style.display = 'flex';
        }
    }
</script>
<script>
    $(document).ready(function () {
        $('#customFile').change(function () {
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
