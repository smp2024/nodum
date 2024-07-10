@extends('master')
@section('title', $section)
@section('content')
    <div id="main_" class="row w-100 d-flex justify-content-center align-items-center m-0 h-100" >


            @foreach ($sections as $politic)
            <div id="{{$politic->name}}" class="col-12 h-100 p-3" >

                <div class="row h-100  justify-content-center align-content-center" style="padding: 10%">

                    {!! html_entity_decode($politic->description, ENT_QUOTES | ENT_XML1, 'UTF-8') !!}

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
