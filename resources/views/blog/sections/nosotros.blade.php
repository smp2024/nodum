@extends('master')
@section('title', $section)
@section('content')
    <div id="main_" class="row w-100 d-flex justify-content-center align-items-center m-0 h-100" >
        <div id="" class="col-6 h-100" style="padding: 5% !important;">
            <img src="{{asset('media/icons/nd.jpeg')}}" style="height: 30%;" alt="nodum">
        </div>
        @foreach ($sections as $politic)
            <div id="{{$politic->name}}" class="col-6 h-100 p-3" >
                <div class="row h-100  justify-content-center align-content-end" style="padding: 0% 13% 13% 12%" >
                    <div id="" class="col-12 p-0" >
                        <h4 style="font-weight: 700;">{{$politic->name}}</h4>
                    </div>
                    <div id="" class="col-12 p-0  text-justify">
                        {!! html_entity_decode($politic->description, ENT_QUOTES | ENT_XML1, 'UTF-8') !!}
                    </div>
                </div>

            </div>
        @endforeach
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
