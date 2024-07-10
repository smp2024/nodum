@extends('admin.master')
@section('title', 'Ediar '.$corporatearea->name)

@section('breadcrumb')

<li class="breadcrumb-item">
    <a href="{{ url('/admin/company') }}">
        <i class="fal fa-building"></i>
        Área Corporativa
    </a>
</li>
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/company/'.$corporatearea->slug.'/edit' ) }}">
            {!! $corporatearea->icon !!}
            Editar: {{ $corporatearea->name }}
        </a>
    </li>

@endsection

@section('content')

    <div class="container-fluid">

        <div class="row">

            @if ($corporatearea->slug == 'logo-y-descripcion-corta')
                <div class="col-md-4 logo-y-descripcion-corta mb-md-0 mb-3">
                    <div class="panel shadow">
                        <div class="header">
                            <h2 class="title">
                                <i class="fal fa-draw-polygon"></i>
                                Editar  logo
                            </h2>

                        </div>
                        <div class="inside">
                            <div class="edit_avatar" style="height: 135px;">
                                {!! Form::open(['url' => '/admin/company/'.$corporatearea->slug.'/edit','id' => 'form_avatar_change', 'files' => true, 'class' => 'h-100']) !!}
                                    <a href="#" id="btn_avatar_edit" onclick="avatar()" style="height: 100%;">
                                        <div class="overlay" id="avatar_change_overlay"><i class="fas fa-camera"></i></div>
                                        @if (is_null($corporatearea->file))
                                            <img src="{{ asset('media/imagenes/u_d.png') }}" alt="" class="avatar-user">
                                        @else

                                            <img src="{{ url('/multimedia/'.$corporatearea->file_path.'/'.$corporatearea->file) }}" alt="">

                                        @endif
                                    </a>
                                    {!! Form::file('file', ['id' => 'input_file_avatar', 'accept' => 'image/*', 'class' => 'form-control']) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-8">
                    <div class="panel shadow">
                        <div class="header">
                            <h2 class="title">
                                <i class="fal fa-file-edit"></i>
                                Editar nombre de compañia
                            </h2>
                        </div>
                        <div class="inside">
                            {!! Form::open(['url' => '/admin/company/'.$corporatearea->slug.'/edit', 'files' => true]) !!}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">

                                            {{ Form::label('company_name','Nombre:') }}
                                            <div class="input-group-prepend">
                                                {!! Form::text('company_name', $corporatearea->company_name, ['class' => 'form-control ']) !!}
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                {!! Form::submit('Actualizar', ['class' => 'btn btn-success']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="panel shadow">
                        <div class="header">
                            <h2 class="title">
                                <i class="fal fa-file-edit"></i>
                                Editar descripción corta
                            </h2>
                        </div>
                        <div class="inside">
                            {!! Form::open(['url' => '/admin/company/'.$corporatearea->slug.'/edit', 'files' => true]) !!}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">

                                            {{ Form::label('description','Descripcion:') }}
                                            <div class="input-group-prepend">
                                                {!! Form::textarea('description', $corporatearea->description, ['class' => 'form-control ', 'id' => 'editor']) !!}
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                {!! Form::submit('Actualizar Descripción', ['class' => 'btn btn-success mt16']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            @elseif($corporatearea->slug == 'contacto')
                <div class="col-md-12">
                    <div class="container-fluid p-0">
                        <div class="panel shadow">
                                <div class="header">
                                    <h2 class="title">
                                        <i class="fas fa-plus"></i>
                                        Editar {{$corporatearea->name}}
                                    </h2>
                                </div>
                            <div class="inside">

                                @if (kvfj(Auth::user()->permissions, 'company_edit'))

                                    {!! Form::open(['url' => '/admin/company/'.$corporatearea->slug.'/edit', 'files' => true]) !!}

                                        <div class="row" style="padding: 16px;">

                                            <div class="col-md-4 mb-3">
                                                {!! Form::label('email','Correo:') !!}
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-keyboard"></i>
                                                        </span>
                                                    </div>
                                                    {!! Form::text('email', $corporatearea->email, [ 'class' => 'form-control']) !!}
                                                </div>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                {!! Form::label('phone','telefono 1:') !!}
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-keyboard"></i>
                                                        </span>
                                                    </div>
                                                    {!! Form::text('phone', $corporatearea->phone, [ 'class' => 'form-control']) !!}
                                                </div>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                {!! Form::label('phone2','telefono 2:') !!}
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-keyboard"></i>
                                                        </span>
                                                    </div>
                                                    {!! Form::text('phone2', $corporatearea->phone2, [ 'class' => 'form-control']) !!}
                                                </div>
                                            </div>


                                            <div class="col-md-4 mb-3">

                                                {!! Form::label('status','Estado:') !!}
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-toggle-on"></i>
                                                        </span>
                                                    </div>
                                                    {!! Form::select('status', [ 'draft' => 'Borrador', 'published' => 'Publicado'], $corporatearea->status, ['class' => 'custom-select']) !!}

                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">

                                                    {{ Form::label('direction','Dirección:') }}
                                                    <div class="input-group-prepend">
                                                        {!! Form::textarea('direction', $corporatearea->direction, ['class' => 'form-control ', 'id' => 'editor']) !!}
                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                        {!! Form::submit('Actualizar ' .$corporatearea->name, ['class' => 'btn btn-success mt16 mb-3']) !!}

                                    {!! Form::close() !!}


                                @endif

                            </div>

                        </div>
                    </div>
                </div>
            @endif

            @if ($corporatearea->slug != 'contacto' && $corporatearea->slug != 'logo-y-descripcion-corta')

                <div class="col-md-9">
                    <div class="container-fluid p-0">
                        <div class="panel shadow">
                                <div class="header">
                                    <h2 class="title">
                                        <i class="fas fa-plus"></i>
                                        Editar {{$corporatearea->name}}
                                    </h2>
                                </div>
                            <div class="inside">

                                @if (kvfj(Auth::user()->permissions, 'company_edit'))

                                    {!! Form::open(['url' => '/admin/company/'.$corporatearea->slug.'/edit', 'files' => true]) !!}

                                        <div class="row" >

                                            <div class="col-md-6 col-12 mt-3">

                                                {!! Form::label('file','Imagen:') !!}
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        {!! Form::file('file', ['class' => 'custom-file-input', 'id' => 'customFile']) !!}
                                                        <label class="custom-file-label" for="customFile">Choose File</label>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-6 col-12 mt-3">

                                                {!! Form::label('status','Estado:') !!}
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-toggle-on"></i>
                                                        </span>
                                                    </div>
                                                    {!! Form::select('status', [ 'draft' => 'Borrador', 'published' => 'Publicado'], $corporatearea->status, ['class' => 'custom-select']) !!}

                                                </div>
                                            </div>

                                            <div class="col-md-12 mt-3">
                                                <div class="form-group">

                                                    {{ Form::label('description','Descripcion:') }}
                                                    <div class="input-group-prepend">
                                                        {!! Form::textarea('description', $corporatearea->description, ['class' => 'form-control ', 'id' => 'editor']) !!}
                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                        {!! Form::submit('Actualizar ' .$corporatearea->name, ['class' => 'btn btn-success mt16']) !!}

                                    {!! Form::close() !!}


                                @endif

                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-3">

                    <div class="container-fluid p-0">
                        <div class="panel shadow">

                            <div class="header">
                                <h2 class="title">
                                    <i class="far fa-image "></i>
                                    Imagen destacada
                                </h2>
                            </div>
                            <div class="inside">
                                <img src="{{ url('/multimedia/'.$cat->file_path.'/t_'.$cat->file) }}" class="img-fluid">
                            </div>

                        </div>
                    </div>

                </div>
            @endif

        </div>

    </div>

@stop

@section('scripts')

    <script src="{{ asset('/libs/ckeditor/ckeditor.js') }}"></script>

    <script>
        CKEDITOR.replace( 'editor' );
    </script>
     <script src="{{ asset('js/user.js') }}"></script>

@endsection
