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
                        </div>

                    </div>
                    <div class="inside"  style="overflow: auto;">

                            <table class="table w-100" id="table_categories">
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

@stop


@section('scripts')
<script>
    $(document).ready(function() {
        $('#table_categories').DataTable();

        $('.status-icon').on('click', function() {
            var id = $(this).data('id');
            $('#loading-animation').removeClass('d-none');
            $.ajax({
                type: 'POST',
                url: '/api/category/change-status/',
                data: {
                    id: id
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr, status, error, response) {
                    $('#loading-animation').removeClass('d-none');
                }
            });
        });
        // $('#icon').on('input', function() {
        //     var iconHtml = $(this).val();
        //     var iconElement = $(iconHtml);
        //     $('#preview_icon').empty();
        //     $('#preview_icon').append(iconElement);
        // });
    });



</script>
@endsection

