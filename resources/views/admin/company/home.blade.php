@extends('admin.master')
@section('title', 'Área Corporativa')

@section('breadcrumb')

    <li class="breadcrumb-item">
        <a href="{{ url('/admin/company') }}">
            <i class="fal fa-building"></i>
            Área Corporativa
        </a>
    </li>

@endsection

@section('content')

    <div class="container-fluid corporteArea">
        <div class="row justify-content-center align-items-center">
            @foreach ($corporateareas as $corporatearea )
                <div class="col-md-4 col-sm-12 content-btn">
                    <div class="cardBox">
                        <a href=" {{url('admin/company/'.$corporatearea->slug)}} ">
                            <div class="container-fluid card shadow">
                                <div class="row">
                                    <div class="col-9 d-flex align-items-center">
                                        {{$corporatearea->name}}
                                    </div>
                                    <div class="iconBx col-3">
                                        {!!$corporatearea->icon!!}
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@stop


