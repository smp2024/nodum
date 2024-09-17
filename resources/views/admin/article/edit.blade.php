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

                                    <div class="col-md-7 col-12">

                                        {!! Form::label('name','Título:') !!}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-signature"></i>
                                                </span>
                                            </div>
                                            {!! Form::text('name', $product->name, [ 'class' => 'form-control']) !!}
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
                                            {{ Form::select('artist_id', $artists, $product->artist_id, ['class'=>'form-control']) }}
                                        </div>

                                    </div>


                                    <div class="col-md-6 col-12">

                                        {!! Form::label('category_id','Categoria:') !!}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fal fa-send-backward"></i>
                                                </span>
                                            </div>
                                            {{ Form::select('category_id', $subclasi, $product->category_id, ['class'=>'form-control']) }}
                                        </div>

                                    </div>


                                    <div class="col-md-6 col-12">
                                        <input id="sub_id" type="number" name="sub_id" value="{{$product->subcategory_id}}" hidden>
                                        {!! Form::label('technic','Técnica:') !!}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fal fa-pencil-paintbrush"></i>
                                                </span>
                                            </div>
                                            {!! Form::select('technic',$tecnicas, $product->subcategory_id, ['class' => 'form-control']) !!}

                                        </div>
                                        <ul id="suggestionsList"></ul>
                                    </div>

                                    <div class="col-md-4 col-12">

                                        {!! Form::label('height','Alto:') !!}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fal fa-ruler-vertical"></i>
                                                </span>
                                            </div>
                                            {!! Form::number('height', $product->height, [ 'class' => 'form-control']) !!}
                                        </div>

                                    </div>

                                    <div class="col-md-4 col-12">

                                        {!! Form::label('width','Ancho:') !!}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fal fa-ruler-horizontal"></i>
                                                </span>
                                            </div>
                                            {!! Form::number('width', $product->width, [ 'class' => 'form-control']) !!}
                                        </div>

                                    </div>

                                    <div class="col-md-4 col-12">

                                        {!! Form::label('depth','Profundidad:') !!}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fal fa-ruler"></i>
                                                </span>
                                            </div>
                                            {!! Form::number('depth', $product->depth, [ 'class' => 'form-control']) !!}
                                        </div>

                                    </div>
                                    <div class="col-md-4 col-12">

                                        {!! Form::label('year','Año:') !!}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fal fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            {!! Form::number('year', $product->year, [ 'class' => 'form-control']) !!}
                                        </div>

                                    </div>
                                    <div class="col-7">

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
                                    <div class="col-md-4 col-12">

                                        {!! Form::label('sku','SKU:') !!}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-barcode"></i>
                                                </span>
                                            </div>
                                            {!! Form::text('sku', $product->sku, [ 'class' => 'form-control', 'disabled' => 'true']) !!}
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

                                <div class="currency-selector" style="padding-left: 16px;">
                                    <span id="mxTab" class="currency-tab active" onclick="showCurrency('mx')">MX</span>
                                    <span id="usTab" class="currency-tab" onclick="showCurrency('us')">USA</span>
                                </div>

                                <div id="mxPrices" class="row"  style="padding: 16px;">

                                    <div class="col-md-3 col-12">

                                        {!! Form::label('price_min','Precio min:') !!}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            {!! Form::text('price_min', number_format($product->price_min, 2, '.', ','), [ 'class' => 'form-control']) !!}
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
                                            {!! Form::text('price_max', number_format($product->price_max, 2, '.', ','), [ 'class' => 'form-control']) !!}
                                        </div>

                                    </div>

                                </div>

                                <div id="usPrices" class="row"  style="padding: 16px; display: none;">

                                    <div class="col-md-3 col-12">

                                        {!! Form::label('price_min_us','Price Min:') !!}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            {!! Form::text('price_min_us', number_format($product->price_min_us, 2, '.', ','), [ 'class' => 'form-control']) !!}
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
                                            {!! Form::text('price_max_us', number_format($product->price_max_us, 2, '.', ',') , [ 'class' => 'form-control']) !!}
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
                            <img src="{{ url('multimedia/'.$product->file_path.'/'.$product->file) }}" class="img-fluid">
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>
@stop


@section('scripts')


<script type="text/javascript">

    $(document).ready(function () {

        $('#category_id').on('change', function () {
            let categoryId = $(this).val();
            let currentSelectedTechnic = $('#technic').val();
            let technic_user = $('#sub_id').val();

            $.ajax({
                url: '/api/get-techniques-by-category',
                type: 'POST',
                data: { category_id: categoryId },
                success: function (data) {
                    let techniqueSelect = $('#technic');
                    techniqueSelect.empty();

                    data.forEach(function (technique) {
                        techniqueSelect.append(
                            $('<option></option>')
                                .attr('value', technique.id)
                                .text(technique.name)
                        );
                        techniqueSelect.val(technic_user);
                    });


                }
            });
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
@endsection
