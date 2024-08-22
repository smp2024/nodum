@extends('master')
@section('title', $section)
@section('content')
    <div id="main_" class="row w-100 d-flex justify-content-center align-items-center m-0 h-100" style="padding-top: 0px;">
        @if ($countArt == 0)
            <h1 style="color: #fff;">Sin noticias por el momento.</h1>
        @else
        <!--Buscador de noticias-->
        <div class="form_search mt-3 w-100" id="form_search" style="width: 100%; padding: 0 5% 0 4%;">

            {{-- <ul>
                {!! Form::open(['url' => '/news/search']) !!}
                    <div class="row justify-content-center">
                        <div class="col-7 col-md-6 p-0 pl-1">
                            {!! Form::text('search', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre de la noticia']) !!}
                        </div>

                        <div class="col-4 col-md-2">
                            {!! Form::submit('Buscar', ['class' => 'btn btn-primary btn-news']) !!}
                        </div>
                    </div>



                {!! Form::close() !!}
            </ul> --}}

        </div>
        <div class="col-12" id="web-news">
            <div class="row w-100 justify-content-center align-items-center " style=" z-index: 90; background: white; text-align: justify; padding: 0% 0 2% 3%; height: 70vh;" >
                <!--Noticia-Grande-->
                <div class="col-lg-7 justify-content-center align-items-center h-100" style="  padding: 0%; z-index: 98; margin-top: 0px;">

                        @foreach ($newsB as $big)

                            <div class="h-100" style="width: 100%;">
                                <a  href="{{  url('seccion/'.$big->module.'/'.$big->slug)}}"   class="Link_Not">
                                     <div class="h-100 d-flex justify-content-center align-items-center">

                                        <img src="{{ url('/multimedia'.$big->file_path.'/'.$big->slug.'/'.$big->file) }}" class="d-block  imagen_noticia h-100" alt="...">
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
                            </div>

                        @endforeach

                </div>

                <!--Noticias-medianas-->
                <div class="col-lg-4 justify-content-center align-items-center h-100" style="padding-left: 2.5%; z-index: 98; margin-top: 0px;     overflow: hidden;">


                        <div class="  h-50" style="padding:0 0% 0% 0%; z-index: 98;">

                            @foreach ($mediana1 as $medi1)
                                <div class="h-100" style="width: 100%;">
                                    <a  href="{{  url('seccion/'.$medi1->module.'/'.$medi1->slug)}}"   class="Link_Not" >
                                        <div class="h-100 d-flex justify-content-center" style=" position: relative;">

                                            <img  src="{{ url('/multimedia/'.$medi1->file_path.'/'.$medi1->slug.'/t_'.$medi1->file) }}" class="d-block  imagen_noticia h-100" alt="...">
                                            <div class="info-news">
                                                <div class="h-20 title_ Bold">
                                                    <p style=" font-family: 'Montserrat-Bold'; font-size: 1.5rem;">{{ html_entity_decode($medi1->name, ENT_QUOTES | ENT_XML1, 'UTF-8') }}</p>
                                                </div>
                                                <div class="h-20 date_ Bold">
                                                    <p>{{ $medi1->date }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                            @endforeach

                        </div>

                        <div class="  h-50" style="padding: 1% 0% 0 0; z-index: 98;">

                            @foreach ($mediana2 as $medi2)
                                <div class="h-100" style="width: 100%;">
                                    <a href="{{  url('seccion/'.$medi2->module.'/'.$medi2->slug)}}"   class="Link_Not">
                                        <div class="h-100  d-flex justify-content-center" style=" position: relative;">

                                            <img src="{{ url('/multimedia'.$medi2->file_path.'/'.$medi2->slug.'/t_'.$medi2->file) }}" class="d-block imagen_noticia h-100" alt="...">
                                            <div class="info-news">
                                                <div class="h-20 title_ Bold">
                                                    <p style=" font-family: 'Montserrat-Bold'; font-size: 1.5rem;">{{ html_entity_decode($medi2->name, ENT_QUOTES | ENT_XML1, 'UTF-8') }}</p>
                                                </div>
                                                <div class="h-20 date_ Bold">
                                                    <p>{{ $medi2->date }}</p>
                                                </div>
                                            </div>

                                        </div>
                                    </a>
                                </div>
                            @endforeach

                        </div>

                </div>

            </div>
            <section class="w-100">

                <div class="row justify-content-center align-items-center w-100" style="height: 3%">
                    <div class="col-lg-12 justify-content-center align-items-center h-100" style="padding: 1% 7%; text-align: center; font-family:'Courier New', Courier, monospace;    padding-top: 0 !important;">
                        __________________________________________________________________________________________________
                    </div>
                </div>
            </section>
            <div class="row w-100 justify-content-center align-items-center">
                @foreach ($news as $small)

                    <div class="col-3 mr-2 justify-content-center align-items-center p-0 news-small" style="height: 220px; margin-bottom: 3%;">

                        <div class="h-100" style="width: 100%;">
                            <a href="{{  url('seccion/'.$small->module.'/'.$small->slug)}}"   class="Link_Not">
                                 <div class="h-100 d-flex justify-content-center align-items-center">

                                    <img style="position: relative !important;"  src="{{ url('/multimedia/'.$small->file_path.'/'.$small->slug.'/t_'.$small->file) }}" class="d-block  imagen_noticia" alt="...">
                                    <div class="info-news">
                                        <div class="h-20 title_ Bold">
                                            <p style=" font-family: 'Montserrat-Bold'; font-size:calc(0.5rem + 0.4vw); text-align: left;">{{ html_entity_decode($small->name, ENT_QUOTES | ENT_XML1, 'UTF-8') }}</p>
                                        </div>
                                        <div class="h-20 date_ Bold">
                                            <p format="long">{{ $small->date }}</p>
                                        </div>
                                    </div>

                                </div>
                            </a>
                        </div>

                    </div>

                @endforeach
            </div>

        </div>


        <div id="news_mobile"  class=" w-100 justify-content-center align-items-center h-100" style="    padding-top: 20%; padding: 0 5px;">

            @foreach ($newsmbolie as $small_0)

                <div class="col-12  justify-content-center align-items-center p-0 img-cont-news" style="height: 300px; margin-bottom: 3%;">

                    <div class="h-100" style="width: 100%;">
                        <a href="" class="Link_Not">
                             <div class="h-100 d-flex justify-content-center align-items-center">

                                <img style="position: relative !important;"  src="{{ url('/multimedia/'.$small_0->file_path.'/'.$small_0->slug.'/t_'.$small_0->file) }}" class="d-block  imagen_noticia" alt="...">
                                <div class="info-news">
                                    <div class="h-20 title_ Bold">
                                        <p style=" font-family: 'Montserrat-Bold'; font-size:calc(0.5rem + 0.4vw); text-align: left;">{{ html_entity_decode($small_0->name, ENT_QUOTES | ENT_XML1, 'UTF-8') }}</p>
                                    </div>
                                    <div class="h-20 date_ Bold">
                                        <p format="long">{{ $small_0->date }}</p>
                                    </div>
                                </div>

                            </div>
                        </a>
                    </div>

                </div>

            @endforeach

        </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>


        $(document).ready(function() {
            $('.date_ p').each(function() {
                var fechaOriginal = $(this).text();

                var fechaObjeto = new Date(fechaOriginal);

                var dia = fechaObjeto.getDate();
                var mes = fechaObjeto.toLocaleString('default', { month: 'long' });
                var año = fechaObjeto.getFullYear();

                var nuevaFecha = dia + ' de ' + mes + ' de ' + año;

                $(this).text(nuevaFecha);
            });
        });
    </script>

@endsection
