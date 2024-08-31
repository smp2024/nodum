<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

    <div class="carousel-inner">

        @for($i = 0; $i < sizeof($carrousels); $i++)

            @if($i == 0)
                <div class="carousel-item active">

                    <img src=" {{ url('/multimedia'.$carrousels[$i]->file_path.'/'.$carrousels[$i]->file) }}" class="d-block w-100 Height100" alt="..." >

                </div>

            @else

                <div class="carousel-item">

                    <img src=" {{ url('/multimedia'.$carrousels[$i]->file_path.'/'.$carrousels[$i]->file) }}" class="d-block w-100 Height100" alt="..." >

                </div>
            @endif
        @endfor

    </div>

</div>
