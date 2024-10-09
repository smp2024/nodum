@extends('master')
@section('title', $section)
@section('content')

    <div id="main_" class="row w-100 d-flex justify-content-center align-items-center m-0 h-100" style="padding-top: 0px;">
        @if ($countArt == 0)
            <h1 style="color: #fff;">Sin proyectos por el momento.</h1>
        @else
            @foreach ($articles as $article)
                <div class="col-md-3 col-6 mr-2 justify-content-center align-items-center p-0" style="display: flex;">
                    <a href="#" class="Link_Not" data-pdf-url="{{ url('multimedia/'.$article->file_path.'/'.$article->pdf) }}" style=" height: 500px; width: 300px;">
                        <h5>{{$article->name}}</h5>
                        <img style="position: relative !important;" src="{{ url('multimedia/'.$article->file_path.'/'.$article->file) }}" class="d-block imagen_noticia w-100 mt-2" alt="{{$article->slug}}">
                    </a>
                </div>
            @endforeach
        @endif
    </div>


    <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">Visualizando PDF</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="pdfViewer" style="width: 100%; height: 600px;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.6/pdfobject.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.Link_Not').on('click', function(e) {
                e.preventDefault();
                var pdfUrl = $(this).data('pdf-url');

                PDFObject.embed(pdfUrl, "#pdfViewer");

                $('#pdfModal').modal('show');
            });
        });
    </script>


@endsection
