@extends('admin.master')
@section('title', 'Proyectos')

@section('breadcrumb')

    <li class="breadcrumb-item">
        <a href="{{ url('/admin/projects/1') }}">
            <i class="fal fa-books"></i>
            Proyectos
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
                            Agregar proyecto
                        </h2>
                    </div>

                    <div class="inside">

                        {!! Form::open(['url' => '/admin/project/add', 'files' => true]) !!}
                            {!! Form::label('name','Nombre de Proyecto:') !!}
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-keyboard"></i>
                                    </span>
                                </div>
                                {!! Form::text('name',null, [ 'class' => 'form-control']) !!}
                            </div>

                            {!! Form::label('file','Imagen de portada:', [ 'class' => 'mt-3']) !!}
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fal fa-file-image"></i>
                                    </span>
                                </div>
                                {!! Form::file('file', [ 'class' => 'form-control', 'style' => 'padding: 4px;']) !!}
                            </div>

                            {!! Form::label('pdf','PDF:', [ 'class' => 'mt-3']) !!}
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fal fa-file-pdf"></i>
                                    </span>
                                </div>
                                {!! Form::file('pdf', [ 'class' => 'form-control', 'style' => 'padding: 4px;']) !!}
                            </div>

                            {!! Form::submit('Guardar', ['class' => 'btn btn-success mt16']) !!}

                        {!! Form::close() !!}

                    </div>

                </div>
            </div>
            <div class="col-md-7">
                <div class="panel shadow">

                    <div class="header">
                        <h2 class="title">
                            <i class="fal fa-books"></i>
                            Proyectos
                        </h2>
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
                                @foreach($projects as $article)
                                    <tr>
                                        <td style="text-align: center;"  width="65">
                                            <img src="{{ url('multimedia/'.$article->file_path.'/t_'.$article->file) }}" width="65" height="65">
                                        </td>
                                        <td style="text-align: center;">{{ $article->name }}  </td>
                                        <td style="text-align: center;">
                                            @if ($article->status == '1')
                                            <i class="fal fa-toggle-on status-icon" style="color: green; cursor: pointer;" data-id="{{ $article->id }}"></i>
                                        @else
                                            <i class="fad fa-toggle-off status-icon" style="color: red; cursor: pointer;" data-id="{{ $article->id }}"></i>
                                        @endif
                                        </td>
                                        <td>
                                            <div class="opts">
                                                @if (kvfj(Auth::user()->permissions, $article->module.'_edit' ))
                                                    @if ($article->deleted_at == null)
                                                        <a href="{{ url('/admin/'.$article->module.'/'.$article->id.'/edit') }}" data-toggle="tooltip" data-placement="top" title="Editar">
                                                            <i class="fas fa-edit" style="color: #ffc107;"></i>
                                                        </a>
                                                    @endif
                                                @endif
                                                @if (kvfj(Auth::user()->permissions, $article->module.'_delete'))
                                                    @if ($article->deleted_at == null)
                                                        <a href="#" data-action="delete" data-path="/admin/{{$article->module}}" data-object="{{ $article->id }}" data-toggle="tooltip" data-placement="top" title="Eliminar" class="btn_deleted" >
                                                            <i class="fas fa-trash-alt" style="color: red;"></i>
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
    $('.status-icon').on('click', function() {
            var id = $(this).data('id');
            $('#loading-animation').removeClass('d-none');
            console.log(id);

            $.ajax({
                type: 'POST',
                url: '/api/project/change-status',
                data: {
                    id: id
                },
                success: function(response) {
                    location.reload();
                    // console.log(response);

                },
                error: function(xhr, status, error, response) {
                    $('#loading-animation').removeClass('d-none');
                }
            });
        });
</script>
@endsection
