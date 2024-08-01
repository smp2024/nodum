@extends('admin.master')
@section('title', 'Modificación Masiva')

@section('breadcrumb')

    <li class="breadcrumb-item">
        <a href="{{ url('/admin/articles/all') }}">
            <i class="far fa-money-check"></i>
            Modificación Masiva
        </a>
    </li>

@endsection
@section('css')
    <style>
        .upload-container {
            border: 2px dashed #ccc;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
        }

        .upload-container:hover {
            border-color: #888;
        }

        .gallery {
            display: flex;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .gallery img {
            max-width: 150px;
            margin: 10px;
        }
        #tablaCSV_wrapper {
            overflow: auto;
        }
    </style>
@endsection

@section('content')

    <div class="container-fluid">

        <div class="panel shadow">

            <div class="header">
                <h2 class="title">
                    <i class="far fa-money-check"></i>
                    Modificación Masiva
                </h2>
            </div>

            <div class="inside">

                <div class="container-fluid corporteArea">
                    <div class="row justify-content-center align-items-center">

                        <div class="col-md-6 col-sm-12 content-btn m-2">
                            <div id="btnCSV" class="cardBox" style="cursor: pointer;">
                                <div class="container-fluid card shadow">
                                    <div class="row">
                                        <div class="col-9 d-flex align-items-center">
                                            Carga de Excel
                                        </div>
                                        <div class="iconBx col-3">
                                            <i class="fal fa-file-csv"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12 content-btn m-2">
                            <div  id="btnGALLERY"   class="cardBox" style="cursor: pointer;">
                                <div class="container-fluid card shadow">
                                    <div class="row">
                                        <div class="col-9 d-flex align-items-center">
                                            Carga de archivos multimedia
                                        </div>
                                        <div class="iconBx col-3">
                                            <i class="fal fa-camera-polaroid"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>


    <div class="container-fluid mt-3 d-none" id="formCSV">

        <div class="panel shadow">
            <div class="header">
                <h2 class="title">
                    <i class="fal fa-file-csv"></i>
                    Carga de Excel
                </h2>
            </div>

            <div class="inside">
                <form action="{{ url('admin/upload-csv') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="file">Seleccionar archivo Excel</label>
                        <input type="file" name="file" id="file" class="form-control" accept=".xls,.xlsx" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Leer Excel</button>
                </form>

            </div>
            <div class="panel shadow mt-3 p-2">
                <div class="header">
                    <h2 class="title">
                        <i class="fal fa-file-csv"></i>
                        Datos del Excel
                    </h2>
                </div>
                {!! Form::open(['url' => '/admin/upload-massive', 'files' => true, 'id' => 'uploadMassiveData']) !!}
                    @csrf
                    <input type="hidden" name="data" value="{{ json_encode($data) }}">
                    <table class="table table-bordered w-100 p-1" id="tablaCSV" style="overflow: auto;">
                        <thead>
                            <tr>
                                @foreach ($headers as $header)
                                    <th>{{ $header }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                                <tr>
                                    @foreach ($row as $cell)
                                        <td>{{ $cell }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                        {!! Form::submit('Actualizar información', ['class' => 'btn btn-success float-right']) !!}
                    </table>

                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="container-fluid mt-3 d-none"  id="formGALLERY">

        <div class="panel shadow">
            <div class="header">
                <h2 class="title">
                    <i class="fal fa-camera-polaroid"></i>
                    Carga de Archivos
                </h2>
            </div>

            <div class="inside">

                {!! Form::open(['url' => '/admin/upload-avatars', 'method' => 'POST', 'files' => true, 'id' => 'upload-form']) !!}
                    @csrf
                    <div class="upload-container" id="drop-area">
                        <input class="d-none" type="file" id="fileElem" name="images[]" multiple accept="image/*" required>
                        <label class="btn btn-primary" for="fileElem" id="slectIMG">Seleccionar Archivos</label>
                        <p>O arrastra y suelta las imágenes aquí</p>
                    </div>
                    <div class="gallery" id="gallery"></div>
                    <button type="submit" class="btn btn-success mt-3">Subir Imágenes</button>
                {!! Form::close() !!}
                <div class="progress mt-3">
                    <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                </div>
                <div class="alert mt-3 d-none" id="upload-alert"></div>
            </div>
        </div>

    </div>

@stop


@section('scripts')
    <script>
        function contarElementosYMostrarFormulario() {
            var cantidadElementos = $('#tablaCSV tbody tr').length;
            if (cantidadElementos > 0) {
                $('#formCSV').removeClass('d-none');
            } else {
                $('#formCSV').addClass('d-none');
            }
        }

        contarElementosYMostrarFormulario();
        $(document).ready(function(){
            $("#btnCSV").click(function(){
                $('#tablaCSV tbody').empty();
                $('#formCSV').removeClass("d-none");
                $('#formGALLERY').addClass("d-none");
            });

            $("#btnGALLERY").click(function(){
                $('#formGALLERY').removeClass("d-none");
                $('#formCSV').addClass("d-none");
            });
            $("#clearList").click(function(){
                var $csvData = [];
                $('#tablaCSV tbody').empty();
            });
        });

        $(document).ready(function() {
            $('#tablaCSV').DataTable();
        });

    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let dropArea = document.getElementById("drop-area");
            let fileInput = document.getElementById("fileElem");
            let progressBar = document.querySelector('.progress-bar');
            let alertBox = document.getElementById('upload-alert');


            $("#slectIMG").click(function(){
                progressBar.style.width = '0%';
                progressBar.setAttribute('aria-valuenow', 0);
                progressBar.textContent = '0%';
            });

            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, () => dropArea.classList.add('highlight'), false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, () => dropArea.classList.remove('highlight'), false);
            });

            dropArea.addEventListener('drop', handleDrop, false);
            fileInput.addEventListener('change', handleFilesSelect, false);

            function handleDrop(e) {
                let dt = e.dataTransfer;
                let files = dt.files;
                handleFiles(files);
            }

            function handleFilesSelect(e) {
                let files = e.target.files;

                handleFiles(files);
            }

            function handleFiles(files) {
                files = [...files];
                files.forEach(previewFile);
            }

            function previewFile(file) {
                let reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onloadend = function () {
                    let img = document.createElement('img');
                    img.src = reader.result;
                    document.getElementById('gallery').appendChild(img);
                }
            }

        });
    </script>

    <script>
        // $(document).on("submit", "#uploadMassiveData", function(event) {
        //     // $("#overlay").fadeIn();
        //     event.preventDefault();
        //     var formData = [];
        //     // $('#tablaCSV tbody tr:gt(0)').each(function() { // Selecciona todas las filas excepto la primera (índice 0)
        //     //     var rowData = {};
        //     //     $(this).find('input').each(function() {
        //     //         var fieldName = $(this).attr('name').replace('-', ''); // Elimina el guión para obtener el nombre del campo
        //     //         rowData[fieldName] = $(this).val();
        //     //     });
        //     //     formData.push(rowData);
        //     // });
        //     console.log(formData);
        //     // $.ajax({
        //     //     url: "{{url('api/upload-massive')}}",
        //     //     type: "POST",
        //     //     dataType: "json",
        //     //     data:{'formData': formData},
        //     //     processData: false,
        //     //     contentType: false,
        //     //     beforeSend: function() {
        //     //         // $("#overlay").fadeIn();
        //     //     },
        //     //     success: function(response) {
        //     //         // event.preventDefault();

        //     //         console.log(response);
        //     //         // location.reload();

        //     //     },
        //     //     error: function(response) {
        //     //         console.log(response.responseText);
        //     //     },
        //     // });
        // });
    </script>
@endsection
