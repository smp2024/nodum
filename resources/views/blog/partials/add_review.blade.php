
@section('css')
<style>
    .slick-slide {
        width: 190px !important;
    }
</style>
@endsection
    <div class="row d-flex w-100 justify-content-center align-items-center " >
        <h1 class="text-center w-100 mt-3" style="color: #fff;">Nombre evento</h1>
        <div class="content d-flex justify-content-center align-items-center cont-review" style="width: 99%; overflow: auto;">

            <div class="col-lg-4 col-xs-12 mb-3" >
                <div   class="cont-card-event" style="background-color: #fff;  padding: 0% !important;">
                    {{-- <p class="m-0 text-center title_article" >{{ html_entity_decode($article->name, ENT_QUOTES | ENT_XML1, 'UTF-8') }}</p> --}}

                    <div class="card__content">
                        <span><i class="ri-double-quotes-l"></i></span>
                        <div class="card__details">
                            <p>
                                We had a great time collaboraring with the Filament team. They
                                have my high recommendation!
                            </p>
                            <h4>- Marnus Stephen</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xs-12 mb-3" >
                <div   class="cont-card-event" style="background-color: #fff;  padding: 0% !important;">
                    {{-- <p class="m-0 text-center title_article" >{{ html_entity_decode($article->name, ENT_QUOTES | ENT_XML1, 'UTF-8') }}</p> --}}

                    <div class="card__content">
                        <span><i class="ri-double-quotes-l"></i></span>
                        <div class="card__details">
                            <p>
                                We had a great time collaboraring with the Filament team. They
                                have my high recommendation!
                            </p>
                            <h4>- Marnus Stephen</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xs-12 mb-3" >
                <div   class="cont-card-event" style="background-color: #fff;  padding: 0% !important;">
                    {{-- <p class="m-0 text-center title_article" >{{ html_entity_decode($article->name, ENT_QUOTES | ENT_XML1, 'UTF-8') }}</p> --}}

                    <div class="card__content">
                        <span><i class="ri-double-quotes-l"></i></span>
                        <div class="card__details">
                            <p>
                                We had a great time collaboraring with the Filament team. They
                                have my high recommendation!
                            </p>
                            <h4>- Marnus Stephen</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xs-12 mb-3" >
                <div   class="cont-card-event" style="background-color: #fff;  padding: 0% !important;">
                    {{-- <p class="m-0 text-center title_article" >{{ html_entity_decode($article->name, ENT_QUOTES | ENT_XML1, 'UTF-8') }}</p> --}}

                    <div class="card__content">
                        <span><i class="ri-double-quotes-l"></i></span>
                        <div class="card__details">
                            <p>
                                We had a great time collaboraring with the Filament team. They
                                have my high recommendation!
                            </p>
                            <h4>- Marnus Stephen</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-xs-12 mb-3" >
                <div   class="cont-card-event" style="background-color: #fff;  padding: 0% !important;">
                    {{-- <p class="m-0 text-center title_article" >{{ html_entity_decode($article->name, ENT_QUOTES | ENT_XML1, 'UTF-8') }}</p> --}}

                    <div class="card__content">
                        <span><i class="ri-double-quotes-l"></i></span>
                        <div class="card__details">
                            <p>
                                We had a great time collaboraring with the Filament team. They
                                have my high recommendation!
                            </p>
                            <h4>- Marnus Stephen</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xs-12 mb-3" >
                <div   class="cont-card-event" style="background-color: #fff;  padding: 0% !important;">
                    {{-- <p class="m-0 text-center title_article" >{{ html_entity_decode($article->name, ENT_QUOTES | ENT_XML1, 'UTF-8') }}</p> --}}

                    <div class="card__content">
                        <span><i class="ri-double-quotes-l"></i></span>
                        <div class="card__details">
                            <p>
                                We had a great time collaboraring with the Filament team. They
                                have my high recommendation!
                            </p>
                            <h4>- Marnus Stephen</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xs-12 mb-3" >
                <div   class="cont-card-event" style="background-color: #fff;  padding: 0% !important;">
                    {{-- <p class="m-0 text-center title_article" >{{ html_entity_decode($article->name, ENT_QUOTES | ENT_XML1, 'UTF-8') }}</p> --}}

                    <div class="card__content">
                        <span><i class="ri-double-quotes-l"></i></span>
                        <div class="card__details">
                            <p>
                                We had a great time collaboraring with the Filament team. They
                                have my high recommendation!
                            </p>
                            <h4>- Marnus Stephen</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xs-12 mb-3" >
                <div   class="cont-card-event" style="background-color: #fff;  padding: 0% !important;">
                    {{-- <p class="m-0 text-center title_article" >{{ html_entity_decode($article->name, ENT_QUOTES | ENT_XML1, 'UTF-8') }}</p> --}}

                    <div class="card__content">
                        <span><i class="ri-double-quotes-l"></i></span>
                        <div class="card__details">
                            <p>
                                We had a great time collaboraring with the Filament team. They
                                have my high recommendation!
                            </p>
                            <h4>- Marnus Stephen</h4>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

@section('scripts')
    <script>

    $(document).ready(function(){
        if (screen.width < 800) {
            console.log('peque{a}');
            $('.cont-review').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 4000,
            });
            $('.slick-arrow').addClass('d-none');
            //document.write ("Pequeña");
        } else {

            if (screen.width < 1280) {
                $('.cont-review').slick({
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 4000,
                    });
                    $('.slick-arrow').addClass('d-none');
                //document.write ("Mediana");
            } else {
                    $('.cont-review').slick({
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 4000,
                    });
                    $('.slick-arrow').addClass('d-none');
                //document.write ("Grande");
            }
        }

    });
    </script>
@endsection
