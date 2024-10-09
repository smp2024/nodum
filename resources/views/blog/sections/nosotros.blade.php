@extends('master')
@section('title', $section)
@section('css')
<style>
    @media (max-width: 575px) and (orientation:portrait) {
        .text_us {
            align-content: start !important;
        }
    }
    @media (min-width: 320px) and (max-width: 575px) and (orientation:landscape) {
        .text_us {
            align-content: start !important;
        }
    }
</style>

@endsection
@section('content')
    <div id="main_" class="row w-100 justify-content-center align-items-center m-0 h-100" >
        <div id="" class="col-lg-6 d-none d-lg-block h-100" style="padding: 5% !important;">
            <img src="{{asset('media/icons/nd.png')}}" style="height: 30%;" alt="nodum">
        </div>
        @foreach ($sections as $politic)
            <div id="{{$politic->name}}" class="col-lg-6 col-12 h-100 p-3" >
                <div class="row h-100  justify-content-center align-content-end text_us" style="padding: 0% 13% 13% 12%" >
                    <div id="" class="col-12 p-0" >
                        <p style="font-weight: 700; font-size: calc(2rem + 14px);">{{$politic->name}}</p>
                    </div>
                    <div id="" class="col-12 p-0  text-justify" style="font-size: calc(0.5rem + 0.4vw) !important;">
                        {!! html_entity_decode($politic->description, ENT_QUOTES | ENT_XML1, 'UTF-8') !!}
                    </div>
                </div>

            </div>
        @endforeach
    </div>
    @include('blog.partials.footer')
@endsection

@section('scripts')
    <script>

        if (screen.width < 800) {
        console.log('oo');
        $('#main_').removeClass("row");
        }
    </script>
@endsection
