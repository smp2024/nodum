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
        height: 100%;
        background-repeat: no-repeat;
        justify-content: start;
        display: flex;
        align-items: end;
    }
    .image-container img{
        width: 100%;
        height: auto;
        max-height: 100%;
    }
    .image-container:hover img{
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
        border-radius: 10px;
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
    top: 4.5px;
    width: 5px;
    height: 5px;
    border: solid white;
    border-radius: 10px;
    }
    .container input:checked ~ a {
        font-weight: 700;
    }
    .d-show {
        display: block;
    }
    h4, a {
        font-size: calc(0.8rem + 0.4vw);
    }
    .content li a {
        text-transform:lowercase;
    }
</style>

@endsection
@section('content')
    <div id="main_" class=" w-100 d-flex justify-content-start align-items-start m-0 h-100" >

        @if ($countArt == 0)
            <h1 style="color: #fff;">Sin obras por el momento.</h1>
        @else
        <div id="filterButton" >
            <button  type="button" class="btn btn-outline-dark"  data-whatever="filtro"  onclick="abrir()">
                <i class="fal fa-sort-shapes-down-alt"></i> Filtro
            </button>
        </div>

        <div id="filter" class=" col-lg-3 col-md-3 d-none d-sm-block col-12 justify-content-center align-items-center p-0 w-100 pt-5" style="padding-left: 20px !important; z-index:9999; background-color: #fff;">
            <!-- Sección de filtrado -->
            @include('blog.partials.filterSearch')

                <div id="filter__" class="row w-100 justify-content-end pr- d-none">
                    <button  type="button" class="btn btn-outline-danger mr-2" onclick="cerrar()"  data-whatever="Search" >
                        Cerrar
                    </button>
                    <button  type="button" class="btn btn-outline-dark"  data-whatever="Search" onclick="cerrar()">
                        Buscar
                    </button>
                </div>

        </div>

        <!-- info Obras erg-->
        <div id="content-articles" class="col-lg-9 col-md-9 col-12 h-100 w-100 d-flex justify-content-center align-items-center p-0 pt-2" >
            <!-- Listado de artículos -->
            <div class="row w-100 h-100" id="articles-list">

            </div>
        </div>
        @endif

    </div>
@endsection

@section('scripts')
    <script>

        const priceRange = document.getElementById('priceRange');
        const minPrice = document.getElementById('minPrice');
        const maxPrice = document.getElementById('maxPrice');

        const priceRangeUS = document.getElementById('priceRangeUS');
        const minPriceUS = document.getElementById('minPriceUS');
        const maxPriceUS = document.getElementById('maxPriceUS');

        // const contentArticles = document.getElementById('content-articles');

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

                // showall();
            } else if (currency === 'us') {
                document.getElementById('usTab').classList.add('active');
                document.getElementById('mxTab').classList.remove('active');
                document.getElementById('mxPrices').style.display = 'none';
                document.getElementById('usPrices').style.display = 'block';
                $('.mxPrices_').hide();
                $('.usPrices_').show();
                document.getElementById('priceRangeUS').value = "{{ $articles->min('price_min_us') }}";
                document.getElementById('priceValueUS').textContent = "${{ number_format($articles->min('price_min_us'), 2, '.', ',') }}";
                // showall();
            }

        }

        $(document).ready(function(){

            sendForm();
            var artist_id = {{ $artist_id ?? 'null' }};


            // console.log('artista id: '+artist_id);

            if (artist_id !== 'null') {
                $('input[type="checkbox"][value="' + artist_id + '"]').prop('checked', true);

                sendForm();
            }

            var base = location.protocol + '//' + location.host;
            var route = document.title;

            $('.toggle-list-categoria').click(function() {
                var filter = $(this).data('filter');
                var $ul = $('ul.' + filter);

                if ($ul.hasClass('medidas')) {
                    $ul.removeClass('medidas');
                    $(this).find('span').text('_');
                } else {
                    $ul.addClass('medidas');
                    $(this).find('span').text('+');
                }
            });
            $('.toggle-list-artista').click(function() {
                var filter = $(this).data('filter');
                var $ul = $('ul.' + filter);
                var $arrow = $(this).find('.arrow');
                if ($ul.hasClass('medidas')) {
                    $ul.removeClass('medidas');
                    $(this).find('span').text('_');
                } else {
                    $ul.addClass('medidas');
                    $(this).find('span').text('+');
                }
            });
            $('.toggle-list-tecnica').click(function() {
                var filter = $(this).data('filter');
                var $ul = $('ul.' + filter);
                var $arrow = $(this).find('.arrow');
                if ($ul.hasClass('medidas')) {
                    $ul.removeClass('medidas');
                    $(this).find('span').text('_');
                } else {
                    $ul.addClass('medidas');
                    $(this).find('span').text('+');
                }
            });
        });

        function filterByCategory() {
            sendForm();
        }

        function filterByTechnic(year) {
            sendForm();
        }

        function filterByMeasure(year) {
            sendForm();
        }

        function filterByArtist(year) {
            sendForm();
        }

        function darFormatoPrecio(precio) {
            return '$' + parseFloat(precio).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
        function darFormatoPrecioUS(precio) {
            return '$' + parseFloat(precio).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
        let timeoutId;
        priceRange.addEventListener('input', () => {

            priceValue.textContent = darFormatoPrecio(priceRange.value);
            if (timeoutId) {
                clearTimeout(timeoutId);
            }

            timeoutId = setTimeout(() => {
                sendForm();
            }, 500);
        });
        let timeoutId_;
        priceRangeUS.addEventListener('input', () => {

            priceValueUS.textContent = darFormatoPrecioUS(priceRangeUS.value);
            if (timeoutId_) {
                clearTimeout(timeoutId_);
            }
            timeoutId_ = setTimeout(() => {
                sendForm();

            }, 500);
        });

        if (screen.width < 800) {
            $('#main_').removeClass("row");
        }

        function sendForm(){
            const formulario = document.getElementById('filterForm');
            const formData = new FormData(formulario);
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
                    updateArticles(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error al enviar el formulario:', error);
                }
            });
        }

        function updateArticles(articles) {
            var $container = $('#articles-list');
            $container.empty(); // Limpiar el contenedor antes de agregar nuevos artículos

            articles.forEach(function(article) {
                // Construir el HTML para cada artículo
                var articleHtml = `
                    <div class="col-lg-4 col-md-6 col-6 content-articles mt-2"

                        alt="${article.name}"
                        data-year="${article.year}"
                        data-category="${article.category_id}"
                        data-technic="${article.subcategory_id}"
                        data-pricemin="${article.price_min}"
                        data-pricemax="${article.price_max}"
                        data-priceminus="${article.price_min_us}"
                        data-pricemaxus="${article.price_max_us}"
                        data-width="${article.width}"
                        data-height="${article.height}"
                        data-artist="${article.artist_id}"
                        data-show="0" style="min-height: 250px;    ">
                        <a href="/seccion/obras/${article.id}" target="_blank">
                            <div class="d-flex justify-content-start align-items-end w-100" style="height: 60%;">
                                <div class="image-container" alt="${article.name})">
                                    <img src="/multimedia/${article.file_path}/${article.slug}/${article.file}" alt="${article.name}">
                                </div>
                            </div>
                            <div style="height: 40%;">
                                <p class="m-0 text-start" style="font-size: calc(0.5rem + 0.4vw); font-weight: 700;">${article.artist_name}</p>
                                <p class="m-0 text-start" style="font-size: calc(0.5rem + 0.4vw); ">${article.name}</p>
                                <p class="m-0 text-start" style="font-size: calc(0.5rem + 0.4vw);">${article.subcategory_name}</p>
                                <p class="m-0 text-start" style="font-size: 13px;">${article.year}</p>
                                <p class="m-0 text-start" style="font-size: 13px;">${article.width} x ${article.height} cm</p>
                                <p class="m-0 text-start" style="font-size: 13px;">$`+ parseFloat(article.price_max).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')+`</p>
                            </div>
                        </a>
                    </div>
                `;

                $container.append(articleHtml);
            });
        }
        function cerrar() {
            $('#filter').addClass('d-none');
        }
        function abrir() {
            $('#filter').removeClass('d-none');
            $('#filter').addClass('d-show');
        }
    </script>
@endsection
