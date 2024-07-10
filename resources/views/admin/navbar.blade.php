
<div class="page mt16">
    <div class="container-fluid">
        <nav aria-label="breadcrumb shadow">
            <button class="navbar-toggler d-md-none" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon">
                    <i class="fas fa-bars"></i>
                </span>
            </button>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('/admin') }}">
                        <i class="fal fa-tachometer-alt-fast"></i>
                        Dashboard
                    </a>
                </li>
                @section('breadcrumb')
                @show
            </ol>

        </nav>
    </div>
</div>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
        <div class="sidebar shadow" id="Menu-navbar">

            @include('admin.partials.cont_nav')

        </div>
    </ul>
</div>
