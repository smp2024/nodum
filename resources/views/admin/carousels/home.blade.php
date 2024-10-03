@extends('admin.master')
@section('title', 'Carousel de inicio')

@section('breadcrumb')

    <li class="breadcrumb-item">
        <a href="{{ url('/admin/kits') }}">
            <i class="far fa-object-group"></i>
            Carousel de inicio
        </a>
    </li>

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
                                        Agregar Carousel de inicio
                                    </h2>
                                </div>
                            <div class="inside">

                                @if (kvfj(Auth::user()->permissions, 'carousel_add'))

                                    {!! Form::open(['url' => '/admin/carousel/add', 'files' => true]) !!}
                                        @csrf
                                        <div class="row" style="padding: 16px;">

                                            {{-- <div class="col-12">

                                                {!! Form::label('name','Nombre:') !!}
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-keyboard"></i>
                                                        </span>
                                                    </div>
                                                    {!! Form::text('name', null, [ 'class' => 'form-control']) !!}
                                                </div>

                                            </div> --}}

                                            <div class="col-12 mt16">

                                                {!! Form::label('file','Imagen para PC:') !!}
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        {!! Form::file('file', ['class' => 'custom-file-input', 'id' => 'customFile']) !!}
                                                        <label class="custom-file-label" for="customFile">Choose File</label>
                                                    </div>
                                                </div>

                                            </div>

{{--
                                            <div class="col-12 mt16">

                                                {!! Form::label('file2','Imagen para Tablet:') !!}
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        {!! Form::file('file2', ['class' => 'custom-file-input', 'id' => 'customFile2']) !!}
                                                        <label class="custom-file-label" for="customFile">Choose File</label>
                                                    </div>
                                                </div>

                                            </div>


                                            <div class="col-12 mt16">

                                                {!! Form::label('file3','Imagen para Celular:') !!}
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        {!! Form::file('file3', ['class' => 'custom-file-input', 'id' => 'customFile3']) !!}
                                                        <label class="custom-file-label" for="customFile">Choose File</label>
                                                    </div>
                                                </div>

                                            </div> --}}

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
                        <h2 class="title">
                            <i class="far fa-object-group"></i>
                            Carousel de inicio
                        </h2>
                    </div>
                    <div class="inside">
                        <div class="row" style="padding: 16px;">
                            <table class="table" id="table_carousel">
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
                                                <i class="fal fa-toggle-on status-icon" style="color: green; cursor: pointer;" data-id="{{ $cat->id }}"></i>
                                            @else
                                                <i class="fad fa-toggle-off status-icon" style="color: red; cursor: pointer;" data-id="{{ $cat->id }}"></i>
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

@section('scripts')
<script>
    $(document).ready(function() {
        $('#table_carousel').DataTable();

        $('.status-icon').on('click', function() {
            var id = $(this).data('id');
            $('#loading-animation').removeClass('d-none');
            $.ajax({
                type: 'POST',
                url: '/api/carousel/change-status',
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
        $('#icon').on('input', function() {
            var iconHtml = $(this).val();
            var iconElement = $(iconHtml);
            $('#preview_icon').empty();
            $('#preview_icon').append(iconElement);
        });
    });



</script>
@endsection

