@extends('admin.master')
@section('title', 'Categorias')

@section('breadcrumb')

    <li class="breadcrumb-item">
        <a href="{{ url('/admin/categories') }}">
            <i class="fal fa-send-backward"></i>
            Categorias
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
        #buscador_categories {
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
                                    Agregar Categoria
                                </h2>
                            </div>
                        <div class="inside">

                            @if (kvfj(Auth::user()->permissions, 'category_add'))

                                {!! Form::open(['url' => '/admin/category/add', 'files' => true]) !!}
                                    @csrf
                                    <div class="row" style="padding: 16px;">

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
                                    <i class="fal fa-send-backward"></i>
                                    Categorias
                                </h2>
                                </div>

                                <div class="col-md-5">
                                    {!! Form::text('search', null, ['class' => 'form-control', 'placeholder' => 'Ingrese su busqueda', 'required', 'id' => 'buscador_categories']) !!}
                                </div>
                        </div>

                    </div>
                    <div class="inside" style="max-height: 400px; overflow: auto;">
                        <div id="preview_categories" class="row d-none" style="padding: 16px;">

                        </div>
                        <div id="table_categories" class="row" style="padding: 16px;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        {{-- <td width="70">Icono</td> --}}
                                        <td >Nombre</td>
                                        <td  width="50">Estado</td>
                                        <td width="150"></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cats as $cat)
                                        <tr>
                                            {{-- <td>{!!  html_entity_decode($cat->icon, ENT_QUOTES | ENT_XML1, 'UTF-8')  !!}</td> --}}
                                            <td>{{ $cat->name }}</td>
                                            <td class="text-center">
                                                @if ($cat->status == '1')
                                                    <i class="fal fa-toggle-on status-icon" style="color: green; cursor: pointer;" data-id="{{ $cat->id }}"></i>
                                                @else
                                                    <i class="fad fa-toggle-off status-icon" style="color: red; cursor: pointer;" data-id="{{ $cat->id }}"></i>
                                                @endif
                                            </td>                                            <td>
                                                <div class="opts">
                                                    @if (kvfj(Auth::user()->permissions, 'category_edit'))
                                                        <a href="{{ url('/admin/category/'.$cat->id.'/edit') }}" data-toggle="tooltip" data-placement="top" title="Editar">
                                                            <i class="fas fa-edit" style="color: #ffc107;"></i>
                                                        </a>
                                                    @endif
                                                    @if (kvfj(Auth::user()->permissions, 'category_delete'))

                                                        <a href="#" data-action="delete" data-path="/admin/category" data-object="{{ $cat->id }}" data-toggle="tooltip" data-placement="top" title="Eliminar" class="btn_deleted" >
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


@section('scripts')
<script>
    $(document).ready(function() {
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
    });

    window.addEventListener('load',function(){
        document.getElementById("buscador_categories").addEventListener("keyup", () => {
            if((document.getElementById("buscador_categories").value.length)>1)
                fetch(`/categories/search?texto=${document.getElementById("buscador_categories").value}`,{ method:'get' })
                .then(response  =>  response.text() )
                .then(html      =>  {   document.getElementById("preview_categories").innerHTML = html  })
            else
                document.getElementById("preview_categories").innerHTML = ""
        })
    });
    $(document).ready(function() {
        $('#buscador_categories').on('input', function() {
            // Obtener el valor del input
            var inputValor = document.getElementById('buscador_categories').value;

            // Contar el número de caracteres
            var numeroCaracteres = inputValor.length;


            // Convertir el valor a un número
            // var searchNumber = parseFloat(searchValue);
            console.log(numeroCaracteres);
            // Verificar si el valor es igual o mayor a 0
            if (numeroCaracteres <= 0) {
            // Si es igual o mayor a 0, remover la clase d-none del div con id 'tabla'
            $('#table_categories').removeClass('d-none');
            // Agregar la clase d-none al div con id 'preview'
            $('#preview_categories').addClass('d-none');
            } else {
            // Si es menor a 0, remover la clase d-none del div con id 'preview'
            $('#preview_categories').removeClass('d-none');
            // Agregar la clase d-none al div con id 'tabla'
            $('#table_categories').addClass('d-none');
            }
        });

        $('.status-icon').on('click', function() {
            // Obtener el ID del elemento
            var id = $(this).data('id');
            console.log(id);

            // Mostrar la animación de carga
            $('#loading-animation').removeClass('d-none');

            // Llamar a la API con AJAX
            $.ajax({
                type: 'POST',
                url: '/api/category/change-status/', // Ruta de la API
                data: {
                    id: id
                },
                success: function(response) {
                    // Ocultar la animación de carga
                    // Recargar la página
                    location.reload();
                    console.log(response);

                    // Mostrar la respuesta en un alert
                    // $('#response-container').html('<div class="alert alert-success">' + response.message + '</div>');
                },
                error: function(xhr, status, error, response) {
                    // Ocultar la animación de carga
                    $('#loading-animation').removeClass('d-none');

                    // Manejar errores aquí si es necesario
                    console.log(response);
                }
            });
        });
    });

</script>
@endsection

