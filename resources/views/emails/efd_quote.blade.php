@extends('emails.master')

@section('content')

     <p> La persona {{ $user1->name }} realizó la siguiente consulta sobre la renta de equipos para el proyecto: {{ $name}}  </p>
   

@endsection
