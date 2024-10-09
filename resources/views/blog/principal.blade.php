@extends('master')
@section('title', 'Home')
@section('css')
<style>
    .imagen-container_ {
        width: 100%;
        height: 85%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
        position: fixed;
        z-index: 9;
    }
    .imagen-container_ img {
        max-width: 25%;
        height: auto;
    }
    .carousel-inner {
        position: relative;
        width: 100%;
        height: 100%;
    }

    .carousel-item img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
</style>
@section('content')

    <div class="imagen-container_">
        <img src="{{asset('media/icons/nd_.png')}}" alt="nodum">
    </div>
    <div id="main_" class="row w-100 d-flex justify-content-center align-items-center m-0 h-100 w-100" style="padding-top: 0px; display: flex;">

        <div id="carouselExampleIndicators" class="carousel slide w-100" data-ride="carousel">

            <div class="carousel-inner h-100 ">

                @for($i = 0; $i < sizeof($carrousels); $i++)

                    @if($i == 0)
                        <div class="carousel-item active h-100" >

                            <img src=" {{ url('/multimedia'.$carrousels[$i]->file_path.'/'.$carrousels[$i]->file) }}" class="d-block  h-100  w-100"  alt="{{$carrousels[$i]->name}}" >

                        </div>

                    @else

                        <div class="carousel-item h-100">

                            <img src=" {{ url('/multimedia'.$carrousels[$i]->file_path.'/'.$carrousels[$i]->file) }}" class="d-block h-100 w-100"  alt="{{$carrousels[$i]->name}}" >

                        </div>
                    @endif
                @endfor

            </div>

        </div>

    </div>

{{-- <div id="Slider-mobile" class=" row justify-content-center align-items-center h-100 w-100 m-0" style="padding: 0;">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

        <ol class="carousel-indicators">
            @for($i = 0; $i < sizeof($carrousels); $i++)
                @if($i == 0)
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                @else
                    <li data-target="#carouselExampleIndicators" data-slide-to="{{$i}}"></li>
                @endif
            @endfor

        </ol>

        <div class="carousel-inner">
            @for($i = 0; $i < sizeof($carrousels); $i++)

                @if($i == 0)
                    <div class="carousel-item active">

                        <img src=" {{ url('/multimedia'.$carrousels[$i]->file_path.'/'.$carrousels[$i]->mobile) }}" class="d-block w-100 Height100" alt="..." s>

                    </div>

                @else

                    <div class="carousel-item">

                        <img src=" {{ url('/multimedia'.$carrousels[$i]->file_path.'/'.$carrousels[$i]->mobile) }}" class="d-block w-100 Height100" alt="..." s>

                    </div>
                @endif
            @endfor

        </div>


    </div>
</div> --}}

@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $('#carouselExampleIndicators').carousel({
                interval: 2000 ,
            });

        });
    </script>

@endsection
