@extends('master')

@section('title', 'register')

@section('content')
<div class="container">
    <div id="register" class="row login-container js-navDots justify-content-center align-items-center Height100">

        <div class="col-sm-12 justify-content-center align-items-center Height100" style="padding: 0%">
            <h1 class="content" style="margin-top:0 !important; display: flex;">¡Bienvenido a {!! html_entity_decode($company[0]->company_name, ENT_QUOTES | ENT_XML1, 'UTF-8') !!}!</h1>


                {!! Form::open(['route' => 'register']) !!}

                <div class="row" style="padding: 16px; padding-top: 0px !important;">
                    <div class="col-md-6 col-12 mt-1">
                        {!! Form::label('name','Nombre:') !!}
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fal fa-phone"></i>
                                </span>
                            </div>
                            {!! Form::number('name', null, [ 'class' => 'form-control', 'required' => true]) !!}
                        </div>
                    </div>

                    <div class="col-md-6 col-12 mt-1">

                        {!! Form::label('lastname','Apellidos:') !!}
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fal fa-phone"></i>
                                </span>
                            </div>
                            {!! Form::number('lastname', null, [ 'class' => 'form-control', 'required' => true]) !!}
                        </div>
                    </div>

                    <div class="col-md-6 col-12 mt-1">

                        {!! Form::label('email','Correo electrónico:') !!}
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fal fa-phone"></i>
                                </span>
                            </div>
                            {!! Form::number('email', null, [ 'class' => 'form-control', 'required' => true]) !!}
                        </div>
                    </div>
                    <div class="col-md-6 col-12 mt-1">

                        {!! Form::label('phone','Teléfono:') !!}
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fal fa-phone"></i>
                                </span>
                            </div>
                            {!! Form::number('phone', null, [ 'class' => 'form-control', 'required' => true]) !!}
                        </div>

                    </div>

                    <div class="col-md-6 col-12 mt-1">

                        {!! Form::label('birthday','Fecha de nacimiento:') !!}
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fal fa-calendar-star"></i>
                                </span>
                            </div>
                            {!! Form::date('birthday', null, [ 'class' => 'form-control', 'required' => true]) !!}
                        </div>

                    </div>

                    <div class="col-md-6 col-12 mt-1">

                        {!! Form::label('country','Pais:') !!}
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-globe-americas"></i>
                                </span>
                            </div>
                            {!! Form::text('country', null, [ 'class' => 'form-control', 'required' => true]) !!}
                        </div>

                    </div>

                    <div class="col-md-6 col-12 mt-1">

                        {!! Form::label('password','Contraseña:') !!}
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fal fa-phone"></i>
                                </span>
                            </div>
                            {!! Form::number('password', null, [ 'class' => 'form-control', 'required' => true]) !!}
                        </div>
                    </div>

                    <div class="col-md-6 col-12 mt-1">
                        {!! Form::label('cpassword','ConfirmarContraseña:') !!}
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fal fa-phone"></i>
                                </span>
                            </div>
                            {!! Form::number('cpassword', null, [ 'class' => 'form-control', 'required' => true]) !!}
                        </div>
                    </div>

                </div>
                <div class="row"style="padding: 16px; padding-top: 1px;">
                    <div class="col-11">

                        {!! Form::label('file','Imagen de perfil:') !!}
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-id-badge"></i>
                                </span>
                            </div>
                            <div class="custom-file">
                                {!! Form::file('file', ['class' => 'custom-file-input', 'id' => 'customFile', 'required' => true]) !!}
                                <label class="custom-file-label h-100 m-0" for="customFile">Choose File</label>
                            </div>
                        </div>

                    </div>

                    <div class="col-1">
                        <p id="confirm_img" class="h-100 m-0 d-flex justify-content-center align-items-end">
                            <i class="fas fa-times text-danger"></i>
                        </p>
                    </div>


                    <div id="imagePreview" style="margin-top: 10px; padding: 16px;" class="text-center">
                        <img id="previewImg" src="#" alt="Vista previa de la imagen" style="max-width: 30%; height: auto; display: none;" />
                    </div>
                </div>

                {!! Form::submit('Registrarse', ['class' => 'btn btn-info mt16']) !!}
                {!! Form::close() !!}

                @if (Session::has('message'))
                    <div class="container">
                        <div class="alert alert-{{ Session::get('typealert') }}" style="display: none;">
                            {{ Session::get('message') }}
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <script>
                                $('.alert').slideDown();
                                setTimeout(function() {
                                    $('.alert').slideUp();
                                }, 3000);
                            </script>
                        </div>
                    </div>
                @endif

                <div class="footer mt16">
                    <a href="{{ url('/login') }}" style="color: #fff;">Ya tengo una cuenta, ingresar.</a>
                </div>


        </div>

    </div>
</div>
@stop
@section('scripts')
    <script>
        $(document).ready(function(){

            $("#intro").addClass("backgroud_1");
        });

    </script>

    <script>
        window.fbAsyncInit = function() {
        FB.init({
            appId      : '{your-app-id}',
            cookie     : true,
            xfbml      : true,
            version    : '{api-version}'
        });

        FB.AppEvents.logPageView();

        };

        (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));


    </script>
    <script>
    $(document).ready(function() {

      $('#customFile').change(function() {
            var fileName = $(this).val().split('\\').pop();
            console.log(fileName);

            if (fileName) {
                $('#confirm_img').html('<i class="fas fa-check text-success"></i>');
            } else {
                $('#confirm_img').html('<i class="fas fa-times text-danger"></i>');
            }

            let file = this.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewImg').attr('src', e.target.result);
                    $('#previewImg').show();
                }
                reader.readAsDataURL(file);
            } else {
                $('#previewImg').hide();
            }
        });
    });
    </script>
@endsection
