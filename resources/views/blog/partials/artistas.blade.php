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
        <button type="button" class="btn btn-outline-dark view-works mb-5" data-artist-id="{{ $post->id }}">Ver obras</button>
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

        $('.view-works').click(function() {
        var artistId = $(this).data('artist-id');
        window.location.href = '/seccion/obras?artist_id=' + artistId;
    });
    });

</script>
<script src="{{ asset('js/filter.js') }}"></script>
@endsection
