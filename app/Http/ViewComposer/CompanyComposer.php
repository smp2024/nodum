<?php

namespace App\Http\ViewComposer;

use App\Area;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class CompanyComposer
{
    public function compose(View $view)
    {
        $logdes = DB::table('corporate_areas')->where('slug', 'logo-y-descripcion-corta')->get();
        $company = DB::table('corporate_areas')->where('slug', '!=', 'logo-y-descripcion-corta')->where('status', 'published')->orderBy('orden_dash', 'ASC')->get();
        $contacto = DB::table('corporate_areas')->where('slug', '=', 'contacto')->get();
        // dd($contacto);
        $countcomapny = count($company);
        // $areas = Area::orderBy('orden', 'ASC')->where('status', 1)->get();
        $home = DB::table('carousels')->where('status', 1)->get();
        // dd($home);
        $view->with([
            // 'areas' => $areas,
            'company' => $logdes,
            'sections' => $company,
            'countcomapny' => $countcomapny,
            'home' => $home,
            'contacto' => $contacto,
        ]);
    }
}
