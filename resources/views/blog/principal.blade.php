@extends('master')
@section('title', 'Home')
@section('css')

@section('content')


<div id="main_" class="row w-100 d-flex justify-content-center align-items-center m-0 h-100" style="background-color: #1a1a1a; padding-top: 0px;">

    {{-- <img  id="main_image" src="{{ url('multimedia'.$home[0]->file_path.'/'.$home[0]->file) }}" alt="{{$home[0]->name}}" class="responsive-image"> --}}

    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

        <div class="carousel-inner h-100 ">

            @for($i = 0; $i < sizeof($carrousels); $i++)

                @if($i == 0)
                    <div class="carousel-item active h-100" >

                        <img src=" {{ url('/multimedia'.$carrousels[$i]->file_path.'/'.$carrousels[$i]->file) }}" class="d-block  h-100 " style="max-width: 100%;" alt="{{$carrousels[$i]->name}}" >

                    </div>

                @else

                    <div class="carousel-item h-100">

                        <img src=" {{ url('/multimedia'.$carrousels[$i]->file_path.'/'.$carrousels[$i]->file) }}" class="d-block h-100 " style="max-width: 100%;" alt="{{$carrousels[$i]->name}}" >

                    </div>
                @endif
            @endfor

        </div>

    </div>

</div>

<div id="Slider-mobile" class=" row justify-content-center align-items-center h-100 w-100 m-0" style="padding: 0;">
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
