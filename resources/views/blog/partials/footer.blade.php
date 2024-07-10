<!-- Footer -->
<footer id="footer " class="text-center text-lg-start text-white">
    <!-- Grid container -->
    <div class="container pb-0">
        <!-- Section: Links -->
        <section class="">
            <!--Grid row-->
            <div class="row">
                <!-- Grid column -->
                <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h6 class="text-uppercase mb-4 font-weight-bold">
                        {{ $company[0]->company_name }}
                    </h6>
                    <p>
                        {!! html_entity_decode($company[0]->description, ENT_QUOTES | ENT_XML1, 'UTF-8') !!}
                    </p>
                </div>
                <!-- Grid column -->

                <hr class="w-100 clearfix d-md-none" />
                @if ($countcomapny != 0)
                    @foreach ( $sections as $politica )
                        @if ($politica->slug != 'contacto')

                            <!-- Grid column -->
                                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                                    <h6 class="text-uppercase mb-4 font-weight-bold">Nosotros</h6>

                                    <p>
                                        <a class="text-white" href={{ route('politicas', "$politica->slug") }}
                                            >
                                            {{$politica->name}}
                                        </a>
                                    </p>

                                </div>
                            <!-- Grid column -->

                            <hr class="w-100 clearfix d-md-none" />

                            <!-- Grid column -->
                            <hr class="w-100 clearfix d-md-none" />

                        @endif
                    @endforeach
                @endif

                <!-- Grid column -->
                @foreach ( $sections as $politica )
                    @if ($politica->slug == 'contacto')
                        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                            <h6 class="text-uppercase mb-4 font-weight-bold">{{ $politica->name }}</h6>
                            <span class="contactoP"><i class="fas fa-home mr-3"></i>   {!! html_entity_decode($politica->direction, ENT_QUOTES | ENT_XML1, 'UTF-8') !!}</span>
                            <p><i class="fas fa-envelope mr-3"></i> {{ $politica->email }}</p>
                            <p><i class="fas fa-phone mr-3"></i> {{ $politica->phone }}</p>
                            <p><i class="fas fa-phone mr-3"></i> {{ $politica->phone2 }}</p>

                        </div>
                    @endif
                @endforeach
            </div>
            <!--Grid row-->
        </section>
        <!-- Section: Links -->
    </div>
    <!-- /Grid container -->

    <!-- Copyright -->
    <div class="text-center" style="background-color: rgba(0, 0, 0, 0.2);" >
        Copyright &copy; <script>document.write(new Date().getFullYear());</script> All rights reserved
    </div>
    <!--/ Copyright -->
</footer>
<!-- /Footer -->

