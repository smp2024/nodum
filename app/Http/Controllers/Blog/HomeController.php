<?php

namespace App\Http\Controllers\Blog;

use App\Description;
use App\Http\Controllers\Controller;
use App\Mail\EFDmail;
use App\NGallery;
use App\PGallery;
use App\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function getHome()
    {
        /** Primera sección **/
        $carrousels = DB::table('carousels')->orderBy('id', 'DESC')->where('status', 1)->where('type', 0)->get();

        $data = [
            'carrousels' => $carrousels,
        ];

        return view('blog.principal', $data);
    }

    public function getAboutUs($politica)
    {
        $politicas = DB::table('corporate_areas')->orderBy('id', 'DESC')->where('slug', $politica)->get();

        $data = [
            'politicas' => $politicas,
        ];

        return view('blog.sections.politica', $data);
    }

    public function getCategories($category, Request $request)
    {
        $category_id = DB::table('categories')->where('status', '1')->where('slug', $category)->first();

        if ($category == 'artistas') {
            $articles = DB::table('artists')->where('status', '1')->orderBy('lastname', 'ASC')->get();

            // Add 50 test elements to $articles
            // for ($i = 0; $i < 50; $i++) {
            //     $articles[] = (object) [
            //         'id' => $i + 1,
            //         'name' => 'Artist ' . ($i + 1),
            //         'status' => '1',
            //         'lastname' => 'Lastname ' . ($i + 1),
            //         // Add more properties as needed
            //     ];
            // }
        }
        if ($category == 'noticias') {
            $articles = DB::table('news')->where('status', '1')->where('deleted_at', null)->orderBy('id', 'DESC')->get();
        }
        if ($category == 'proyectos') {
            $articles = DB::table('projects')->where('status', '1')->where('deleted_at', null)->orderBy('id', 'DESC')->get();
        }
        if ($category == 'obras') {
            $artistas = DB::table('artists')->where('status', '1')->orderBy('id', 'DESC')->get();
            $artistas->prepend((object) ['id' => 'Todos', 'name' => 'Todos']); // Agregar "Todos" al principio del array
            $categories = DB::table('categories')->where('status', '1')->get();
            $categories->prepend((object) ['id' => 'Todos', 'name' => 'Todos']); // Agregar "Todos" al principio del array
            $tecnicas = DB::table('sub_categories')->where('status', '1')->get();
            $tecnicas->prepend((object) ['id' => 'Todos', 'name' => 'Todos']); // Agregar "Todos" al principio del array
            $articles = DB::table('articles')->where('status', 1)->where('deleted_at',NULL)->get();
        }

        // dd($articles);

        if ($articles == null) {
            $countArt = 0;
        } else {
            $countArt = count($articles);
        }

        $url = $request->url(); // Obtiene la URL completa
        $lastSegment = strrchr($url, '/'); // Obtiene la última parte después de la última barra
        $lastWord = trim($lastSegment, '/'); // Elimina las barras adicionales al principio o final
        // Esto contendrá la última palabra de la URL
        $contacto = DB::table('corporate_areas')->where('slug', $category)->get();
        $news = DB::table('news')->where('deleted_at', null)->where('status', 1)->orderBy('id', 'DESC')->get();
        unset($news[0], $news[1], $news[2]);
        $newsmbolie = DB::table('news')->where('deleted_at', null)->where('status', 1)->orderBy('id', 'DESC')->get();
        $newsB = DB::table('news')->where('deleted_at', null)->where('status', 1)->orderBy('id', 'DESC')->paginate(1);

        $mediana1 = DB::table('news')->where('deleted_at', null)->where('status', 1)->orderBy('id', 'desc')->skip(1)->take(1)->get();
        $mediana2 = DB::table('news')->where('deleted_at', null)->where('status', 1)->orderBy('id', 'desc')->skip(2)->take(1)->get();
        $imagen = DB::table('n_galleries')->get();

        $data = [
            'news' => $news,
            'newsmbolie' => $newsmbolie,
            'newsB' => $newsB,
            'mediana1' => $mediana1,
            'mediana2' => $mediana2,
            'imagen' => $imagen,
            'articles' => $articles,
            'countArt' => $countArt,
            'section' => $lastWord,
            'categories' => $categories,
            'artistas' => $artistas,
            'tecnicas' => $tecnicas,
            'contacto' => $contacto,
        ];

        return view('blog.sections.articles', $data);
    }

    public function getModule($category, $id)
    {
        $users = DB::table('artists')->where('id', $id)->first();
        $categories = DB::table('categories')->where('status', '1')->get();
        $categories->prepend((object) ['id' => 'Todos', 'name' => 'Todos']); // Agregar "Todos" al principio del array
        $articles = DB::table('articles')->where('artist_id', $id)->where('status', 1)->get();
        $tecnicas = DB::table('sub_categories')->where('status', '1')->get();
        $tecnicas->prepend((object) ['id' => 'Todos', 'name' => 'Todos']); // Agregar "Todos" al principio del array
        $artistas = DB::table('artists')->where('status', '1')->orderBy('id', 'DESC')->get();
        $artistas->prepend((object) ['id' => 'Todos', 'name' => 'Todos']); // Agregar "Todos" al principio del array

        if ($category == 'new') {
            $vpn = DB::table('news')->where('slug', $id)->where('status', 1)->first();
            $descriptions = Description::where('new_id', $vpn->id)->where('type', 'description')->get();
            $videos = Description::where('new_id', $vpn->id)->where('type', 'video')->get();
            $imagenes = NGallery::where('new_id', $vpn->id)->whereNull('deleted_at')->get();
        }
        if ($category == 'project') {
            $vpn = DB::table('projects')->where('slug', $id)->where('status', 1)->first();
            $descriptions = Description::where('project_id', $vpn->id)->where('type', 'description')->get();
            $videos = Description::where('project_id', $vpn->id)->where('type', 'video')->get();
            $imagenes = PGallery::where('project_id', $vpn->id)->whereNull('deleted_at')->get();
        }
        if ($category == 'obras') {
            $vpn = DB::table('articles')->where('id', $id)->where('status', 1)->first();

            $artistas_ = DB::table('artists')->where('status', '1')->orderBy('id', 'DESC')->get();
        }
        // dd($artistas_);
        $data = [
            'post' => $users,
            'section' => $category,
            'categories' => $categories,
            'articles' => $articles,
            'vpn' => $vpn,
            'descriptions' => $descriptions,
            'videos' => $videos,
            'imagenes' => $imagenes,
            'tecnicas' => $tecnicas,
            'artistas' => $artistas,
            'artistas_' => $artistas_,
        ];
        if ($category == 'new' || $category == 'project') {
            return view('blog.partials.proyectos', $data);
        } elseif($category == 'obras') {
            return view('blog.partials.obra', $data);
        }else {
            return view('blog.sections.article', $data);
        }
    }

    public function pdf_contacto(Request $request)
    {
        $rules = [
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'description' => 'required',
        ];

        $messages = [
            'name.required' => 'Se requiere un nombre para enviar correo.',
            'lastname.required' => 'Se requiere un apellido para enviar correo.',
            'email.required' => 'Se requiere un correo electrónico para enviar correo.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withInput();
        } else {
            // dd($request->all());
            Mail::to('e.mejia@ciudadoceano.com')->queue(new EFDmail($request->all()));

            return view('emails.send');
        }
    }

    public function findsubcategories(Request $request)
    {
        $query = $request->input('query');

        $suggestions = Subcategory::where('status', 1)

            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'like', "%$query%");
            })
            ->get(['name']);

        return response()->json($suggestions);
    }

    public function changeTechnicStatus($id)
    {
        $c = SubCategory::findOrFail($id);
        $status = $c->status;
        if ($status == 1) {
            $c->status = 0;
            if ($c->save()) {
                return redirect('/admin/technics')->with('message', ' Técnica desactivada con éxito.')->with('typealert', 'success');
            }
        } else {
            $c->status = 1;
            if ($c->save()) {
                return redirect('/admin/technics')->with('message', ' Técnica activada con éxito.')->with('typealert', 'success');
            }
        }
    }
}
