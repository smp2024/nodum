@extends('admin.master')
@section('title', 'Etiquetas')

@section('breadcrumb')

    <li class="breadcrumb-item">
        <a href="{{ url('/admin/tags') }}">
            <i class="fal fa-tags"></i>
            Etiquetas
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
        #buscador_tags {
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
                                    Agregar Etiqueta
                                </h2>
                            </div>
                        <div class="inside">

                            @if (kvfj(Auth::user()->permissions, 'tag_add'))

                                {!! Form::open(['url' => '/admin/tag/add', 'files' => true]) !!}
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

                            <div class="col-md-7" >
                                <h2 class="title">
                                    <i class="fal fa-tags"></i>
                                    Etiquetas
                                </h2>
                            </div>

                            <div class="col-md-5">
                                {!! Form::text('search', null, ['class' => 'form-control', 'placeholder' => 'Ingrese su busqueda', 'required', 'id' => 'buscador_tags']) !!}
                            </div>
                        </div>

                    </div>
                    <div class="inside" style="max-height: 400px; overflow: auto;">
                        <div id="preview_tags" class="row d-none" style="padding: 16px;">

                        </div>
                        <div id="table_tags" class="row" style="padding: 16px;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td >Nombre</td>
                                        <td  width="50">Estado</td>
                                        <td width="150"></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cats as $cat)
                                        <tr>
                                            <td>{{ $cat->name }}</td>
                                            <td class="text-center">
                                                @if ($cat->status == '1')
                                                    <i class="fas fa-globe-americas" style="color: green;"></i>
                                                @else
                                                    <i class="fas fa-globe-americas" style="color: red;"></i>
                                                @endif
                                            </td>                                            <td>
                                                <div class="opts">
                                                    @if (kvfj(Auth::user()->permissions, 'tag_edit'))
                                                        <a href="{{ url('/admin/tag/'.$cat->id.'/edit') }}" data-toggle="tooltip" data-placement="top" title="Editar">
                                                            <i class="fas fa-edit" style="color: #ffc107;"></i>
                                                        </a>
                                                    @endif
                                                    @if (kvfj(Auth::user()->permissions, 'tag_delete'))

                                                        <a href="#" data-action="delete" data-path="/admin/tag" data-object="{{ $cat->id }}" data-toggle="tooltip" data-placement="top" title="Eliminar" class="btn_deleted" >
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
        document.getElementById("buscador_tags").addEventListener("keyup", () => {
            if((document.getElementById("buscador_tags").value.length)>1)
                fetch(`/tags/search?texto=${document.getElementById("buscador_tags").value}`,{ method:'get' })
                .then(response  =>  response.text() )
                .then(html      =>  {   document.getElementById("preview_tags").innerHTML = html  })
            else
                document.getElementById("preview_tags").innerHTML = ""
        })
    });
    $(document).ready(function() {
      $('#buscador_tags').on('input', function() {
        // Obtener el valor del input
        var inputValor = document.getElementById('buscador_tags').value;

        // Contar el número de caracteres
        var numeroCaracteres = inputValor.length;


        // Convertir el valor a un número
        // var searchNumber = parseFloat(searchValue);
        console.log(numeroCaracteres);
        // Verificar si el valor es igual o mayor a 0
        if (numeroCaracteres <= 0) {
          // Si es igual o mayor a 0, remover la clase d-none del div con id 'tabla'
          $('#table_tags').removeClass('d-none');
          // Agregar la clase d-none al div con id 'preview'
          $('#preview_tags').addClass('d-none');
        } else {
          // Si es menor a 0, remover la clase d-none del div con id 'preview'
          $('#preview_tags').removeClass('d-none');
          // Agregar la clase d-none al div con id 'tabla'
          $('#table_tags').addClass('d-none');
        }
      });
    });
</script>
@endsection
