@extends('admin.master')
@section('title', 'Editar técnica')

@section('breadcrumb')


    <li class="breadcrumb-item">
        <a href="{{ url('/admin/technics') }}">
            <i class="fal fa-pencil-paintbrush"></i>
            Técnicas
        </a>
    </li>
   

@endsection

@section('content')

    <div class="container-fluid">

        <div class="row">

            <div class="col-md-12 p-0">
                <div class="container-fluid">
                    <div class="panel shadow">
                            <div class="header">
                                <h2 class="title">
                                    <i class="fas fa-plus"></i>
                                    Editar técnica
                                </h2>
                            </div>
                        <div class="inside">

                            @if (kvfj(Auth::user()->permissions, 'technic_edit'))

                                {!! Form::open(['url' => '/admin/technic/'.$cat->id.'/edit', 'files' => true]) !!}
                                    @csrf
                                    <div class="row" style="padding: 16px;">
                                        <div class="col-md-4 col-12">

                                            {!! Form::label('category_id','Categoria:') !!}
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-school"></i>
                                                    </span>
                                                </div>
                                                {{ Form::select('category_id', $subclasi, $cat->category_id, ['class'=>'form-control']) }}
                                            </div>
    
                                        </div>
                                        <div class="col-md-4 col-12 ">

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

                                        

                                        <div class="col-md-4 col-12 ">

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


