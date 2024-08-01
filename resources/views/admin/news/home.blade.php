@extends('admin.master')
@section('title', 'Noticias')

@section('breadcrumb')

    <li class="breadcrumb-item">
        <a href="{{ url('/admin/news/1') }}">
            <i class="fal fa-newspaper"></i>
            Noticias
        </a>
    </li>

@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5 col-12 mb-3 mb-md-0">
                <div class="panel shadow">

                    <div class="header">
                        <h2 class="title">
                            <i class="fas fa-plus"></i>
                            Agregar noticia
                        </h2>
                    </div>

                    <div class="inside">

                        {!! Form::open(['url' => '/admin/new/add', 'files' => true]) !!}

                            <div class="row">

                                <div class="col-md-12 col-12 mt16">
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

                                <div class="col-6 col-12 mt16">
                                    <label for="name">Imagen destacada:</label>
                                    <div class="custom-file">
                                        {!! Form::file('file', ['class' => 'custom-file-input', 'id' => 'customFile']) !!}
                                        <label class="custom-file-label" for="customFile">Choose File</label>
                                    </div>
                                </div>

                                <div class="col-5 mt16">
                                    <div class="form-group">

                                        {{ Form::label('sections','Número de secciones:') }}
                                        <div class="input-group-prepend">
                                            {!! Form::number('sections', 1, ['class' => 'form-control ','min' => '1']) !!}
                                        </div>

                                    </div>
                                </div>

                                <div class="col-7  mt16">
                                    {!! Form::label('date','Fecha:') !!}
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar-alt"></i>
                                            </span>
                                            {!! Form::date('date', null,['class' => 'date', 'style' => 'border: 1px solid #ced4da !important;' ]) !!}
                                        </div>

                                    </div>
                                </div>

                            </div>

                            {!! Form::submit('Guardar', ['class' => 'btn btn-success mt16']) !!}

                        {!! Form::close() !!}

                    </div>

                </div>
            </div>
            <div class="col-md-7">
                <div class="panel shadow">
                    {{-- {!! Form::open(['url' => '/admin/new/search']) !!}
                        <div class="input-group">
                            {!! Form::text('search', null, ['class' => 'form-control', 'placeholder' => 'Ingrese su busqueda', 'required']) !!}

                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </div>
                            </div>
                        </div>

                    {!! Form::close() !!} --}}
                    <div class="header">
                        <h2 class="title">
                            <i class="fal fa-newspaper"></i>
                            Noticias
                        </h2>
                        <ul>

                            <li>
                                <a href="#">Filtrar <i class="fas fa-chevron-down"></i></a>
                                <ul>
                                    <li>
                                        <a href="{{ url('/admin/news/1') }}">
                                            <i class="fas fa-globe-americas" style="color: green;"></i> Públicados
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/admin/news/0') }}">
                                            <i class="fas fa-globe-americas" style="color: blue;"></i> No públicados
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/admin/news/trash') }}">
                                            <i class="fas fa-trash" style="color: red;"></i> Papelera
                                        </a>
                                    </li>
                                </ul>
                            </li>

                        </ul>


                    </div>
                    <div class="container"  style="overflow: auto;">
                        <table id="tabla_artistas" class="table">
                            <thead>
                                <tr>
                                    <th>Imagen</th>
                                    <th>Nombre</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($news as $user)
                                    <tr>
                                        <td style="text-align: center;"  width="65">
                                            <img src="{{ url('multimedia'.$user->file_path.'/'.$user->slug.'/'.$user->file) }}" width="65" height="65">
                                        </td>
                                        <td style="text-align: center;">{{ $user->name }}  </td>
                                        <td style="text-align: center;">
                                            @if ($user->status == '1')
                                                <i class="fas fa-globe-americas" style="color: green;">Publicado</i>
                                            @else
                                                <i class="fas fa-globe-americas" style="color: red;">Borrador</i>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="opts">
                                                @if (kvfj(Auth::user()->permissions, $user->module.'_edit' ))
                                                    @if ($user->deleted_at == null)
                                                        <a href="{{ url('/admin/'.$user->module.'/'.$user->id.'/edit') }}" data-toggle="tooltip" data-placement="top" title="Editar">
                                                            <i class="fas fa-edit" style="color: #ffc107;"></i>
                                                        </a>
                                                    @endif
                                                @endif
                                                @if (kvfj(Auth::user()->permissions, $user->module.'_delete'))
                                                    @if ($user->deleted_at == null)
                                                        <a href="#" data-action="delete" data-path="/admin/{{$user->module}}" data-object="{{ $user->id }}" data-toggle="tooltip" data-placement="top" title="Eliminar" class="btn_deleted" >
                                                            <i class="fas fa-trash-alt" style="color: red;"></i>
                                                        </a>
                                                    @else
                                                        <a href="#" data-action="restore" data-path="/admin/{{$user->module}}" data-object="{{ $user->id }}" data-toggle="tooltip" data-placement="top" title="Restaurar articleo" class="btn_deleted">
                                                            <i class="fas fa-trash-restore" style="color: green;"></i>
                                                        </a>
                                                    @endif
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

@endsection

@section('scripts')
    <script>
         $(document).ready(function() {
            $('#tabla_artistas').DataTable();
        });
    </script>
@endsection
