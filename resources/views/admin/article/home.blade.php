@extends('admin.master')
@section('title', 'Articulos')

@section('breadcrumb')

    <li class="breadcrumb-item">
        <a href="{{ url('/admin/articles/all') }}">
            <i class="fal fa-pencil-paintbrush"></i>
            Articulos
        </a>
    </li>

@endsection

@section('content')

    <div class="container-fluid">

        <div class="panel shadow">

            <div class="header">
                <h2 class="title">
                    <i class="fal fa-pencil-paintbrush"></i>
                    Articulos
                </h2>
                <ul>


                    <li>
                        <a href="#">Filtrar <i class="fas fa-chevron-down"></i></a>
                        <ul>
                            <li>
                                <a href="{{ url('/admin/articles/all') }}">
                                    <i class="fas fa-code-branch" style="color: black;"></i></i> Todas las Categorias
                                </a>
                            </li>
                            @foreach ($categories as $category )
                                <li>
                                    <a href="{{ url('/admin/articles/'.$category->id) }}">
                                        <i class="fas fa-code-branch"></i> {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach


                        </ul>
                    </li>
                    @if (kvfj(Auth::user()->permissions, 'article_add'))
                    <li>
                        <a href="{{ url('/admin/article/add') }}">
                            <i class="fas fa-plus"></i> Agregar articulo
                        </a>
                    </li>
                @endif

                </ul>
            </div>

            <div class="inside w-100" style="overflow: auto;">

                    <div class="btn-group mb-3">
                        <a href="{{ route('articles.exportExcel') }}" class="btn btn-primary">
                            <i class="fas fa-file-excel"></i> Exportar a Excel
                        </a>
                    </div>
                    <table id="tabla_artistas" class="table">
                        <thead>
                            <tr>
                                <th>Imagen</th>
                                <th>Artista</th>
                                <th>Nombre</th>
                                <th>Categoria</th>
                                <th>Técnica</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($articles as $user)
                                <tr>
                                    <td style="text-align: center;"  width="65">
                                        <img src="{{ url('multimedia'.$user->file_path.'/'.$user->slug.'/'.$user->file) }}" width="65" height="65">
                                    </td>
                                    <td style="text-align: center;">{{ $user->getArtist->name  }} {{ $user->getArtist->lastname  }}  </td>
                                    <td style="text-align: center;">{{ $user->name }}  </td>
                                    <td style="text-align: center;">{{ $user->getCategory->name }}</td>
                                    <td style="text-align: center;">{{ $user->getSubCategory->name }}</td>
                                    <td style="text-align: center;">
                                        @if ($user->status == '1')
                                            <i class="fas fa-globe-americas" style="color: green;">Publicado</i>
                                        @else
                                            <i class="fas fa-globe-americas" style="color: red;">Borrador</i>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="opts">
                                            @if (kvfj(Auth::user()->permissions, 'article_edit' ))
                                                @if ($user->deleted_at == null)
                                                    <a href="{{ url('/admin/article/'.$user->id.'/edit') }}" data-toggle="tooltip" data-placement="top" title="Editar">
                                                        <i class="fas fa-edit" style="color: #ffc107;"></i>
                                                    </a>
                                                @endif
                                            @endif
                                            @if (kvfj(Auth::user()->permissions, 'article_delete'))
                                                @if ($user->deleted_at == null)
                                                    <a href="{{ url('admin/article/'.$user->id.'/delete') }}"  data-toggle="tooltip" title="Eliminar" data-placement="top" class="btn-deleted">
                                                        <i class="fas fa-trash-alt" style="color: red;"></i>
                                                    </a>
                                                @else
                                                    <a href="#" data-action="restore" data-path="/admin/article" data-object="{{ $user->id }}" data-toggle="tooltip" data-placement="top" title="Restaurar" class="btn-deleted">
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
            $('#tabla_artistas').DataTable({
            });
        });
    </script>
    @parent

@endsection
