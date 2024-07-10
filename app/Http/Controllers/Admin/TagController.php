<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Tag;
class TagController extends Controller
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
        $cats = Tag::orderBy('name', 'ASC')->get();
        $active = count($cats);
        $data = [
            'cats' => $cats,
            'active' => $active
        ];
        return view('admin.tags.home', $data);

    }

    public function postTagAdd(Request $request)
    {
        $rules = [
            'name'                              => 'required',
            'slug'                              => 'slug|unique:tags,slug',
        ];


        $messages = [
            'name.required'                     => 'El nombre de la etiqueta es requerido.',
            'slug.unique'                        => 'La etiqueta ya se encuentra registrada',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):

            return back()->withErrors($validator)->with('message','Se ha producido un error')->with('typealert','danger');

        else:

            $c = new Tag;
            $c ->name                 = e($request->input('name'));
            $c ->slug                 = Str::slug($request->input('name'));
            if($c->save()):

                return back()->with('message', ' Etiqueta guardada con éxito.')->with('typealert', 'success');

            endif;

        endif;

    }

    public function getTagEdit($id)
    {

        $cat                = Tag::find( $id);
        $data               = ['cat' => $cat];
        return view('admin.tags.edit', $data);
    }

    public function postTagEdit(Request $request, $id)
    {
        $rules = [
            'name'                              => 'required',
            'slug'                              => 'slug|unique:tags,slug',
        ];


        $messages = [
            'name.required'                     => 'El nombre de la etiqueta es requerido.',
            'slug.unique'                        => 'La etiqueta ya se encuentra registrada',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):

            return back()->withErrors($validator)->with('message','Se ha producido un error')->with('typealert','danger')->withInput();

        else:

            $c = Tag::findOrFail( $id);
            $c ->name                 = e($request->input('name'));
            $c ->slug                 = Str::slug($request->input('name'));
            $c ->status                 = $request->input('status');
            if($c->save()):

                return redirect('/admin/tags')->with('message', ' Tag editado con éxito.')->with('typealert', 'success');

            endif;

        endif;

    }

    public function getTagDelete($id)
    {
        $c = Tag::find( $id);

        if($c->delete()):

            return back()->with('message', ' Tag elminado con éxito.')->with('typealert', 'success');

        endif;
    }

}
