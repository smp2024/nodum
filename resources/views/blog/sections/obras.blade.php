@extends('master')
{{-- seccion de artista perfil y obras --}}
@section('title', $section)
@section('css')
<style>
    .highlight {
    display: none;
    }
    .image-container {
        height: 60%;
        overflow: hidden;
    }

    /* .zoom  {
        transition: all .5s ease-in-out;
        transform-origin: center center;
    } */

    .image-container:hover {
        /* transform: scale(1.5); (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */

        border-radius: 1px solid #000;
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
                <div class="content ">
                    <h4 class="toggle-list-categoria" data-filter="cat"> Categorías <span class="arrow"><i class="far fa-chevron-down"></i></span></h4>
                    <ul class="cat medidas" >

                        <!-- Lista de categorías -->

                        @foreach($categories as $category)

                            <li>
                                <input onchange="handleCheckboxChangeCategory(this, {{ $category->id }})" type="checkbox" name="categoria_checkbox[]" value="{{ $category->id }}" id="category_{{ $category->id }}"  >

                                <a href="#" onclick="filterByCategory('{{ $category->id }}')">{{ $category->name }}</a>
                            </li>

                        @endforeach

                    </ul>
                    <hr>
                </div>

                <div class="content">
                    <h4 class="toggle-list-artista" data-filter="artist"> Artistas <span class="arrow"><i class="far fa-chevron-down"></i></span></h4>
                    <ul class="artist medidas" >

                        @php
                            $artists = ['Todos']; // Add 'Todos' option to the array
                            foreach ($articles as $article) {
                                $artists[] = $article->artist_id;
                            }
                            $artists = array_unique($artists);
                            sort($artists);
                            // $artists = array_reverse($artists);
                        @endphp
                        @foreach ($artists as $artist)
                            @foreach ($artistas as $artista)
                                @if ($artista->id == $artist)
                                    <li>
                                        <input onchange="handleCheckboxChangeArtist(this, {{ $artista->id }})" type="checkbox" name="artista_checkbox[]" value="{{ $artista->id }}" id="artista_{{ $tecnica->id }}"  >
                                        <a href="#" onclick="filterByArtist('{{ $artista->id }}')">{{ $artista->name }} {{ $artista->lastname }} </a>
                                    </li>
                                @endif
                            @endforeach
                        @endforeach
                    </ul>
                    <hr>
                </div>

                <div class="content">
                    <h4 class="toggle-list-tecnica" data-filter="tec"> Técnicas <span class="arrow"><i class="far fa-chevron-down"></i></span></h4>
                    <ul class="tec medidas" >

                        @php
                        $technics = ['Todos']; // Add 'Todos' option to the array
                            foreach ($articles as $article) {
                                $technics[] = $article->subcategory_id;
                            }
                            $technics = array_unique($technics);
                            sort($technics);
                            // $technics = array_reverse($technics);
                        @endphp
                        @foreach ($technics as $technic)
                            @foreach ($tecnicas as $tecnica)
                                @if ($tecnica->id == $technic)
                                <li>
                                    <input onchange="handleCheckboxChangeTecnic(this, {{ $tecnica->id }})" type="checkbox" name="tecnica_checkbox[]" value="{{ $tecnica->id }}" id="tecnica_{{ $tecnica->id }}"  >
                                    <a href="#" onclick="filterByTechnic('{{ $tecnica->id }}')">{{ $tecnica->name }}</a>
                                </li>
                                @endif
                            @endforeach
                        @endforeach
                    </ul>
                    <hr>
                </div>

                <div class="content">
                    <h4>Precio</h4>
                    <!-- Rango de precios -->

                    <p id="minPrice" class="m-0">Desde ${{ number_format($articles->min('price_min'), 2, '.', ',') }}</p>
                    <div style="display: inline-flex">
                        <input type="range" min="{{ $articles->min('price_min') }}" max="{{ $articles->max('price_max') }}" value="{{ $articles->min('price_min') }}" id="priceRange">
                        <p id="priceValue" style="width: 33%;" class="m-0 ml-2"> ${{ $articles->min('price_min') }}</p>
                    </div>

                    <p id="maxPrice" class="m-0">Hasta ${{ number_format($articles->max('price_max'), 2, '.', ',') }}</p>
                    <hr>
                </div>

                <div class="content">
                    <h4>Medidas</h4>
                    <!-- Rango de medidas -->
                    <ul>
                        <li><a href="#" onclick="highlightSize('pequeño')">Pequeño (menor a 40cm)</a></li>
                        <li><a href="#" onclick="highlightSize('mediano')">Mediano </a></li>
                        <li><a href="#" onclick="highlightSize('grande')">Grande(mayor a 100cm)</a></li>
                    </ul>
                </div>



                <!-- Rango de años -->
                {{-- <h4>Año</h4>
                <ul>
                    @php
                        $years = ['Todos']; // Add 'Todos' option to the array
                        foreach ($articles as $article) {
                            $years[] = $article->year;
                        }
                        $years = array_unique($years);
                        sort($years);
                        $years = array_reverse($years);
                    @endphp
                    @foreach ($years as $year)
                        <li><a href="#" onclick="filterByYear('{{ $year }}')">{{ $year }}</a></li>
                    @endforeach
                </ul> --}}
            </div>

        </div>
        <!-- info Artsta -->
        <div id="content-articles" class="col-lg-9 col-sm-7 col-7 h-100 w-100 d-flex justify-content-center align-items-center p-0" >
            <div class="row w-100 h-100">
               <!-- Listado de artículos -->
                    @foreach($articles as $article)

                        <div class="col-lg-4 col-md-6 col-sm-12 content-articles mt-4" style="height: auto; max-heigth: 400px;" data-year="{{ $article->year }}" data-category="{{ $article->category_id }}" data-technic="{{ $article->subcategory_id }}" data-pricemin="{{ $article->price_min }}" data-pricemax="{{ $article->price_max }}" data-width="{{ $article->width }}"  data-height="{{ $article->height }}" data-artist="{{ $article->artist_id }}" data-show="0" >

                            <a href="{{ url('seccion/obras/'.$article->id) }}">
                                <div class="card justify-content-center" style=" border: none;">

                                    <div class="image-container">
                                        <img src="{{ url('multimedia'.$article->file_path.'/'.$article->slug. '/'.$article->file) }}" alt="{{ $article->name }}" class="img-fluid zoom" >
                                    </div>

                                </div>
                                <div style="height: 40%;">
                                    <p class="m-0 text-center">{{ $article->name }}</p>
                                    @foreach ($tecnicas as $tecnica)
                                        @if ($tecnica->id == $article->subcategory_id)
                                            <p class="m-0 text-center">{{ $tecnica->name }}</p>
                                        @endif
                                    @endforeach
                                    @foreach ($artistas as $artista)
                                        @if ($artista->id == $article->artist_id)
                                            <p class="m-0 text-center">{{ $artista->name }} {{ $artista->lastname }}</p>
                                        @endif
                                    @endforeach

                                    <!-- <p class="m-0 text-center">{{ $article->price_min }} - {{ $article->price_max }}</p> -->
                                    <p class="m-0 text-center">{{ $article->year }}</p>
                                    <p class="m-0 text-center">{{ $article->width }} x {{ $article->height }} cm</p>

                                </div>
                            </a>

                        </div>
                    @endforeach
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
        const contentArticles = document.getElementById('content-articles');

        $(document).ready(function(){
            // $('.image-container').mousemove(function(e){
            //     var x = e.pageX - $(this).offset().left;
            //     var y = e.pageY - $(this).offset().top;
            //     $(this).children('img').css({'transform-origin': x + 'px ' + y + 'px'});
            //     $(this).children('img').css({'transform': 'scale(2)'});
            // });
            // $('.image-container').mouseleave(function(e){
            //     $(this).children('img').css({'transform': 'scale(1)'});
            // });



            var base = location.protocol + '//' + location.host;
            var route = document.title;

            console.log(route);

            // document.addEventListener('DOMContentLoaded', function() {
            //     var title = route;
            //     console.log(title);
            //     $('#'+title+'_nav').addClass('active');
            //     $('#main_').addClass('h-100');

            // });
            $('.toggle-list-categoria').click(function() {
                var filter = $(this).data('filter'); // Obtiene el valor de data-filter
                var $ul = $('ul.' + filter); // Busca el elemento ul con la clase correspondiente
                // $ul.toggleClass('medidas'); // Alterna la clase d-none del elemento ul}
                var $arrow = $(this).find('.arrow');
                if ($ul.hasClass('medidas')) {
                    $ul.removeClass('medidas');
                    $arrow.addClass('rotate');
                } else {
                    $ul.addClass('medidas');
                    $arrow.removeClass('rotate');
                }
                console.log(filter);
            });
            $('.toggle-list-artista').click(function() {
                var filter = $(this).data('filter'); // Obtiene el valor de data-filter
                var $ul = $('ul.' + filter); // Busca el elemento ul con la clase correspondiente
                // $ul.toggleClass('medidas'); // Alterna la clase d-none del elemento ul}
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
                var filter = $(this).data('filter'); // Obtiene el valor de data-filter
                var $ul = $('ul.' + filter); // Busca el elemento ul con la clase correspondiente
                // $ul.toggleClass('medidas'); // Alterna la clase d-none del elemento ul}
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

            console.log(selectedPrice);
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

        function darFormatoPrecio(precio) {
            // Convertir el precio a número y aplicar formato
            return '$' + parseFloat(precio).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }

        priceRange.addEventListener('input', () => {

            priceValue.textContent = darFormatoPrecio(priceRange.value);
            showall();
            filterArticlesByPrice();
        });

        function highlightSize(size) {
            showall();
            const articles = document.querySelectorAll('#content-articles .content-articles');
            console.log(articles);

            articles.forEach(article => {
                const width = parseInt(article.getAttribute('data-width'));
                const height = parseInt(article.getAttribute('data-height'));

                if (size === 'pequeño' && (width < 40 || height < 40)) {
                    article.classList.add('highlight');

                } else if (size === 'mediano' && (width < 40 && width > 100) && (height < 40 && height > 100)) {
                    article.classList.add('highlight');
                } else if (size === 'grande' && (width > 100 || height > 100)) {
                    article.classList.add('highlight');
                } else {
                    article.classList.remove('highlight');
                }
            });
        }
        if (screen.width < 800) {
            console.log('oo');
            $('#main_').removeClass("row");
        }

        function showall(){
            console.log('MuestraTodo');
            $('#content-articles .content-articles[data-show=0]').show();

        }

        function handleCheckboxChangeTecnic(checkbox, year) {
            if (checkbox.checked) {
                // Checkbox marcado, mostrar solo los elementos asociados al año
                $('#content-articles .content-articles').hide();
                $('#content-articles .content-articles[data-technic="' + year + '"]').show();
                var anyChecked = $('input[name="tecnica_checkbox[]"]:checked').length > 0;
                if (anyChecked) {
                    // Mostrar solo los elementos asociados a los checkboxes marcados
                    var checkedValues = $('input[name="tecnica_checkbox[]"]:checked').map(function(){
                        return this.value;
                    }).get();
                    $('#content-articles .content-articles').hide();
                    checkedValues.forEach(function(value) {
                        $('#content-articles .content-articles[data-technic="' + value + '"]').show();
                    });
                } else {
                    // Si no hay otros checkboxes marcados, mostrar todos los elementos
                    $('#content-articles .content-articles').show();
                }
            } else {
                // Checkbox desmarcado
                // Verificar si hay otros checkboxes marcados
                var anyChecked = $('input[name="tecnica_checkbox[]"]:checked').length > 0;
                if (!anyChecked) {
                    // Si no hay otros checkboxes marcados, mostrar todos los elementos
                    $('#content-articles .content-articles').show();
                } else {
                    // Si hay otros checkboxes marcados, mantener solo los elementos asociados a los checkboxes marcados
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
                // Checkbox marcado, mostrar solo los elementos asociados al año
                $('#content-articles .content-articles').hide();
                $('#content-articles .content-articles[data-artist="' + year + '"]').show();
                var anyChecked = $('input[name="artista_checkbox[]"]:checked').length > 0;
                if (anyChecked) {
                    // Mostrar solo los elementos asociados a los checkboxes marcados
                    var checkedValues = $('input[name="artista_checkbox[]"]:checked').map(function(){
                        return this.value;
                    }).get();
                    $('#content-articles .content-articles').hide();
                    checkedValues.forEach(function(value) {
                        $('#content-articles .content-articles[data-artist="' + value + '"]').show();
                    });
                } else {
                    // Si no hay otros checkboxes marcados, mostrar todos los elementos
                    $('#content-articles .content-articles').show();
                }
            } else {
                // Checkbox desmarcado
                // Verificar si hay otros checkboxes marcados
                var anyChecked = $('input[name="artista_checkbox[]"]:checked').length > 0;
                if (!anyChecked) {
                    // Si no hay otros checkboxes marcados, mostrar todos los elementos
                    $('#content-articles .content-articles').show();
                } else {
                    // Si hay otros checkboxes marcados, mantener solo los elementos asociados a los checkboxes marcados
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
                // Checkbox marcado, mostrar solo los elementos asociados al año
                $('#content-articles .content-articles').hide();
                $('#content-articles .content-articles[data-category="' + year + '"]').show();
                var anyChecked = $('input[name="categoria_checkbox[]"]:checked').length > 0;
                if (anyChecked) {
                    // Mostrar solo los elementos asociados a los checkboxes marcados
                    var checkedValues = $('input[name="categoria_checkbox[]"]:checked').map(function(){
                        return this.value;
                    }).get();
                    $('#content-articles .content-articles').hide();
                    checkedValues.forEach(function(value) {
                        $('#content-articles .content-articles[data-category="' + value + '"]').show();
                    });
                } else {
                    // Si no hay otros checkboxes marcados, mostrar todos los elementos
                    $('#content-articles .content-articles').show();
                }
            } else {
                // Checkbox desmarcado
                // Verificar si hay otros checkboxes marcados
                var anyChecked = $('input[name="categoria_checkbox[]"]:checked').length > 0;
                if (!anyChecked) {
                    // Si no hay otros checkboxes marcados, mostrar todos los elementos
                    $('#content-articles .content-articles').show();
                } else {
                    // Si hay otros checkboxes marcados, mantener solo los elementos asociados a los checkboxes marcados
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

    {{-- <script src="{{ asset('js/filter.js') }}"></script> --}}
@endsection
