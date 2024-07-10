<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use Intervention\Image\Facades\Image;
use App\SubCategory;
use App\Category;
class TechnicController extends Controller
{
    public function __Construct()
    {
        $this->middleware('auth');
        $this->middleware('user.status');
        $this->middleware('user.permissions');
        $this->middleware('isadmin');
    }

    public function getHome()
    {
        $cats = SubCategory::orderBy('name', 'ASC')->get();
        $active = count($cats);
        $categories = Category::where('status', 1)->get();
        $data = [
            'cats' => $cats,
            'active' => $active,
            'categories' => $categories
        ];
        return view('admin.technics.home', $data);

    }

    public function postTechnicAdd(Request $request)
    {
        $rules = [
            'name'                              => 'required',
            'slug'                              => 'slug|unique:technics,slug',
        ];


        $messages = [
            'name.required'                     => 'El nombre de la Técnica es requerido.',
            'slug.unique'                        => 'La Técnica ya se encuentra registrada',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):

            return back()->withErrors($validator)->with('message','Se ha producido un error')->with('typealert','danger');

        else:

            $c = new SubCategory;
            $c ->name                 = e($request->input('name'));
            $c ->slug                 = Str::slug($request->input('name'));
            $c ->category_id                  = $request->input('category_id');
            if($c->save()):

                return back()->with('message', ' Técnica guardada con éxito.')->with('typealert', 'success');

            endif;

        endif;

    }

    public function getTechnicEdit($id)
    {

        $cat                = SubCategory::find( $id);
        $categories = Category::where('status', 1)->get();
        $categories     = Category::where('status', 1)      ->orderBy   ('name', 'ASC')->get();
        $clasi = array() + $categories->pluck('name', 'id')->toArray();
        $data               = ['cat' => $cat,
        'categories' => $categories, 'subclasi' => $clasi];
        return view('admin.technics.edit', $data);
    }

    public function postTechnicEdit(Request $request, $id)
    {
        $rules = [



        ];
     

        $messages = [
            'file.required'                     => 'Seleccione una imagen destacada.',
            'file.image'                        => 'El archivo no es una imagen.',
            'file.dimensions'                   => 'Se requiere una imagen de dimesiones 1920px x 1080px',
            'file.max'                          => 'La imagen pesa más de 6Mb',
            'file_mobile.image'                        => 'El archivo no es una imagen.',
            'file_mobile.dimensions'                   => 'Se requiere una imagen de dimesiones 1080px x 1920px',
            'file_mobile.max'                          => 'La imagen pesa más de 6Mb',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):

            return back()->withErrors($validator)->with('message','Se ha producido un error')->with('typealert','danger')->withInput();

        else:

            $c = SubCategory::findOrFail( $id);
           
            $c ->status                    = $request->input('status');
            $c ->name                    = e($request->input('name'));
            $c ->category_id                    = $request->input('category_id');

            if($c->save()):

               
                return redirect('/admin/technics')->with('message', ' Técnica actualizada con éxito.')->with('typealert', 'success');

            endif;

        endif;

    }

    public function getTechnicDelete($id)
    {
        $c = SubCategory::find( $id);

        if($c->delete()):

            return back()->with('message', 'La Técnica se a eliminado con éxito.')->with('typealert', 'success');

        endif;
    }

 
}

