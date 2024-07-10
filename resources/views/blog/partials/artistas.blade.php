@extends('master')
@section('title', $section)
@section('css')
<style>
    .highlight {
       display: none;
    }
    .grayscale {
        filter: grayscale(100%);
    }
    .image-container {
        height: 60%;
        overflow: hidden;
    }

    .zoom  {
        transition: all .5s ease-in-out;
        transform-origin: center center;
    }


    .zoom:hover {
        transform: scale(1.5); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
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
    <!-- info Artsta -->
    <div class="row justify-content-center pl-1 w-100" >
        <div id="img-asesor" class="col-lg-5 col-md-12 col-12 d-flex justify-content-center align-items-center p-0 w-100" >
            <div class="content-artist-img grayscale "  >
                <img class="w-100 h-100 grayscale" src="{{ url('multimedia'.$post->file_path.'/'.$post->file) }}" alt="{{ $article->name }}" class="" style="filter: grayscale(100%);" >
            </div>
        </div>
        <div class="col-lg-7  col-md-12 col-12 pt-5" >
            <p class="w-100 artist-name">{!!  html_entity_decode($post->name, ENT_QUOTES | ENT_XML1, 'UTF-8')  !!} {!!  html_entity_decode($post->lastname, ENT_QUOTES | ENT_XML1, 'UTF-8')  !!}</p>
            <p class="w-100 artist-year">{{substr($post->birthday, 0, 4)}} - {!!  html_entity_decode($post->country, ENT_QUOTES | ENT_XML1, 'UTF-8')  !!} </p>
            <p class="w-100 artist-description mt-3" >{!!  html_entity_decode($post->description_large, ENT_QUOTES | ENT_XML1, 'UTF-8')  !!}</p>
        </div>
    </div>

    <!-- filtro  -->
    <div class="row justify-content-center align-items-start h-100 w-100" >
        <!-- Sección de filtrado -->
        <div class="col-lg-3 col-sm-5 col-5 d-flex justify-content-center align-items-center p-0  w-100" style="padding-right: 2% !important; padding-left: 4% !important;">
            <div class="filtro w-100">


            <div class="content">
                <h4 class="toggle-list-categoria" data-filter="cat"> Categorías <span class="arrow"><i class="far fa-chevron-down"></i></span></h4>
                <ul class="cat medidas" >
                    @php
                    $cate = ['Todos']; // Add 'Todos' option to the array
                        foreach ($articles as $article) {
                            $cate[] = $article->category_id;
                        }
                        $cate = array_unique($cate);
                        sort($cate);
                        $cate = array_reverse($cate);
                    @endphp
                    <!-- Lista de categorías -->
                    @foreach ($cate as $tecnica)
                        @foreach($categories as $category)
                            @if ($category->id == $tecnica)
                            <li>
                                <input onchange="handleCheckboxChangeCategory(this, {{ $category->id }})" type="checkbox" name="categoria_checkbox[]" value="{{ $category->id }}" id="category_{{ $category->id }}"  >

                                <a href="#" onclick="filterByCategory('{{ $category->id }}')">{{ $category->name }}</a>
                            </li>
                            @endif
                        @endforeach
                    @endforeach

                </ul>

                <hr>
            </div>

            <div class="content">
                <h4 class="toggle-list-tecnica" data-filter="tec"> Técnicas <span class="arrow"><i class="far fa-chevron-down"></i></span></h4>
                <ul  class="tec medidas" >
                    @php
                        $technics = ['Todos']; // Add 'Todos' option to the array
                        foreach ($articles as $article) {
                            $technics[] = $article->subcategory_id;
                        }
                        $technics = array_unique($technics);
                        sort($technics);
                        $technics = array_reverse($technics);
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
                    <p id="priceValue" style="width: 33%;" class="m-0 ml-2"> ${{ number_format($articles->min('price_min'), 2, '.', ',') }}</p>
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
                <hr>
            </div>


                <!-- Rango de años -->
                {{-- <h4>Año</h4>
                <ul>
                    @php
                        $years = ['Todos'];
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
        <!-- Listado de artículos -->
        <div id="content-articles" class="col-lg-9 col-sm-7 col-7 h-100 w-100 d-flex justify-content-start align-items-start p-0" >
            <div class="row w-100 h-100">
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
    </div>
@endsection

@section('scripts')
<script>

    const priceRange = document.getElementById('priceRange');
    const minPrice = document.getElementById('minPrice');
    const maxPrice = document.getElementById('maxPrice');
    const contentArticles = document.getElementById('content-articles');
    $(document).ready(function(){

        var urlElements = window.location.pathname.split('/').filter(function(element) {
            return element !== '';
        });

        var element1 = urlElements[0];
        var element2 = urlElements[1];
        var navbarElements = document.querySelectorAll('.nav-item a');


        var url = window.location.href;
        var urlParts = url.split('/');
        urlParts.pop();
        const finURL = urlParts.join('/');

        navbarElements.forEach(function(element) {
            const urr = element.attributes[1].nodeValue

            if (urr === finURL) {
                element.classList.add('active');
            }

        });
    });

</script>
<script src="{{ asset('js/filter.js') }}"></script>
@endsection
