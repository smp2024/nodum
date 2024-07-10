
@extends('master')




@section('content')
    @foreach ($sections as $politic)
    <div id="{{$politic->name}}" class="col-12 h-100 mt-2 mb-2" style="padding-top: 8%">

        <div class="row h-100  justify-content-center align-content-center">

            </h1>
                {{ $politic->name }}
            <h1>

            <p class="text-justify p-3" style="color: #fff;">{!! html_entity_decode($politic->description, ENT_QUOTES | ENT_XML1, 'UTF-8') !!}</p>

        </div>
    @endforeach
@endsection

@section('scripts')
@endsection
