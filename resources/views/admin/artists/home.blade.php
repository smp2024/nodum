@extends('admin.master')
@section('title', 'Artistas')

@section('breadcrumb')

    <li class="breadcrumb-item">
        <a href="{{ url('/admin/artists/all') }}">
            <i class="fal fa-head-side-brain"></i>
            Artistas
        </a>
    </li>

@endsection

@section('content')

    <div class="container-fluid">

        <div class="panel shadow">

            <div class="header">
                <h2 class="title">
                    <i class="fal fa-head-side-brain"></i>
                    Artistas
                </h2>
                <ul>

                {{--
                    <li>
                        <a href="#">Filtrar <i class="fas fa-chevron-down"></i></a>
                        <ul>
                            <li>
                                <a href="{{ url('/admin/artists/all') }}">
                                    <i class="fas fa-code-branch" style="color: black;"></i></i> Todas las Categorias
                                </a>
                            </li>
                            @foreach ($categories as $category )
                                <li>
                                    <a href="{{ url('/admin/artists/'.$category->id) }}">
                                        <i class="fas fa-code-branch"></i> {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach

                        </ul>
                    </li> --}}

                    <li>
                        <a href="{{ url('/admin/artist/add') }}">
                            <i class="fas fa-plus"></i> Agregar artista
                        </a>
                    </li>
                </ul>
            </div>

            <div class="inside w-100"  style="overflow: auto;">

                    <table id="tabla_artistas" class="table w-100">
                        <thead>
                            <tr>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th>Número de Obras</th>
                                <th>Estatus</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($artists as $new)
                                <tr>
                                    <td style="text-align: center;"  width="65">
                                        <img src="{{ url('multimedia'.$new->file_path.'/'.$new->file) }}" width="65" height="65">
                                    </td>
                                    <td style="text-align: center;">{{ $new->name }} {{ $new->lastname }} </td>
                                    <td style="text-align: center;">0</td>
                                    <td>
                                        @if ($new->status == '1')
                                            <i class="fas fa-globe-americas" style="color: green;">Publicado</i>
                                        @else
                                            <i class="fas fa-globe-americas" style="color: red;">Borrador</i>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="opts">
                                            {{-- <a href="{{ url('/admin/artist/'.$new->id.'/show') }}" data-toggle="tooltip" data-placement="top" title="Ver">
                                                <i class="fal fa-eye" style="color: #5d15af;"></i>
                                            </a> --}}
                                            @if (kvfj(Auth::user()->permissions, 'artist_edit' ))
                                                @if ($new->deleted_at == null)
                                                    <a href="{{ url('/admin/artist/'.$new->id.'/edit') }}" data-toggle="tooltip" data-placement="top" title="Editar">
                                                        <i class="fas fa-edit" style="color: #ffc107;"></i>
                                                    </a>
                                                @endif
                                            @endif
                                            @if (kvfj(Auth::user()->permissions, 'artist_delete'))
                                                @if ($new->status != 100)
                                                    <a href="{{ url('admin/artist/'.$new->id.'/delete') }}" data-toggle="tooltip" data-placement="top" title="Desactivar">
                                                        <i class="fas fa-ban" style="color: red;"></i>
                                                    </a>
                                                @else
                                                    {{-- <a href="#" data-action="restore" data-path="/admin/artist" data-object="{{ $new->id }}" data-toggle="tooltip" data-placement="top" title="Restaurar newo" class="btn-deleted"> --}}
                                                    <a href="{{ url('admin/artist/'.$new->id.'/delete') }}" data-toggle="tooltip" data-placement="top" title="Activar">
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
@stop


@section('scripts')
    <script>
         $(document).ready(function() {
            $('#tabla_artistas').DataTable();
        });
    </script>
@endsection
