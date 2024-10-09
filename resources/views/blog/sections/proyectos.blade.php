@extends('master')
@section('title', $section)
@section('content')
    <div id="main_" class="row w-100 d-flex justify-content-center align-items-center m-0 h-100" style="padding-top: 0px;">

            @if ($countArt == 0)
                <h1 style="color: #fff;">Sin proyectos por el momento.</h1>
            @else
                @foreach ($articles as $article)

                    <div class="col-md-3 col-6 mr-2 justify-content-center align-items-center p-0" style="display: flex;">

                        <a target="_blank" href="{{ url('multimedia/'.$article->file_path.'/'.$article->pdf) }}" class="Link_Not" style=" height: 500px; width: 300px;">
                            <h5>{{$article->name}}</h5>
                            <img style="position: relative !important;"  src="{{ url('multimedia/'.$article->file_path.'/'.$article->file) }}" class="d-block imagen_noticia w-100 mt-2" alt="{{$article->slug}}">
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
