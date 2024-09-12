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
        min-width: 100%;
    }
    .image-container img{
        height: 100%;
    }
    /* .zoom  {
        transition: all .5s ease-in-out;
        transform-origin: center center;
    } */


    /* .zoom:hover {
        transform: scale(1.5);
    } */
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
    .back_ {
        margin-right: 15px;
        display: flex;
        justify-content: end;
        height: 100%;
        min-height: 400px;
        border-right: 1px dotted #000;
    }
</style>
@endsection
@section('content')
    <!-- info Artsta -->
    <div class=" justify-content-center align-items-end pl-1 w-100 cont-artist">
        <div class="col-1 back_">
            <i id="back-button" class="fal fa-chevron-left"></i>
        </div>
        <div id="img-asesor" class="col-lg-3 col-md-12 col-12 d-flex justify-content-end align-items-center p-0 w-100" >
            <div class="content-artist-img grayscale "  >
                <img class="w-100 h-100 grayscale" src="{{ url('multimedia'.$post->file_path.'/'.$post->file) }}" alt="{{ $article->name }}" class="" style="filter: grayscale(100%);" >
            </div>
        </div>
        <div class="col-lg-7  col-md-12 col-12  text-justify" >
            <div class=" h-100 w-100  info-artist">
                <p class="w-100 artist-name">{!!  html_entity_decode($post->name, ENT_QUOTES | ENT_XML1, 'UTF-8')  !!} {!!  html_entity_decode($post->lastname, ENT_QUOTES | ENT_XML1, 'UTF-8')  !!}</p>
                <p class="w-100 artist-year">{{substr($post->birthday, 0, 4)}} - {!!  html_entity_decode($post->country, ENT_QUOTES | ENT_XML1, 'UTF-8')  !!} </p>
                {!!  html_entity_decode($post->description_large, ENT_QUOTES | ENT_XML1, 'UTF-8')  !!}
            </div>
        </div>

        {{-- <button type="button" class="btn btn-outline-dark view-works mb-5" data-artist-id="{{ $post->id }}">Ver obras</button> --}}
    </div>

    <!-- filtro  -->
    <div class="row justify-content-center align-items-center h-100 w-100" >
        <!-- Sección de filtrado -->
        <div class="col-lg-3 col-sm-5 col-5 d-flex justify-content-center align-items-center p-0  w-100">
            <div class="filtro">
                <h4>Categorías</h4>
                <ul>
                    <!-- Lista de categorías -->
                    @foreach($categories as $category)
                        <li><a href="#" onclick="filterByCategory('{{ $category->id }}')">{{ $category->name }}</a></li>
                    @endforeach

                </ul>

                <h4>Técnicas</h4>
                <ul>
                    @php
                        $technics = ['Todos'];
                        foreach ($articles as $article) {
                            $technics[] = $article->subcategory_id;
                        }
                        $technics = array_unique($technics);
                        sort($technics);
                        $technics = array_reverse($technics);
                    @endphp
                    @foreach ($technics as $technic)
                        <li><a href="#" onclick="filterByTechnic('{{ $technic }}')">{{ $technic }}</a></li>
                    @endforeach
                </ul>

                <h4>Precio</h4>
                <!-- Rango de precios -->
                <input type="range" min="{{ $articles->min('price_min') }}" max="{{ $articles->max('price_max') }}" value="{{ $articles->min('price_min') }}" id="priceRange">
                <div style="display: inline-flex">
                <p id="minPrice" style="width: 33%;">{{ $articles->min('price_min') }}</p>
                <p id="priceValue" style="width: 33%;">{{ $articles->min('price_min') }}</p>
                <p id="maxPrice" style="width: 33%;">{{ $articles->max('price_max') }}</p>
                </div>

                <h4>Medidas</h4>
                <!-- Rango de medidas -->
                <ul>
                    <li><a href="#" onclick="highlightSize('pequeño')">Pequeño</a></li>
                    <li><a href="#" onclick="highlightSize('mediano')">Mediano</a></li>
                    <li><a href="#" onclick="highlightSize('grande')">Grande</a></li>
                </ul>

                <!-- Rango de años -->
                <h4>Año</h4>
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
                </ul>
            </div>
        </div>
        <!-- Listado de artículos -->
        <div id="content-articles" class="col-lg-9 col-sm-7 col-7 h-100 w-100 d-flex justify-content-center align-items-center p-0" >
            <div class="row w-100 h-100">
                    @foreach($articles as $article)
                        <div class="col-4" data-year="{{ $article->year }}" data-category="{{ $article->category_id }}" data-technic="{{ $article->subcategory_id }}" data-pricemin="{{ $article->price_min }}" data-pricemax="{{ $article->price_max }}" data-width="{{ $article->width }}"  data-height="{{ $article->height }}" >
                            <div class="card" style="height: 60%;">
                                <img src="{{ url('multimedia'.$article->file_path.'/'.$article->slug. '/'.$article->file) }}" alt="{{ $article->name }}" class="" >

                            </div>
                            <div style="height: 40%;">
                                <p>{{ $article->name }}</p>
                                <p>{{ $article->subcategory_id }}</p>
                                <p>{{ $article->price_min }} - {{ $article->price_max }}</p>
                                <p>{{ $article->year }}</p>
                                <p>{{ $article->width }} x {{ $article->height }} cm</p>

                            </div>
                        </div>
                    @endforeach
            </div>
        </div>
    </div>
    @include('blog.partials.footer')
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

        $('.view-works').click(function() {
        var artistId = $(this).data('artist-id');
        window.location.href = '/seccion/obras?artist_id=' + artistId;
    });
    });
    document.addEventListener('DOMContentLoaded', (event) => {
        const backButton = document.getElementById('back-button');

        backButton.addEventListener('click', () => {
            if (window.history.length > 1) {
                window.history.back();
            } else {
                window.location.href = '/';
            }
        });
    });
</script>
<script src="{{ asset('js/filter.js') }}"></script>
@endsection
