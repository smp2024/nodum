<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Artist;
use App\Carousel;
use App\Category;
use App\Http\Controllers\Controller;
use App\News;
use App\Project;
use App\SubCategory;
use App\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user.status');
        $this->middleware('user.permissions');
        $this->middleware('isadmin');
    }

    public function getDashboard()
    {
        $users = User::count();
        $categories = Category::count();
        $tecnic = SubCategory::count();
        $news = News::count();
        $projects = Project::count();
        $artist = Artist::count();
        $articles = Article::count();
        $carousels = Carousel::where('status', 1)->count();


        $consulta = DB::table('visitas')
            ->select(DB::raw('COUNT(*) AS conteo_visitas, COUNT(DISTINCT ip) AS conteo_visitantes, url, pagina'))
            ->groupBy('url', 'pagina')
            ->orderBy('conteo_visitas', 'DESC')
            ->get();

        // dd($consulta);
        $data = [
                    'users' => $users,
                    'carousels' => $carousels,
                    'categories' => $categories,
                    'tecnic' => $tecnic,
                    'news' => $news,
                    'projects' => $projects,
                    'artist' => $artist,
                    'articles' => $articles,
                ];

        return view('admin.partials.dashboard', $data);
    }

    public function obtenerPaginasVisitadasEnFecha($fecha)
    {
    }
}
