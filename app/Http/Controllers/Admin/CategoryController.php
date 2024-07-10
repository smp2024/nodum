<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user.status');
        $this->middleware('user.permissions');
        $this->middleware('isadmin');
    }

    public function getHome()
    {
        $cats = Category::orderBy('name', 'ASC')->get();
        $active = count($cats);
        $data = [
            'cats' => $cats,
            'active' => $active,
        ];

        return view('admin.categories.home', $data);
    }

    public function postCategoryAdd(Request $request)
    {
        $rules = [
            'name' => 'required',
            'slug' => 'slug|unique:categories,slug',
        ];

        $messages = [
            'name.required' => 'El nombre de la categoria es requerido.',
            'slug.unique' => 'La categoria ya se encuentra registrada',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger');
        } else {
            $c = new Category();
            $c->name = e($request->input('name'));
            $c->slug = Str::slug($request->input('name'));
            if ($c->save()) {
                return back()->with('message', ' Categoria guardada con éxito.')->with('typealert', 'success');
            }
        }
    }

    public function getCategoryEdit($id)
    {
        $cat = Category::find($id);
        $data = ['cat' => $cat];

        return view('admin.categories.edit', $data);
    }

    public function postCategoryEdit(Request $request, $id)
    {
        $rules = [
        ];

        $messages = [
            'file.required' => 'Seleccione una imagen destacada un categorie.',
            'file.image' => 'El archivo no es una imagen.',
            'file.dimensions' => 'Se requiere una imagen de dimesiones 1920px x 1080px',
            'file.max' => 'La imagen pesa más de 6Mb',
            'file_mobile.image' => 'El archivo no es una imagen.',
            'file_mobile.dimensions' => 'Se requiere una imagen de dimesiones 1080px x 1920px',
            'file_mobile.max' => 'La imagen pesa más de 6Mb',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withInput();
        } else {
            $c = Category::findOrFail($id);

            $c->status = $request->input('status');
            $c->name = e($request->input('name'));
            $c->slug = Str::slug($request->input('name'));

            if ($c->save()) {
                return redirect('/admin/categories')->with('message', ' Categoria actualizada con éxito.')->with('typealert', 'success');
            }
        }
    }

    public function getCategoryDelete($id)
    {
        $c = Category::find($id);

        if ($c->delete()) {
            return back()->with('message', ' Categoria elminada con éxito.')->with('typealert', 'success');
        }
    }
}
