@extends('admin.master')
@section('title', 'Imagen de inicio')

@section('breadcrumb')

    <li class="breadcrumb-item">
        <a href="{{ url('/admin/kits') }}">
            <i class="far fa-object-group"></i>
            Imagen de inicio
        </a>
    </li>

@endsection

@section('content')

    <div class="container-fluid">

        <div class="row">
            @if ($active == 0)

                <div class="col-md-5">
                    <div class="container-fluid p-0">
                        <div class="panel shadow">
                                <div class="header">
                                    <h2 class="title">
                                        <i class="fas fa-plus"></i>
                                        Agregar Imagen de inicio
                                    </h2>
                                </div>
                            <div class="inside">

                                @if (kvfj(Auth::user()->permissions, 'carousel_add'))

                                    {!! Form::open(['url' => '/admin/carousel/add', 'files' => true]) !!}
                                        @csrf
                                        <div class="row" style="padding: 16px;">

                                            <div class="col-12">

                                                {!! Form::label('name','Nombre:') !!}
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-keyboard"></i>
                                                        </span>
                                                    </div>
                                                    {!! Form::text('name', null, [ 'class' => 'form-control']) !!}
                                                </div>

                                            </div>

                                            <div class="col-12 mt16">

                                                {!! Form::label('file','Imagen:') !!}
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        {!! Form::file('file', ['class' => 'custom-file-input', 'id' => 'customFile']) !!}
                                                        <label class="custom-file-label" for="customFile">Choose File</label>
                                                    </div>
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

            @endif

            <div @if ($active != 0)
                    class="col-md-12 mt-4 mt-md-0"
                @else
                    class="col-md-7 mt-4 mt-md-0"
                @endif
                >
                <div class="panel shadow">

                    <div class="header">
                        <h2 class="title">
                            <i class="far fa-object-group"></i>
                            Imagen de inicio
                        </h2>
                    </div>
                    <div class="inside" style="max-height: 400px; overflow: auto;">
                        <div class="row" style="padding: 16px;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td width="70">Imagen</td>
                                        <td >Nombre</td>
                                        <td  width="50">Estado</td>
                                        <td width="150"></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cats as $cat)
                                        <tr>
                                            <td><img src="{{ url('/multimedia/'.$cat->file_path.'/t_'.$cat->file) }}" class="img-fluid"></td>
                                            <td>{{ $cat->name }}</td>
                                            <td class="text-center">
                                                @if ($cat->status == '1')
                                                    <i class="fas fa-globe-americas" style="color: green;"></i>
                                                @else
                                                    <i class="fas fa-globe-americas" style="color: red;"></i>
                                                @endif
                                            </td>                                            <td>
                                                <div class="opts">
                                                    @if (kvfj(Auth::user()->permissions, 'carousel_edit'))
                                                        <a href="{{ url('/admin/carousel/'.$cat->id.'/edit') }}" data-toggle="tooltip" data-placement="top" title="Editar">
                                                            <i class="fas fa-edit" style="color: #ffc107;"></i>
                                                        </a>
                                                    @endif
                                                    @if (kvfj(Auth::user()->permissions, 'carousel_delete'))

                                                        <a href="#" data-action="delete" data-path="/admin/carousel" data-object="{{ $cat->id }}" data-toggle="tooltip" data-placement="top" title="Eliminar" class="btn_deleted" >
                                                            <i class="fas fa-trash-alt" style="color: red;"></i>
                                                        </a>

                                                    @endif
                                                </div>
                                            </td>

                                        </tr>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

@stop


