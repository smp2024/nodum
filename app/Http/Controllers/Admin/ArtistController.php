<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Tag;
use App\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;

class ArtistController extends Controller
{
    public function __Construct()
    {
        $this->middleware('auth');
        $this->middleware('user.status');
        $this->middleware('user.permissions');
        $this->middleware('isadmin');
    }
    public function getHome($status)
    {
        switch ($status) {

            case 'all':
                $cats = Artist::orderBy('name', 'ASC')->get();
                break;
            case 'borrador':
                $cats = Artist::where('status', '0')->orderBy('id', 'DESC')->get();
                break;
            case 'trash':
                $cats = Artist::onlyTrashed()->orderBy('id', 'DESC')->get();
                break;
            default:
                $cats = Artist::where('category_id', $status)->orderBy('id', 'DESC')->get();
                break;
        }

        $categories          = DB::table     ('categories')         ->where('status', 1)         ->get();
        $data = [
            'artists' => $cats,
            'categories' => $categories
        ];
        return view('admin.artists.home', $data);

    }


    public function getArtistAdd()
    {
        $cats = Artist::where('status', 1)         ->get();
        $categories          = DB::table     ('categories')         ->where('status', 1)         ->get();
        $tags = Tag::where('status', 1)->get();

        $data = [
            'artists' => $cats,
            'categories' => $categories,
            'tags' => $tags
        ];
        return view('admin.artists.add', $data);

    }

    public function postArtistAdd(Request $request)
    {
        $rules = [

            // 'file'                              => 'required|image|mimes:jpg,png,jpeg|max:6144|dimensions:min_width=1920,min_height=1080,max_width=1920,max_height=1080'

        ];

        $messages = [
            'file.required'                     => 'Seleccione una imagen destacada un artista.',
            'file.image'                        => 'El archivo no es una imagen.',
            'file.dimensions'                   => 'Se requiere una imagen de dimesiones 1920px x 1080px',
            'file.max'                          => 'La imagen pesa más de 6Mb',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):

            return back()->withErrors($validator)->with('message','Se ha producido un error')->with('typealert','danger');

        else:
            $slug = Str::slug($request->input('name').' '.$request->input('lastname'));

            $path = '/Artists';
            $c = new Artist;
            $c ->name                       = e($request->input('name'));
            $c ->lastname                       = e($request->input('lastname'));
            $c ->email                       = e($request->input('email'));
            $c ->phone                       = e($request->input('phone'));
            $c ->birthday                       = e($request->input('birthday'));
            $c ->country                       = e($request->input('country'));
            $c ->description_large                       = e($request->input('description_large'));
            $c ->slug                       = $slug;

            if($request->hasFile('file')):
                $fileExt = trim($request->file('file')->getClientOriginalExtension());
                $upload_path = Config::get('filesystems.disks.uploads.root');
                $name = Str::slug(str_replace($fileExt, '', $request->file('file')->getClientOriginalName()));
                $filename = rand(1,999).'-'.$name.'.'.$fileExt;
                $file_absolute = $upload_path.'/'.$path.'/'.$filename;
                $c ->file_path                  = $path;
                $c ->file                       = $filename;
               // $c ->url                        = e($request->input('url'));
            endif;
           // $c ->type                        = 0;
            if($c->save()):
                $artistId = $c->id;

                $artistTag        = Artist::findOrFail( $artistId);
                $artistTag->tags()->sync($request->get('tags'));
                $artistTag->categories()->sync($request->get('categories'));

                $artistTag->save();

                if($request->hasFile('file')):
                    $fl = $request->file->storeAs($path, $filename, 'uploads');
                    $imagT = Image::make($file_absolute);
                    $imagT->resize(256, 256, function($constraint){
                        $constraint->upsize();
                    });
                    $imagW = Image::make($file_absolute);
                    // $imagW->resize(1920, 1080, function($constraint){
                    //     $constraint->upsize();
                    // });
                    $imagT->save($upload_path.'/'.$path.'/t_'.$filename);
                    $imagW->save($upload_path.'/'.$path.'/'.$filename);
                endif;

                return back()->with('message', ' Artista guardado con éxito.')->with('typealert', 'success');

            endif;

        endif;

    }

    public function getArtistEdit($id)
    {

        $cats = Artist::findOrFail($id);
        $categories          = DB::table     ('categories')         ->where('status', 1)         ->get();
        $tags = Tag::where('status', 1)->get();
        $categories0       = DB::table('artist_category')->where('artist_id', $id)
        ->join('categories', 'artist_category.category_id', '=', 'categories.id')->get();
        $tags0       = DB::table('artist_tag')->where('artist_id', $id)
        ->join('tags', 'artist_tag.tag_id', '=', 'tags.id')->get();

        $data = [
            'artist' => $cats,
            'categories' => $categories,
            'tags' => $tags,
            'categories0'            => $categories0,
            'tags0'            => $tags0
        ];
        return view('admin.artists.edit', $data);
    }

    public function postArtistEdit(Request $request, $id)
    {

            $rules = [



            ];

        $messages = [
            'file.required'                     => 'Seleccione una imagen destacada un artist.',
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

            $c = Artist::findOrFail( $id);
            $c->tags()->sync($request->get('tags'));
            $c->categories()->sync($request->get('categories'));
            $c ->name                       = e($request->input('name'));
            $c ->lastname                       = e($request->input('lastname'));
            $slug = Str::slug($request->input('name').' '.$request->input('lastname'));
            $c ->slug                       = $slug;
            $c ->email                       = e($request->input('email'));
            $c ->phone                       = e($request->input('phone'));
            $c ->birthday                       = e($request->input('birthday'));
            $c ->country                       = e($request->input('country'));
            $c ->description_large                       = e($request->input('description_large'));
            $c ->status                       = $request->input('status');

            if($request->hasFile('file')):

                $path = '/Artists';
                $fileExt = trim($request->file('file')->getClientOriginalExtension());
                $upload_path = Config::get('filesystems.disks.uploads.root');
                $name = Str::slug(str_replace($fileExt, '', $request->file('file')->getClientOriginalName()));
                $filename = rand(1,999).'-'.$name.'.'.$fileExt;
                $file_absolute = $upload_path.'/'.$path.'/'.$filename;
                $c ->file_path                  = $path;
                $c ->file                       = $filename;


            endif;


            if($c->save()):

                if($request->hasFile('file')):
                    $fl = $request->file->storeAs($path, $filename, 'uploads');
                    $imagT = Image::make($file_absolute);
                    $imagT->resize(256, 256, function($constraint){
                        $constraint->upsize();
                    });
                    $imagW = Image::make($file_absolute);
                    // $imagW->resize(1920, 1080, function($constraint){
                    //     $constraint->upsize();
                    // });
                    $imagT->save($upload_path.'/'.$path.'/t_'.$filename);
                    $imagW->save($upload_path.'/'.$path.'/'.$filename);

                endif;

                if($request->hasFile('file_mobile')):
                    $fl = $request->file_mobile->storeAs($path, $filename, 'uploads');
                    $imagT = Image::make($file_absolute);
                    $imagT->resize(256, 256, function($constraint){
                        $constraint->upsize();
                    });
                    $imagW = Image::make($file_absolute);
                    // $imagW->resize(1080, 1920, function($constraint){
                    //     $constraint->upsize();
                    // });
                    $imagT->save($upload_path.'/'.$path.'/t_'.$filename);
                    $imagW->save($upload_path.'/'.$path.'/'.$filename);

                endif;

                return redirect('/admin/artists/all')->with('message', ' Artista editado con éxito.')->with('typealert', 'success');

            endif;

        endif;

    }

    public function getArtistShow($id)
    {

        $cats = Artist::findOrFail($id);
        $categories          = DB::table     ('categories')         ->where('status', 1)         ->get();
        $tags = Tag::where('status', 1)->get();
        $categories0       = DB::table('category_user')->where('user_id', $id)
        ->join('categories', 'category_user.category_id', '=', 'categories.id')->get();
        $tags0       = DB::table('tag_user')->where('user_id', $id)
        ->join('tags', 'tag_user.tag_id', '=', 'tags.id')->get();

        $data = [
            'artist' => $cats,
            'categories' => $categories,
            'tags' => $tags,
            'categories0'            => $categories0,
            'tags0'            => $tags0
        ];
        return view('admin.artists.show', $data);
    }

    public function getArtistDelete($id)
    {
        $user    = Artist::findOrFail($id);
        if($user->status == "100"):

            $user->status = "1";
            $msg = "Usuario activado con éxito.";

        else :

            $user->status = "100";
            $msg = "Usuario suspendido con éxito.";

        endif;

        if($user->save()):

            return back()->with('message', $msg)->with('typealert', 'success');

        endif;
    }


}

