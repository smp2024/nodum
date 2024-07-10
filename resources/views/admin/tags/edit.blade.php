@extends('admin.master')
@section('title', 'Editar etiqueta')

@section('breadcrumb')


    <li class="breadcrumb-item">
        <a href="{{ url('/admin/tags') }}">
            <i class="fal fa-send-backward"></i>
            etiquetas
        </a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/tag/'.$cat->id.'/edit') }}">
            <i class="far fa-folder-open"></i>
            {{$cat->name}}
        </a>
    </li>

@endsection

@section('content')

    <div class="container-fluid">

        <div class="row">

            <div class="col-md-9 p-0">
                <div class="container-fluid">
                    <div class="panel shadow">
                            <div class="header">
                                <h2 class="title">
                                    <i class="fas fa-plus"></i>
                                    Editar etiqueta
                                </h2>
                            </div>
                        <div class="inside">

                            @if (kvfj(Auth::user()->permissions, 'tag_edit'))

                                {!! Form::open(['url' => '/admin/tag/'.$cat->id.'/edit', 'files' => true]) !!}
                                    @csrf
                                    <div class="row" style="padding: 16px;">

                                        <div class="col-md-7">

                                            {!! Form::label('name','Nombre:') !!}
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-keyboard"></i>
                                                    </span>
                                                </div>
                                                {!! Form::text('name', $cat->name, [ 'class' => 'form-control']) !!}
                                            </div>

                                        </div>

                                        

                                        <div class="col-md-4 col-12">

                                            {!! Form::label('status','Estado:') !!}
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-toggle-on"></i>
                                                    </span>
                                                </div>
                                                {!! Form::select('status', [ '0' => 'Borrador', '1' => 'Publicado'], $cat->status, ['class' => 'custom-select']) !!}

                                            </div>
                                        </div>

                                    </div>

                                    {!! Form::submit('Guardar', ['class' => 'btn btn-success mt16']) !!}

                                {!! Form::close() !!}

                            @endif

                        </div>

                    </div>
                </div>
            </div>

           

        </div>

    </div>

@stop


