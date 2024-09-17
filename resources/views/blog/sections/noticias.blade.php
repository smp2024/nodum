@extends('master')
@section('title', $section)
@section('css')
<style>
    .cont-not{
        background-position: center;
        background-repeat: no-repeat;
        background-size: 100%;
        background-position-y: 25%;
    }
    @media (max-width: 767px) {
        .info-news {
            position: relative;
        }

        .noti {
            height: auto !important;
        }
    }
</style>
@endsection
@section('content')
    <div id="main_" class="row w-100 d-flex justify-content-center align-items-center m-0 h-100" style="padding: 0 10%;">
        @if ($countArt == 0)
            <h1 style="color: #fff;">Sin noticias por el momento.</h1>
        @else

            @foreach ($newsB as $big)

            <a  href="{{  url('seccion/'.$big->module.'/'.$big->slug)}}"   class="w-100">
                <div class="col-12 cont-not p-0 noti" style="height: 300px; background-image: url(../multimedia/{{$big->file_path}}/{{$big->slug}}/{{$big->file}});">

                    <div class="info-news">
                        <div class="h-20 title_ Bold">
                            <p style=" font-size: 2.5rem;">{{ html_entity_decode($big->name, ENT_QUOTES | ENT_XML1, 'UTF-8') }}</p>
                        </div>
                        <div class="h-20 date_ Bold">
                            <p>{{ $big->date }}</p>
                        </div>
                    </div>
                </div>

            </a>
            @endforeach

        @endif
    </div>
@endsection

@section('scripts')
    <script>


        $(document).ready(function() {
            $('.date_ p').each(function() {
                var fechaOriginal = $(this).text();

                var fechaObjeto = new Date(fechaOriginal + 'T00:00:00');

                var dia = fechaObjeto.getDate();
                var mes = fechaObjeto.toLocaleString('default', { month: 'long' });
                var año = fechaObjeto.getFullYear();

                var nuevaFecha = dia + ' de ' + mes + ' de ' + año;

                $(this).text(nuevaFecha);
            });
        });
    </script>

@endsection
