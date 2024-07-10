<?php

namespace App\Http\Controllers\Blog;

use App\Article;
use App\Artist;
use App\Carousel;
use App\Category;
use App\Http\Controllers\Controller;
use App\Tag;
use App\User;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getCategorySearch(Request $request)
    {
        $categories = Category::where('name', 'like', '%'.$request->input('texto').'%')
        ->orderBy('name', 'ASC')->get();

        $data = ['cats' => $categories];

        return view('admin.partials.categorySearch', $data);
    }

    public function getTagSearch(Request $request)
    {
        $tags = Tag::where('name', 'like', '%'.$request->input('texto').'%')
        ->orderBy('name', 'ASC')->get();

        $data = ['cats' => $tags];

        return view('admin.partials.tagSearch', $data);
    }

    public function findsubcategories(Request $request)
    {
        $search = $request->get('term');
        $result = Category::where('name', 'LIKE', '%'.$search.'%')->get();

        return response()->json($result);
    }

    public function changeCategoryStatus(Request $request)
    {
        $id = $request->input('id');
        $c = Category::findOrFail($id);
        $status = $c->status;
        if ($status == 1) {
            $c->status = 0;
            if ($c->save()) {
                return redirect('/admin/categories')->with('message', ' Categoria desactivada con éxito.')->with('typealert', 'success');
            }
        } else {
            $c->status = 1;
            if ($c->save()) {
                return redirect('/admin/categories')->with('message', ' Categoria activada con éxito.')->with('typealert', 'success');
            }
        }
    }

    public function changeArtistStatus($id)
    {
        $technic = Artist::find($id);
        $technic->status = !$technic->status;
        $technic->save();

        return response()->json(['success' => 'Status change successfully.']);
    }

    public function changeArticleStatus($id)
    {
        $technic = Article::find($id);
        $technic->status = !$technic->status;
        $technic->save();

        return response()->json(['success' => 'Status change successfully.']);
    }

    public function changeTagStatus($id)
    {
        $technic = Tag::find($id);
        $technic->status = !$technic->status;
        $technic->save();

        return response()->json(['success' => 'Status change successfully.']);
    }

    public function changeCarouselStatus($id)
    {
        $technic = Carousel::find($id);
        $technic->status = !$technic->status;
        $technic->save();

        return response()->json(['success' => 'Status change successfully.']);
    }

    public function changeUserStatus($id)
    {
        $technic = User::find($id);
        $technic->status = !$technic->status;
        $technic->save();

        return response()->json(['success' => 'Status change successfully.']);
    }

    // Resto de tus métodos de controlador aquí...

    public function test(Request $request)
    {
        if ($request->isMethod('post') && $request->has('api_key')) {
            return response()->json(['success' => 'Method allowed.']);
        } else {
            return response()->json(['error' => 'Method not allowed.']);
        }
    }

    public function uploadMassiveArticle(Request $request)
    {
        $formData = $request->input('formData');
        // dd($formData);

        return response()->json(['formData' => $request]);
        // $response = $request;
        // echo json_encode($formData);
        // exit;
    }
}
