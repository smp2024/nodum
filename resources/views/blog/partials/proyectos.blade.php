@extends('master')

@section('title',  $vpn->name )

@section('content')

    <div id="Article"  class="col-12">
        <div class="row " >

            <!-- TITULO NOTICIA -->
                <div class="col-12 justify-content-center align-items-center Height5_2" >

                    <h1 class="m-3" style="text-align: center;">{!!  html_entity_decode($vpn->name, ENT_QUOTES | ENT_XML1, 'UTF-8')  !!}</h1>

                </div>

            <!-- iMAGEN DESTACADA -->
                <div  class="col-12 justify-content-center align-items-center Height70 img-portada" style="padding: 0 20%; margin-bottom: 40px;background-image: url({{ url('/multimedia/'.$vpn->file_path.'/'.$vpn->slug.'/'.$vpn->file) }});" >

                </div>

            <!-- Secccion-->
                @for ($i=1 ; $i<=$vpn->sections; $i++)
                    <!-- DESCRIPCION -->
                        <div  class="col-12 justify-content-center align-items-center text-justify " style="margin-bottom: 25px;  height: auto;  padding: 5px 10%; ">

                            @foreach ($descriptions as $description)
                                @if ($description->section == $i-1)
                                    {!! html_entity_decode($description->content, ENT_QUOTES | ENT_XML1, 'UTF-8') !!}
                                @endif
                            @endforeach

                        </div>
                    <!-- IMAGENES   -->

                        <div  class="col-12 d-flex justify-content-center align-items-center " style="padding: 0; margin-bottom: 25px;  height: auto;">
                            <div id="carouselExampleControls_{{ $i }}" class="carousel slide h-100 w-100" data-ride="carousel">
                                <div class="carousel-inner h-100">
                                    @foreach ($imagenes as $imagen)
                                        @if($i == $imagen->after)
                                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                                <img src="{{ url('/multimedia'.$imagen->file_path.'/'.$imagen->file_name) }}" class="d-block w-100" alt="Image {{ $loop->iteration }}">
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleControls_{{ $i }}" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleControls_{{ $i }}" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>

                    <!--VIDEO -->
                    @foreach ($videos as $video)
                        @if ($video->content != null )
                            @if ($video->section == $i-1)
                                <div  class="col-12 justify-content-center align-items-center vimeo" style="padding: 0; height:50%; min-height:300px; margin-bottom: 25px;">
                                    <div class="video-wrap text-center">
                                        <div class="video">
                                            {!! html_entity_decode($video->content, ENT_QUOTES | ENT_XML1, 'UTF-8') !!}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endforeach
                @endfor
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.carousel').carousel({
                interval: 5000 // Change slide every 5 seconds
            });
        });
    </script>
@endsection
        
