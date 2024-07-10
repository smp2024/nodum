@extends('master')
@section('title', 'Home')
@section('css')
<style>
    .responsive-image {
        width: 100vw; /* Ancho del viewport */
        /* height: 100%; */
        object-fit: cover;
        max-height: 100%;
    }

</style>
@endsection
@section('content')
    <div id="main_" class="row w-100 d-flex justify-content-center align-items-center m-0 h-100" style="background-color: #1a1a1a; padding-top: 0px;">

        <img  id="main_image" src="{{ url('multimedia'.$home[0]->file_path.'/'.$home[0]->file) }}" alt="{{$home[0]->name}}" class="responsive-image">

    </div>
@endsection

@section('scripts')
    <script>

        if (screen.width < 800) {
        console.log('oo');
        $('#main_').removeClass("row");
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script>
    {{-- <script>
        // Espera a que se cargue completamente la imagen
        window.onload = function() {
            var image = document.getElementById('main_image');
            var colorThief = new ColorThief();
            var color = colorThief.getColor(image); // Obtiene el color predominante

            // Convierte el color en formato RGB a formato hexadecimal
            var rgbColor = 'rgb(' + color[0] + ',' + color[1] + ',' + color[2] + ')';
            var hexColor = rgbToHex(rgbColor);

            // Aplica el color de fondo al elemento con la clase bg-c
            document.getElementById('main_').style.backgroundColor = hexColor;
        };

        // Función para convertir el color RGB a hexadecimal
        function rgbToHex(rgb) {
            var rgbValues = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
            function hex(x) {
                return ("0" + parseInt(x).toString(16)).slice(-2);
            }
            return "#" + hex(rgbValues[1]) + hex(rgbValues[2]) + hex(rgbValues[3]);
        }
    </script> --}}

<script src='https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js'></script>

{{-- <script>
    // Espera a que la ventana esté completamente cargada antes de ejecutar el código
    window.onload = async function () {
        // Función para detectar texto en la imagen
        async function detectText(imageUrl) {
            // Carga la imagen
            const image = await fetch(imageUrl);
            const blob = await image.blob();
            const file = new File([blob], "image.jpg", { type: "image/jpeg" });

            // Utiliza tesseract.js para realizar OCR
            const { data: { text } } = await Tesseract.recognize(
                file,
                'eng', // Lenguaje de OCR (en este caso, inglés)
                { logger: m => console.log(m) } // Opciones, como un registro opcional
            );

            return text.length > 0; // Retorna true si se detectó texto, false si no
        }

        var imageUrl = "{{ url('multimedia'.$home[0]->file_path.'/'.$home[0]->file) }}";
        var hasText = await detectText(imageUrl);

        // Si la imagen contiene texto, establece la altura de la imagen en "auto"
        // Si no, establece la altura de la imagen en "100%"
        var imageElement = document.getElementById('main_image');
        if (!hasText) {
            imageElement.style.height = 'auto';
        } else {
            imageElement.style.height = '100%';
        }
    };
</script> --}}


@endsection
