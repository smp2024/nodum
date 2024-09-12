@extends('master')
@section('title', $section)
@section('content')
    <div id="main_" class="row w-100 d-flex justify-content-center align-items-center m-0 h-100" style="padding-top: 0px;">

            @if ($countArt == 0)
                <h1 style="color: #fff;">Sin proyectos por el momento.</h1>
            @else
                @foreach ($articles as $article)

                    <div class="col-3 mr-2 justify-content-center align-items-center p-0">
                        {{-- <a target="_blank" href="{{ url('/uploads/'.$f->file) }}" class="Link_Not">Descargar  </a> --}}
                            <a href="#"   class="Link_Not">
                                <div class="h-100 d-flex justify-content-center align-items-center">

                                    <img style="position: relative !important;"  src="{{ url('/multimedia'.$article->file_path.'/'.$article->slug.'/t_'.$article->file) }}" class="d-block imagen_noticia" alt="{{$article->slug}}">
                                    {{-- <div class="info-news">
                                        <div class="h-20 title_ Bold">
                                            <p style=" font-size:calc(1rem + 0.8vw); text-align: left;">{{ html_entity_decode($article->name, ENT_QUOTES | ENT_XML1, 'UTF-8') }}</p>
                                        </div>
                                    </div> --}}

                                </div>
                            </a>

                    </div>

                @endforeach
            @endif

    </div>
@endsection

@section('scripts')
    <script>

        if (screen.width < 800) {
        console.log('oo');
        $('#main_').removeClass("row");
        }
    </script>
@endsection
