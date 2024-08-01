@extends('admin.master')
@section('title', 'Técnicas')

@section('breadcrumb')

    <li class="breadcrumb-item">
        <a href="{{ url('/admin/technics') }}">
            <i class="fal fa-pencil-paintbrush"></i>
            Técnicas
        </a>
    </li>

@endsection
@section('css')
    <style>
        .preview-icon-content{
            display: flex;
            height: 100%;
            justify-content: center;
            align-items: center;
            width: 100%;
        }
        .preview-icon {
            font-size: 30px;
        }
        .d-none {
            display: none;
        }
        .d-block{
            display: block;
        }
        #buscador_technics {
            height: 100% !important;
        }
    </style>
@endsection

@section('content')

    <div class="container-fluid">

        <div class="row">

            <div class="col-md-5">
                <div class="container-fluid p-0">
                    <div class="panel shadow">
                            <div class="header">
                                <h2 class="title">
                                    <i class="fas fa-plus"></i>
                                    Agregar Técnica
                                </h2>
                            </div>
                        <div class="inside">

                            @if (kvfj(Auth::user()->permissions, 'technic_add'))

                                {!! Form::open(['url' => '/admin/technic/add', 'files' => true]) !!}
                                    @csrf
                                    <div class="row" style="padding: 16px;">
                                        <div class="col-12">

                                            {!! Form::label('category_id','Categoria:') !!}
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-school"></i>
                                                    </span>
                                                </div>
                                                <select class="custom-select" id="category_id" name="category_id">
                                                    @foreach ($categories as $key => $subclasificacion)
                                                        <option id="{{ $subclasificacion->id }}" name="{{ $subclasificacion->id }}" value="{{ $subclasificacion->id }}">{{ $subclasificacion->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>

                                        <div class="col-12">

                                            {!! Form::label('name','Nombre:') !!}
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fal fa-signature"></i>
                                                    </span>
                                                </div>
                                                {!! Form::text('name', null, [ 'class' => 'form-control']) !!}
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

            <div class="col-md-7 mt-4 mt-md-0">
                <div class="panel shadow">

                    <div class="header">
                        <div class="row">

                            <div class="col-md-7">
                                <h2 class="title">
                                    <i class="fal fa-pencil-paintbrush"></i>
                                    Técnicas
                                </h2>
                             </div>

                        </div>

                    </div>
                    <div class="inside"  style="overflow: auto;">

                            <table class="table" id="table_technics" >
                                <thead>
                                    <tr>

                                        <td >Nombre</td>
                                        <td >Categoria</td>
                                        <td  width="50">Estado</td>
                                        <td width="150"></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cats as $cat)
                                        <tr>
                                            <td>{{ $cat->name }}</td>
                                            <td>{{ $cat->getCategory->name }}</td>
                                            <td class="text-center">
                                                @if ($cat->status == '1')
                                                    <i class="fas fa-globe-americas status-icon" style="color: green;"data-id="{{ $cat->id }}"></i>
                                                @else
                                                    <i class="fas fa-globe-americas status-icon" style="color: red;"data-id="{{ $cat->id }}"></i>
                                                @endif
                                            </td>                                            <td>
                                                <div class="opts">
                                                    @if (kvfj(Auth::user()->permissions, 'technic_edit'))
                                                        <a href="{{ url('/admin/technic/'.$cat->id.'/edit') }}" data-toggle="tooltip" data-placement="top" title="Editar">
                                                            <i class="fas fa-edit" style="color: #ffc107;"></i>
                                                        </a>
                                                    @endif
                                                    @if (kvfj(Auth::user()->permissions, 'technic_delete'))

                                                        <a href="#" data-action="delete" data-path="/admin/technic" data-object="{{ $cat->id }}" data-toggle="tooltip" data-placement="top" title="Eliminar" class="btn_deleted" >
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

@stop


@section('scripts')
<script>
    $(document).ready(function() {
        $('#table_technics').DataTable();

        $('#icon').on('input', function() {
            // Obtener el valor del input
            var iconHtml = $(this).val();

            // Crear un elemento jQuery a partir del HTML del icono
            var iconElement = $(iconHtml);

            // Limpiar el contenido actual del span
            $('#preview_icon').empty();

            // Agregar el nuevo icono al span
            $('#preview_icon').append(iconElement);
        });

        $('.status-icon').on('click', function() {
            // Obtener el ID del elemento
            var id = $(this).data('id');
            console.log(id);
            // Llamar a la API con AJAX
            $.ajax({
                type: 'GET',
                url: '/technic/change-status/' + id, // Ruta de la API
                success: function(response) {
                    // Recargar la página
                    location.reload();
                    console.log(response);

                    // Mostrar la respuesta en un alert
                // $('#response-container').html('<div class="alert alert-success">' + response.message + '</div>');
                },
                error: function(xhr, status, error, response) {
                    // Manejar errores aquí si es necesario
                    console.log(response);
                }
            });
        });
    });

    </script>
@endsection
