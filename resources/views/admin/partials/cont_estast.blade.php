<div class="col-md-3  col-sm-4 mb-3">
    <a href="{{ url('/admin/users/all') }}" >
    <div class="panel shadow">
        <div class="header">
            <h2 class="title">
                <i class="fal fa-users"></i>
                Usuarios resgistrados

            </h2>
        </div>
        <div class="inside">
            <div class="big_count">
                {{ $users }}
            </div>
        </div>
    </div>
    </a>
</div>
<div class="col-md-3 col-sm-4 mb-3">
    <a href="{{ url('/admin/carousels') }}">
    <div class="panel shadow">
        <div class="header">
            <h2 class="title">
                <i class="fal fa-object-ungroup"></i>
                Imagen de portada

            </h2>
        </div>
        <div class="inside">
            <div class="big_count">
                {{ $carousels }}
            </div>
        </div>
    </div>
    </a>
</div>
<div class="col-md-3 col-sm-4 mb-3">
    <a href="{{ url('/admin/categories') }}" >
    <div class="panel shadow">
        <div class="header">
            <h2 class="title">
                <i class="fal fa-send-backward"></i>
                Categorias

            </h2>
        </div>
        <div class="inside">
            <div class="big_count">
                {{ $categories }}
            </div>
        </div>
    </div>
    </a>
</div>
<div class="col-md-3 col-sm-4 mb-3">
    <a href="{{ url('/admin/technics') }}">
    <div class="panel shadow">
        <div class="header">
            <h2 class="title">
                <i class="fal fa-pencil-paintbrush"></i>
                Técnicas

            </h2>
        </div>
        <div class="inside">
            <div class="big_count">
                {{ $tecnic }}
            </div>
        </div>
    </div>
    </a>
</div>
<div class="col-md-3 col-sm-4 mb-3">
    <a href="{{ url('/admin/news/all') }}">
    <div class="panel shadow">
        <div class="header">
            <h2 class="title">
                <i class="fal fa-newspaper"></i>
                Noticias

            </h2>
        </div>
        <div class="inside">
            <div class="big_count">
                {{ $news }}
            </div>
        </div>
    </div>
    </a>
</div>
<div class="col-md-3 col-sm-4 mb-3">
    <a href="{{ url('/admin/projects/all') }}">
    <div class="panel shadow">
        <div class="header">
            <h2 class="title">
                <i class="fal fa-construction"></i>
                Proyectos

            </h2>
        </div>
        <div class="inside">
            <div class="big_count">
                {{ $projects }}
            </div>
        </div>
    </div>
    </a>
</div>
<div class="col-md-3 col-sm-4 mb-3">

    <a href="{{ url('/admin/artists/all') }}" >
    <div class="panel shadow">
        <div class="header">

            <h2 class="title">
                <i class="fal fa-head-side-brain"></i>
                Artistas

            </h2>
        </div>
        <div class="inside">
            <div class="big_count">
                {{ $artist }}
            </div>
        </div>
    </div>
    </a>
</div>
<div class="col-md-3 col-sm-4 mb-3">
    <a href="{{ url('/admin/articles/all') }}">
    <div class="panel shadow">
        <div class="header">
            <h2 class="title">
                <i class="fal fa-paint-brush-alt"></i>
                Obras

            </h2>
        </div>
        <div class="inside">
            <div class="big_count">
                {{ $articles }}
            </div>
        </div>
    </div>
    </a>
</div>

