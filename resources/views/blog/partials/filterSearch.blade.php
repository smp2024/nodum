<div class="filtro w-100">
    {!! Form::open(['url' => '/filter-search', 'id' => 'filterForm', 'files' => true, 'method' => 'post']) !!}

        <div class="content ">
            <h4 class="toggle-list-categoria" data-filter="cat"> <span>+</span> Categorías </h4>
            <ul class="cat medidas" >

                <!-- Lista de categorías -->

                @foreach($categories as $category)

                    <li>
                        <label class="container c1" >
                            <input  onclick="filterByCategory()" type="checkbox" name="categoria_checkbox[]" value="{{ $category->id }}" id="category_{{ $category->id }}"  >
                            <span class="checkmark"></span>
                            <a href="#" >{{ $category->name }}</a>
                        </label>
                    </li>

                @endforeach

            </ul>
            <hr>
        </div>

        <div class="content">
            <h4 class="toggle-list-artista" data-filter="artist"><span>+</span>  Artistas </h4>
            <ul class="artist medidas" >

                @php
                if (!$articles->isEmpty()) {
                    foreach ($articles as $article) {
                        $artists[] = $article->artist_id;
                    }
                    $artists = array_unique($artists);
                    sort($artists);
                }
                @endphp
                @if (!empty($artists))
                    @foreach ($artists as $artist)
                        @foreach ($artistas as $artista)
                            @if ($artista->id == $artist)
                                <li>
                                    <label class="container c1" >
                                        <input onclick="filterByArtist()" type="checkbox" name="artista_checkbox[]" value="{{ $artista->id }}" id="artista_{{ $tecnica->id }}"  >
                                        <span class="checkmark"></span>
                                        <a href="#" >{{ $artista->name }} {{ $artista->lastname }} </a>
                                    </label>
                                </li>
                            @endif
                        @endforeach
                    @endforeach
                @endif

            </ul>
            <hr>
        </div>

        <div class="content">
            <h4 class="toggle-list-tecnica" data-filter="tec"><span>+</span>  Técnicas </h4>
            <ul class="tec medidas" >
                @php
                    if (!$articles->isEmpty()) {
                        foreach ($articles as $article) {
                            $technics[] = $article->subcategory_id;
                        }
                        $technics = array_unique($technics);
                        sort($technics);
                    }
                @endphp

                @if (!empty($technics))
                    @foreach ($technics as $technic)
                        @foreach ($tecnicas as $tecnica)
                            @if ($tecnica->id == $technic)
                            <li>

                            <label class="container c1" >
                                <input onclick="filterByTechnic()" type="checkbox" name="tecnica_checkbox[]" value="{{ $tecnica->id }}" id="tecnica_{{ $tecnica->id }}"  >
                                <span class="checkmark"></span>
                                <a href="#" >{{ $tecnica->name }}</a>
                            </label>
                            </li>
                            @endif
                        @endforeach
                    @endforeach
                @endif
            </ul>
            <hr>
        </div>

        <div class="content">
            <h4>Precio</h4>
            <div class="currency-selector">
                <span id="mxTab" class="currency-tab active" onclick="showCurrency('mx')">MX</span>
                <span id="usTab" class="currency-tab" onclick="showCurrency('us')">USA</span>
            </div>

            <!-- Rango de precios para MX -->
            <div id="mxPrices">

                <p id="minPrice" class="m-0">Hasta <span id="priceValue" style="width: 33%;" class="m-0 ml-2"> ${{ number_format($articles->max('price_max'), 2, '.', ',') }}</span></p>
                {{-- <input type="number" name="price_min" value="" id="pMin" hidden> --}}
                <div style="display: inline-flex">
                    <input name="price_min"  type="range" min="{{ $articles->min('price_min') }}" max="{{ $articles->max('price_max') }}" value="{{ $articles->max('price_max') }}" id="priceRange">
                </div>
                {{-- <p id="maxPrice" class="m-0">Hasta ${{ number_format($articles->max('price_max'), 2, '.', ',') }}</p> --}}
                {{-- <input name="price_max" hidden type="range" min="{{ $articles->min('price_min') }}" max="{{ $articles->max('price_max') }}" value="{{ $articles->max('price_max') }}" id="rangePrice"> --}}

            </div>

            <!-- Rango de precios para USA (inicialmente oculto) -->
            <div id="usPrices" style="display: none;">
                <p id="minPriceUS" class="m-0">To <span id="priceValueUS" style="width: 33%;" class="m-0 ml-2"> ${{ number_format($articles->max('price_max_us'), 2, '.', ',') }}</span></p>
                <div style="display: inline-flex">
                    <input name="price_min_us"  type="range" min="{{ $articles->min('price_min_us') }}" max="{{ $articles->max('price_max_us') }}" value="{{ $articles->max('price_max_us') }}" id="priceRangeUS">
                </div>
                {{-- <p id="maxPriceUS" class="m-0">To ${{ number_format($articles->max('price_max_us'), 2, '.', ',') }}</p> --}}
                {{-- <input name="price_max_us" hidden type="range" min="{{ $articles->min('price_max_us') }}" max="{{ $articles->max('price_max_us') }}" value="{{ $articles->max('price_max_us') }}" id=""> --}}

            </div>

            <hr>
        </div>

        <div class="content">
            <h4>Medidas</h4>
            <!-- Rango de medidas -->
            <ul>
                <li>
                    <label class="container c1" >
                        <input type="checkbox" name="measures[]" value="1"  onclick="filterByMeasure()" >
                        <span class="checkmark"></span>
                        <a href="#" >Pequeño</a>
                    </label>
                <li>
                    <label class="container c1" >
                        <input type="checkbox" name="measures[]" value="2"   onclick="filterByMeasure()">
                        <span class="checkmark"></span>
                        <a href="#" >Mediano</a>
                    </label>
                </li>
                <li>
                    <label class="container c1" >
                        <input type="checkbox" name="measures[]" value="3"   onclick="filterByMeasure()">
                        <span class="checkmark"></span>
                        <a href="#" >Grande</a>
                    </label>
                </li>
            </ul>
        </div>

        {{-- {!! Form::submit('Buscar', ['class' => 'btn btn-outline-dark mt16']) !!} --}}

    {!! Form::close() !!}
</div>
