@extends('master')
@section('title', $section)
{{-- seccion de menu artistas --}}
@section('content')
    <div id="main_" class="row w-100 d-flex justify-content-center align-items-center m-0 h-100" style="padding-top: 0px;">
        <div class="d-flex flex-row flex-nowrap overflow-auto" style="width: 95%;">
            @if ($countArt == 0)
                <h1 style="color: #fff;">Sin artistas por el momento.</h1>
            @else
                @php
                    $columnCount = 0;
                @endphp
                @foreach ($articles as $article)
                    @if ($columnCount % 10 == 0)
                        <div class="d-flex flex-column">
                    @endif
                    <a href="{{ url('seccion/artistas/'.$article->id) }}">
                        <div class="cont-card-event">
                            <p class="m-0 text-center title_article " style="color: #000 !important;">{{ html_entity_decode($article->name, ENT_QUOTES | ENT_XML1, 'UTF-8') }} {{ html_entity_decode($article->lastname, ENT_QUOTES | ENT_XML1, 'UTF-8') }}</p>
                        </div>
                    </a>
                    @php
                        $columnCount++;
                    @endphp
                    @if ($columnCount % 10 == 0 || $loop->last)
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.filter-link').click(function(e) {
                e.preventDefault();
                var filter = $(this).data('filter');
                $('.filter-link').removeClass('font-weight-bold');
                $(this).addClass('font-weight-bold');
                if (filter === 'all') {
                    $('.cont-card-event').show();
                } else {
                    $('.cont-card-event').hide();
                    $('.cont-card-event').each(function() {
                        var firstLetter = $(this).find('.title_article').text().charAt(0).toUpperCase();
                        if (firstLetter === filter) {
                            $(this).show();
                        }
                    });
                }
            });
        });
    </script>
@endsection

@section('scripts')
    <script>
        if (screen.width < 800) {
            console.log('oo');
            $('#main_').removeClass("row");
        }
    </script>
@endsection

