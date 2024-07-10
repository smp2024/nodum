<div class="section-top">
    <div class="logo">
        <a href="/">
            <img src="{{ url('multimedia'.$company[0]->file_path.'/'.$company[0]->file) }}" alt=""  class="img-fluid icon-logo" >
        </a>
    </div>
    <div class="user">

        <div class="name">

            <p> <span class="subtitle">Hola:</span> {{ Auth::user()->name }} {{ Auth::user()->lastname }} </p>

        </div>
        <div class="email">
            <p>{{ Auth::user()->email }}</p>
        </div>
        <div class=" d-flex campaign-content-end align-content-end pr-1 " >
            <a href="{{ url('/logout') }}" data-toggle="tooltip" data-placement="top" title="Cerrar Sesión">
                Salir <i class="fas fa-power-off"></i>
            </a>
        </div>
    </div>
</div>

<div class="main" style="height: 95%; overflow: auto;" >
    <ul>

        @if (kvfj(Auth::user()->permissions, 'dashboard'))
        <li>
            <a href="{{ url('/admin') }}" class="lk-dashboard">
                <i class="fal fa-tachometer-alt-fast"></i>
                Dashboard
            </a>
        </li>
        @endif

        @if (kvfj(Auth::user()->permissions, 'users_list'))
        <li>
            <a href="{{ url('/admin/users/all') }}" class="lk-users_list lk-user_edit lk-user_permissions">
                <i class="fal fa-users"></i>
                Usuarios
            </a>
        </li>
        @endif

        @if (kvfj(Auth::user()->permissions, 'company'))
        <li>
            <a href="{{ url('/admin/company') }}" class="lk-company lk-company_add lk-company_edit">
                <i class="fal fa-building"></i>
                Área Corporativa
            </a>
        </li>
        @endif

        @if (kvfj(Auth::user()->permissions, 'carousels'))
        <li>
            <a href="{{ url('/admin/carousels') }}" class="lk-carousels lk-carousel_add lk-carousel_edit">
                <i class="fal fa-object-ungroup"></i>
                Imagen de inicio
            </a>
        </li>
        @endif

        @if (kvfj(Auth::user()->permissions, 'categories'))
        <li>
            <a href="{{ url('/admin/categories') }}" class="lk-categories lk-category_add lk-category_edit">
                <i class="fal fa-send-backward"></i>
                Categorias
            </a>
        </li>
        @endif

        @if (kvfj(Auth::user()->permissions, 'technics'))
        <li>
            <a href="{{ url('/admin/technics') }}" class="lk-technics lk-technic_add lk-technic_edit">
                <i class="fal fa-pencil-paintbrush"></i>
                Técnicas
            </a>
        </li>
        @endif
        {{--
        @if (kvfj(Auth::user()->permissions, 'tags'))
        <li>
            <a href="{{ url('/admin/tags') }}" class="lk-tags lk-tag_add lk-tag_edit">
                <i class="fal fa-tags"></i>
                Etiquetas
            </a>
        </li>
        @endif --}}

        @if (kvfj(Auth::user()->permissions, 'news'))
        <li>
            <a href="{{ url('/admin/news/all') }}" class="lk-news lk-new_add lk-new_edit">
                <i class="fal fa-newspaper"></i>
                Noticias
            </a>
        </li>
        @endif

        @if (kvfj(Auth::user()->permissions, 'projects'))
        <li>
            <a href="{{ url('/admin/projects/all') }}" class="lk-projects lk-project_add lk-project_edit">
                <i class="fal fa-construction"></i>
                Proyectos
            </a>
        </li>
        @endif

        @if (kvfj(Auth::user()->permissions, 'artists'))
        <li>
            <a href="{{ url('/admin/artists/all') }}" class="lk-artists lk-artist_add lk-artist_edit">
                <i class="fal fa-head-side-brain"></i>
                Artistas
            </a>
        </li>
        @endif

        @if (kvfj(Auth::user()->permissions, 'articles'))
        <li>
            <a href="{{ url('/admin/articles/all') }}" class="lk-articles lk-article_add lk-article_edit">
                <i class="fal fa-paint-brush-alt"></i>
                Obras
            </a>
        </li>
        @endif

        @if (kvfj(Auth::user()->permissions, 'massives'))
        <li>
            <a href="{{ url('/admin/massive_modifications') }}" class="lk-massives lk-massive_add lk-massive_edit">
                <i class="far fa-money-check"></i>
                Modificación masiva
            </a>
        </li>
        @endif



    </ul>
</div>
