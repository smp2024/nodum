@extends('master')
@section('title', $section)
@section('css')
<style>
    .highlight {
        display: block !important;
    }
    .no-highlight {
        display: none;
    }
    .image-container {
        height: 85%;
        justify-content: start;
        display: flex;
        align-items: end;
    }
    .image-container img{
        width: 100%;
        background-size: auto 100%;
        height: auto;
        max-height: 100%;
    }
    img:hover{
        box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.3);
    }
    .title {
        font-style: italic;
        text-transform: inherit;
    }
    .image-container  {
        transition: all .05s ease-in-out;
        transform-origin: center center;
    }

    .image-container:hover {
        padding: 1px;
        /* border: 1px solid #000 !important; */
    }
    .medidas {
        display: none;
    }

    .arrow {
        float: right;
    }

    .rotate {
        transform: rotate(180deg);
    }
    .filtro ul {
        max-height: 300px;
        overflow: auto;
    }

    input[type='range'] {
    display: block;
    width: 100%;
    }

    input[type='range']:focus {
    outline: none;
    }

    input[type='range'],
    input[type='range']::-webkit-slider-runnable-track,
    input[type='range']::-webkit-slider-thumb {
    -webkit-appearance: none;
    }

    input[type=range]::-webkit-slider-thumb {
    background-color: #000;
    width: 21px;
    height: 21px;
    border: 3px solid #ddd;
    border-radius: 50%;
    margin-top: -9px;
    }

    input[type=range]::-moz-range-thumb {
    background-color: #000;
    width: 16px;
    height: 16px;
    border: 3px solid #ddd;
    border-radius: 50%;
    }

    input[type=range]::-ms-thumb {
    background-color: #000;
    width: 21px;
    height: 21px;
    border: 3px solid #ddd;
    border-radius: 50%;
    }

    input[type=range]::-webkit-slider-runnable-track {
    background-color: #333;
    height: 5px;
    -webkit-appearance: none;
    background-image:linear-gradient(to right, #000 calc(var(--value)*1%), black 0);
    }

    input[type=range]:focus::-webkit-slider-runnable-track {
    outline: none;
    }

    input[type=range]::-moz-range-track {
    -webkit-appearance: none;
    background-image:linear-gradient(to right, #000 calc(var(--value)*1%), black 0);
    height: 5px;
    }

    input[type=range]::-ms-track {
    background-color: #777;
    height: 3px;
    }


    .c1 input:checked ~ .checkmark {
        background-color: #000 !important;
    }
    .container {
        display: block;
        position: relative;
        padding-left: 18px;
        cursor: pointer;
        font-size: 15px;
    }

    .container input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }
    .checkmark {
        margin-top: 4px;
        position: absolute;
        top: 0;
        left: 0;
        height: 15px;
        width: 15px;
        background-color: #eee;
        border-radius: 3px;
    }
    .container:hover input ~ .checkmark {
    background-color: #000;
    }

    .checkmark:after {
    content: "";
    position: absolute;
    display: none;
    }

    .container input:checked ~ .checkmark:after {
    display: block;
    }

    .container .checkmark:after {
    left: 5px;
    top: 1px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
    }
</style>

@endsection
@section('content')
    <div id="main_" class="row w-100 d-flex justify-content-start align-items-start m-0 h-100" style="padding-top: 10px;">

        @if ($countArt == 0)
            <h1 style="color: #fff;">Sin obras por el momento.</h1>
        @else
        <div class="col-lg-3 col-sm-5 col-5 d-flex justify-content-center align-items-center p-0 w-100" style="padding-left: 20px !important;">
            <!-- Sección de filtrado -->
            <div class="filtro w-100">
                {!! Form::open(['url' => '/filter-search', 'id' => 'filterForm', 'files' => true, 'method' => 'post']) !!}

                    <div class="content ">
                        <h4 class="toggle-list-categoria" data-filter="cat"> Categorías <span class="arrow"></span></h4>
                        <ul class="cat medidas" >

                            <!-- Lista de categorías -->

                            @foreach($categories as $category)

                                <li>
                                    <label class="container c1" >
                                        <input  onchange="handleCheckboxChangeCategory(this, {{ $category->id }})" type="checkbox" name="categoria_checkbox[]" value="{{ $category->id }}" id="category_{{ $category->id }}"  >
                                        <span class="checkmark"></span>
                                        <a href="#" onclick="filterByCategory('{{ $category->id }}')">{{ $category->name }}</a>
                                    </label>
                                </li>

                            @endforeach

                        </ul>
                        <hr>
                    </div>

                    <div class="content">
                        <h4 class="toggle-list-artista" data-filter="artist"> Artistas <span class="arrow"></span></h4>
                        <ul class="artist medidas" >

                            @php
                                foreach ($articles as $article) {
                                    $artists[] = $article->artist_id;
                                }
                                $artists = array_unique($artists);
                                sort($artists);
                            @endphp
                            @foreach ($artists as $artist)
                                @foreach ($artistas as $artista)
                                    @if ($artista->id == $artist)
                                        <li>

                                        <label class="container c1" >
                                            <input onchange="handleCheckboxChangeArtist(this, {{ $artista->id }})" type="checkbox" name="artista_checkbox[]" value="{{ $artista->id }}" id="artista_{{ $tecnica->id }}"  >
                                            <span class="checkmark"></span>
                                            <a href="#" onclick="filterByArtist('{{ $artista->id }}')">{{ $artista->name }} {{ $artista->lastname }} </a>
                                        </label>
                                        </li>
                                    @endif
                                @endforeach
                            @endforeach
                        </ul>
                        <hr>
                    </div>

                    <div class="content">
                        <h4 class="toggle-list-tecnica" data-filter="tec"> Técnicas <span class="arrow"></span></h4>
                        <ul class="tec medidas" >

                            @php
                                foreach ($articles as $article) {
                                    $technics[] = $article->subcategory_id;
                                }
                                $technics = array_unique($technics);
                                sort($technics);
                            @endphp
                            @foreach ($technics as $technic)
                                @foreach ($tecnicas as $tecnica)
                                    @if ($tecnica->id == $technic)
                                    <li>

                                    <label class="container c1" >
                                        <input onchange="handleCheckboxChangeTecnic(this, {{ $tecnica->id }})" type="checkbox" name="tecnica_checkbox[]" value="{{ $tecnica->id }}" id="tecnica_{{ $tecnica->id }}"  >
                                        <span class="checkmark"></span>
                                        <a href="#" onclick="filterByTechnic('{{ $tecnica->id }}')">{{ $tecnica->name }}</a>
                                    </label>
                                    </li>
                                    @endif
                                @endforeach
                            @endforeach
                        </ul>
                        <hr>
                    </div>

                    <div class="content">
                        <h4>Precio</h4>
                        <div class="currency-selector">
                            <span id="mxTab" class="currency-tab active" onclick="showCurrency('mx')">MX</span>
                            <span id="usTab" class="currency-tab" onclick="showCurrency('us')">USA</span>
                        </div>

                        <!-- Rango de precios para MX -->
                        <div id="mxPrices">

                            <p id="minPrice" class="m-0">Desde <span id="priceValue" style="width: 33%;" class="m-0 ml-2"> ${{ number_format($articles->min('price_min'), 2, '.', ',') }}</span></p>
                            {{-- <input type="number" name="price_min" value="" id="pMin" hidden> --}}
                            <div style="display: inline-flex">
                                <input name="price_min"  type="range" min="{{ $articles->min('price_min') }}" max="{{ $articles->max('price_max') }}" value="{{ $articles->min('price_min') }}" id="priceRange">

                            </div>
                            <p id="maxPrice" class="m-0">Hasta ${{ number_format($articles->max('price_max'), 2, '.', ',') }}</p>
                            <input name="price_max" hidden type="range" min="{{ $articles->min('price_min') }}" max="{{ $articles->max('price_max') }}" value="{{ $articles->max('price_max') }}" id="">

                        </div>

                        <!-- Rango de precios para USA (inicialmente oculto) -->
                        <div id="usPrices" style="display: none;">
                            <p id="minPriceUS" class="m-0">From <span id="priceValueUS" style="width: 33%;" class="m-0 ml-2"> ${{ number_format($articles->min('price_min_us'), 2, '.', ',') }}</span></p>
                            <div style="display: inline-flex">
                                <input name="price_min_us"  type="range" min="{{ $articles->min('price_min_us') }}" max="{{ $articles->max('price_max_us') }}" value="{{ $articles->min('price_min_us') }}" id="priceRangeUS">
                            </div>
                            <p id="maxPriceUS" class="m-0">To ${{ number_format($articles->max('price_max_us'), 2, '.', ',') }}</p>
                            <input name="price_max_us" hidden type="range" min="{{ $articles->min('price_max_us') }}" max="{{ $articles->max('price_max_us') }}" value="{{ $articles->max('price_max_us') }}" id="">

                        </div>

                        <hr>
                    </div>

                    <div class="content">
                        <h4>Medidas</h4>
                        <!-- Rango de medidas -->
                        <ul>
                            <li>
                                {!! Form::checkbox('measures[]', 1, [ 'class' => 'form-control ml-2']) !!}
                                {!! Form::label('catSma','Pequeño') !!}

                            <li>

                                {!! Form::checkbox('measures[]', 2, [ 'class' => 'form-control ml-2']) !!}
                                {!! Form::label('catMed','Mediano') !!}
                            </li>
                            <li>
                                {!! Form::checkbox('measures[]', 3, [ 'class' => 'form-control ml-2']) !!}
                                {!! Form::label('catLar','Grande') !!}
                            </li>
                        </ul>
                    </div>

                    {!! Form::submit('Guardar', ['class' => 'btn btn-success mt16']) !!}

                {!! Form::close() !!}
            </div>

        </div>
        <!-- info Obras erg-->
        <div id="content-articles" class="col-lg-9 col-sm-7 col-7 h-100 w-100 d-flex justify-content-center align-items-center p-0" >
            <div class="row w-100 h-100">
               <!-- Listado de artículos -->
                    @foreach($articles as $article)
                    {{-- <div class=" mt-3"> --}}
                        <div class="col-lg-4 col-md-6 col-sm-12 content-articles mt-2"  alt="{{ $article->name }}');"  data-year="{{ $article->year }}" data-category="{{ $article->category_id }}" data-technic="{{ $article->subcategory_id }}" data-pricemin="{{ $article->price_min }}" data-pricemax="{{ $article->price_max }}" data-priceminus="{{ $article->price_min_us }}" data-pricemaxus="{{ $article->price_max_us }}" data-width="{{ $article->width }}"  data-height="{{ $article->height }}" data-artist="{{ $article->artist_id }}" data-show="0" >


                            <a href="{{ url('seccion/obras/'.$article->id) }}">
                                <div class="d-flex justify-content-start align-items-end w-100" style="height: 60%;">

                                    <div class="image-container">
                                        <img src="{{ url('multimedia'.$article->file_path.'/'.$article->slug. '/'.$article->file) }}" alt="{{ $article->name }}" >
                                    </div>

                                </div>
                                <div style="height: 40%;">
                                    <p class="m-0 text-start" style="font-size: calc(0.5rem + 0.4vw);">{{ $article->name }}</p>
                                    @foreach ($tecnicas as $tecnica)
                                        @if ($tecnica->id == $article->subcategory_id)
                                            <p class="m-0 text-start" style="font-size: 13px;">{{ $tecnica->name }}</p>
                                        @endif
                                    @endforeach
                                     @foreach ($artistas as $artista)
                                        @if ($artista->id == $article->artist_id)
                                            <p class="m-0 text-start" style="font-size: 13px;">{{ $artista->name }} {{ $artista->lastname }}</p>
                                        @endif
                                    @endforeach

                                    <p class="m-0 text-start" style="font-size: 13px;">{{ $article->year }}</p>
                                    <p class="m-0 text-start" style="font-size: 13px;">{{ $article->width }} x {{ $article->height }} cm</p>

                                </div>
                            </a>

                        </div>
                    {{-- </div> --}}


                    @endforeach
            </div>
        </div>
        @endif

    </div>
@endsection

@section('scripts')
    <script>
        function showCurrency(currency) {
            if (currency === 'mx') {
                document.getElementById('mxTab').classList.add('active');
                document.getElementById('usTab').classList.remove('active');
                document.getElementById('mxPrices').style.display = 'block';
                document.getElementById('usPrices').style.display = 'none';
                $('.mxPrices_').show();
                $('.usPrices_').hide();
                document.getElementById('priceRange').value = "{{ $articles->min('price_min') }}";

                document.getElementById('pMin').value = "{{ $articles->min('price_min') }}";
                document.getElementById('priceValue').textContent = "${{ number_format($articles->min('price_min'), 2, '.', ',') }}";

                showall();
            } else if (currency === 'us') {
                document.getElementById('usTab').classList.add('active');
                document.getElementById('mxTab').classList.remove('active');
                document.getElementById('mxPrices').style.display = 'none';
                document.getElementById('usPrices').style.display = 'block';
                $('.mxPrices_').hide();
                $('.usPrices_').show();
                document.getElementById('priceRangeUS').value = "{{ $articles->min('price_min_us') }}";
                document.getElementById('priceValueUS').textContent = "${{ number_format($articles->min('price_min_us'), 2, '.', ',') }}";
                showall();
            }

        }
        const priceRange = document.getElementById('priceRange');
        const minPrice = document.getElementById('minPrice');
        const maxPrice = document.getElementById('maxPrice');

        const priceRangeUS = document.getElementById('priceRangeUS');
        const minPriceUS = document.getElementById('minPriceUS');
        const maxPriceUS = document.getElementById('maxPriceUS');

        const contentArticles = document.getElementById('content-articles');

        $(document).ready(function(){

            var base = location.protocol + '//' + location.host;
            var route = document.title;

            $('.toggle-list-categoria').click(function() {
                var filter = $(this).data('filter');
                var $ul = $('ul.' + filter);
                var $arrow = $(this).find('.arrow');
                if ($ul.hasClass('medidas')) {
                    $ul.removeClass('medidas');
                    $arrow.addClass('rotate');
                } else {
                    $ul.addClass('medidas');
                    $arrow.removeClass('rotate');
                }
            });
            $('.toggle-list-artista').click(function() {
                var filter = $(this).data('filter');
                var $ul = $('ul.' + filter);
                var $arrow = $(this).find('.arrow');
                if ($ul.hasClass('medidas')) {
                    $ul.removeClass('medidas');
                    $arrow.addClass('rotate');
                } else {
                    $ul.addClass('medidas');
                    $arrow.removeClass('rotate');
                }
            });
            $('.toggle-list-tecnica').click(function() {
                var filter = $(this).data('filter');
                var $ul = $('ul.' + filter);
                var $arrow = $(this).find('.arrow');
                if ($ul.hasClass('medidas')) {
                    $ul.removeClass('medidas');
                    $arrow.addClass('rotate');
                } else {
                    $ul.addClass('medidas');
                    $arrow.removeClass('rotate');
                }
            });
        });

        function filterByYear(year) {
            showall();
            if (year === 'Todos') {
                $('#content-articles .content-articles').show();
            } else {
                $('#content-articles .content-articles').hide();
                $('#content-articles .content-articles[data-year="' + year + '"]').show();
            }
            $('#content-articles .content-articles[data-year="' + year + '"]').show();
        }

        function filterByCategory(year) {
            showall();
            if (year === 'Todos') {
                $('#content-articles .content-articles').show();
            } else {
                $('#content-articles .content-articles').hide();
                $('#content-articles .content-articles[data-category="' + year + '"]').show();
            }
            $('#content-articles .content-articles[data-category="' + year + '"]').show();
        }

        function filterByTechnic(year) {
            showall();
            if (year === 'Todos') {
                $('#content-articles .content-articles').show();
            } else {
                $('#content-articles .content-articles').hide();
                $('#content-articles .content-articles[data-technic="' + year + '"]').show();
            }
            $('#content-articles .content-articles[data-technic="' + year + '"]').show();
        }

        function filterByArtist(year) {
            showall();
            if (year === 'Todos') {
                $('#content-articles .content-articles').show();
            } else {
                $('#content-articles .content-articles').hide();
                $('#content-articles .content-articles[data-artist="' + year + '"]').show();
            }
            $('#content-articles .content-articles[data-artist="' + year + '"]').show();
        }

        function filterArticlesByPrice() {

            const articles = contentArticles.getElementsByClassName('content-articles');
            const selectedPrice = parseInt(priceRange.value);
            showall();

            for (let i = 0; i < articles.length; i++) {
                const article = articles[i];
                const articlePricemin = parseInt(article.getAttribute('data-pricemin'));
                const articlePricemax = parseInt(article.getAttribute('data-pricemax'));

                if ( articlePricemin >= selectedPrice || selectedPrice <= articlePricemax   )  {
                    article.style.display = 'block';
                } else {
                    article.style.display = 'none';
                }
            }
        }

        function filterArticlesByPriceUS() {

            const articles = contentArticles.getElementsByClassName('content-articles');
            const selectedPrice = parseInt(priceRangeUS.value);
            showall();

            for (let i = 0; i < articles.length; i++) {
                const article = articles[i];
                const articlePricemin = parseInt(article.getAttribute('data-priceminus'));
                const articlePricemax = parseInt(article.getAttribute('data-pricemaxus'));

                if ( articlePricemin >= selectedPrice || selectedPrice <= articlePricemax   )  {
                    article.style.display = 'block';
                } else {
                    article.style.display = 'none';
                }
            }
        }

        function darFormatoPrecio(precio) {
            return '$' + parseFloat(precio).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
        function darFormatoPrecioUS(precio) {
            return '$' + parseFloat(precio).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }

        priceRange.addEventListener('input', () => {

            priceValue.textContent = darFormatoPrecio(priceRange.value);
            showall();
            filterArticlesByPrice();
        });

        priceRangeUS.addEventListener('input', () => {

            priceValueUS.textContent = darFormatoPrecioUS(priceRangeUS.value);
            showall();
            filterArticlesByPriceUS();
        });

        function highlightSize(size) {

            // $('#content-articles .content-articles[data-show=0]').hide();
            showall();
            const articles = document.querySelectorAll('#content-articles .content-articles');
            articles.forEach(article => {
                //
                const width = parseInt(article.getAttribute('data-width'));
                const height = parseInt(article.getAttribute('data-height'));

                if (size === 'pequeño' && (width <= 40)) {
                    // article.classList.remove('no-highlight');
                    // article.classList.add('highlight');
                    if (height <= 40) {

                        console.log(article);
                    } else {
                        article.classList.add('no-highlight');
                    }

                }
                //  else {
                //     article.classList.add('no-highlight');

                // }

                // if (size === 'mediano' && (width >= 40 && width <= 100) && (height >= 40 && height <= 100)) {
                //     article.classList.remove('no-highlight');
                //     article.classList.add('highlight');
                //     console.log('mediano');
                // } else {
                //     article.classList.add('no-highlight');

                // }

                // if (size === 'grande' && (width >= 100 || height >= 100)) {
                //     article.classList.remove('no-highlight');
                //     article.classList.add('highlight');
                //     console.log('grande');
                // } else {
                //     article.classList.add('no-highlight');
                // }
            });
        }
        if (screen.width < 800) {
            $('#main_').removeClass("row");
        }

        function showall(){
            $('#content-articles .content-articles[data-show=0]').show();

        }

        function handleCheckboxChangeTecnic(checkbox, year) {
            if (checkbox.checked) {
                $('#content-articles .content-articles').hide();
                $('#content-articles .content-articles[data-technic="' + year + '"]').show();
                var anyChecked = $('input[name="tecnica_checkbox[]"]:checked').length > 0;
                if (anyChecked) {
                    var checkedValues = $('input[name="tecnica_checkbox[]"]:checked').map(function(){
                        return this.value;
                    }).get();
                    $('#content-articles .content-articles').hide();
                    checkedValues.forEach(function(value) {
                        $('#content-articles .content-articles[data-technic="' + value + '"]').show();
                    });
                } else {
                    $('#content-articles .content-articles').show();
                }
            } else {
                var anyChecked = $('input[name="tecnica_checkbox[]"]:checked').length > 0;
                if (!anyChecked) {
                    $('#content-articles .content-articles').show();
                } else {
                    var checkedValues = $('input[name="tecnica_checkbox[]"]:checked').map(function(){
                        return this.value;
                    }).get();
                    $('#content-articles .content-articles').hide();
                    checkedValues.forEach(function(value) {
                        $('#content-articles .content-articles[data-technic="' + value + '"]').show();
                    });
                }
            }
        }
        function handleCheckboxChangeArtist(checkbox, year) {
            if (checkbox.checked) {
                $('#content-articles .content-articles').hide();
                $('#content-articles .content-articles[data-artist="' + year + '"]').show();
                var anyChecked = $('input[name="artista_checkbox[]"]:checked').length > 0;
                if (anyChecked) {
                    var checkedValues = $('input[name="artista_checkbox[]"]:checked').map(function(){
                        return this.value;
                    }).get();
                    $('#content-articles .content-articles').hide();
                    checkedValues.forEach(function(value) {
                        $('#content-articles .content-articles[data-artist="' + value + '"]').show();
                    });
                } else {
                    $('#content-articles .content-articles').show();
                }
            } else {
                var anyChecked = $('input[name="artista_checkbox[]"]:checked').length > 0;
                if (!anyChecked) {
                    $('#content-articles .content-articles').show();
                } else {
                    var checkedValues = $('input[name="artista_checkbox[]"]:checked').map(function(){
                        return this.value;
                    }).get();
                    $('#content-articles .content-articles').hide();
                    checkedValues.forEach(function(value) {
                        $('#content-articles .content-articles[data-artist="' + value + '"]').show();
                    });
                }
            }
        }
        function handleCheckboxChangeCategory(checkbox, year) {
            if (checkbox.checked) {
                $('#content-articles .content-articles').hide();
                $('#content-articles .content-articles[data-category="' + year + '"]').show();
                var anyChecked = $('input[name="categoria_checkbox[]"]:checked').length > 0;
                if (anyChecked) {
                    var checkedValues = $('input[name="categoria_checkbox[]"]:checked').map(function(){
                        return this.value;
                    }).get();
                    $('#content-articles .content-articles').hide();
                    checkedValues.forEach(function(value) {
                        $('#content-articles .content-articles[data-category="' + value + '"]').show();
                    });
                } else {
                    $('#content-articles .content-articles').show();
                }
            } else {
                var anyChecked = $('input[name="categoria_checkbox[]"]:checked').length > 0;
                if (!anyChecked) {
                    $('#content-articles .content-articles').show();
                } else {
                    var checkedValues = $('input[name="categoria_checkbox[]"]:checked').map(function(){
                        return this.value;
                    }).get();
                    $('#content-articles .content-articles').hide();
                    checkedValues.forEach(function(value) {
                        $('#content-articles .content-articles[data-category="' + value + '"]').show();
                    });
                }
            }
        }
    </script>
<script>
    $(document).ready(function() {
        $('#filterForm').on('submit', function(event) {
            event.preventDefault(); // Previene el envío del formulario de manera tradicional

            // Obtén los datos del formulario
            var formData = new FormData(this);
            console.log(formData);
            console.log('Entro');
            // Realiza la solicitud AJAX usando jQuery
            $.ajax({
                url: '/api/get-articles',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                before: function(response) {
                    console.log(response);
                },
                success: function(response) {
                    // Maneja la respuesta del servidor
                    console.log(response); // Muestra la respuesta en la consola
                    // Puedes actualizar la página o mostrar los resultados de la búsqueda aquí
                },
                error: function(xhr, status, error) {
                    // Maneja cualquier error
                    console.error('Error al enviar el formulario:', error);
                }
            });
        });
    });
    </script>
@endsection
