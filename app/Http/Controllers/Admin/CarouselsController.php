<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use Intervention\Image\Facades\Image;
use App\Carousel;
use App\Section;

class CarouselsController extends Controller
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
        $cats = Carousel::orderBy('name', 'ASC')->where('type', 0)->get();
        $active = count($cats);
        $data = [
            'cats' => $cats,
            'active' => $active
        ];
        return view('admin.carousels.home', $data);

    }

    public function postCarouselAdd(Request $request)
    {
        $rules = [

            // 'file'                              => 'required|image|mimes:jpg,png,jpeg|max:6144|dimensions:min_width=1920,min_height=1080,max_width=1920,max_height=1080'

        ];

        $messages = [
            'file.required'                     => 'Seleccione una imagen destacada un carousel.',
            'file.image'                        => 'El archivo no es una imagen.',
            'file.dimensions'                   => 'Se requiere una imagen de dimesiones 1920px x 1080px',
            'file.max'                          => 'La imagen pesa más de 6Mb',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):

            return back()->withErrors($validator)->with('message','Se ha producido un error')->with('typealert','danger');

        else:

            $path = '/Carousels';
            $fileExt = trim($request->file('file')->getClientOriginalExtension());
            $upload_path = Config::get('filesystems.disks.uploads.root');
            $name = Str::slug(str_replace($fileExt, '', $request->file('file')->getClientOriginalName()));
            $filename = rand(1,999).'-'.$name.'.'.$fileExt;
            $file_absolute = $upload_path.'/'.$path.'/'.$filename;

            $c = new Carousel;
            $c ->name                       = $filename;
            $c ->slug                       = $name;
            $c ->file_path                  = $path;
            $c ->file                       = $filename;
            $c ->url                        = e($request->input('url'));
            $c ->type                        = 0;
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

                return back()->with('message', ' Carousel guardado con éxito.')->with('typealert', 'success');

            endif;

        endif;

    }

    public function getCarouselEdit($id)
    {

        $cat                = Carousel::find( $id);
        $data               = ['cat' => $cat];
        return view('admin.carousels.edit', $data);
    }

    public function postCarouselEdit(Request $request, $id)
    {
        if($request->hasFile('file')):
            $rules = [

                'file'                              => 'required|image|mimes:jpg,png,jpeg|max:6144|dimensions:min_width=1920,min_height=1080,max_width=1920,max_height=1080'

            ];
        else:
            $rules = [



            ];
        endif;


        if($request->hasFile('file_mobile')):
            $rules = [

                'file_mobile'                              => 'required|image|mimes:jpg,png,jpeg|max:6144|dimensions:min_width=1080,min_height=1920,max_width=1080,max_height=1920'

            ];
        else:
            $rules = [



            ];
        endif;

        $messages = [
            'file.required'                     => 'Seleccione una imagen destacada un carousel.',
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

            $c = Carousel::findOrFail( $id);
            $imagepp                        = $c->file_path;
            $imagep                         = $c->file;
            $c ->status                    = $request->input('status');
            $c ->type                        = 0;
            if($request->hasFile('file')):

                $path = '/Carousels';
                $fileExt = trim($request->file('file')->getClientOriginalExtension());
                $upload_path = Config::get('filesystems.disks.uploads.root');
                $name = Str::slug(str_replace($fileExt, '', $request->file('file')->getClientOriginalName()));
                $filename = rand(1,999).'-'.$name.'.'.$fileExt;
                $file_absolute = $upload_path.'/'.$path.'/'.$filename;
                $c ->file_path                  = $path;
                $c ->file                       = $filename;
                $c ->name                       = $filename;
                $c ->slug                       = $name;

            endif;



            if( $request->hasFile('file_mobile') ):
                $imagepp                        = $c->file_path;
                $imagep                         = $c->file_mobile;
                $path = '/Carousels';
                $fileExt = trim($request->file('file_mobile')->getClientOriginalExtension());
                $upload_path = Config::get('filesystems.disks.uploads.root');
                $name = Str::slug(str_replace($fileExt, '', $request->file('file_mobile')->getClientOriginalName()));
                $filename = rand(1,999).'-'.$name.'.'.$fileExt;
                $file_absolute = $upload_path.'/'.$path.'/'.$filename;
                $c ->file_path                  = $path;
                $c ->mobil                       = $filename;

            endif;

            $c ->url                        = e($request->input('url'));

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

                return redirect('/admin/carousels')->with('message', ' Carousel guardado con éxito.')->with('typealert', 'success');

            endif;

        endif;

    }

    public function getCarouselDelete($id)
    {
        $c = Carousel::find( $id);

        if($c->delete()):

            return back()->with('message', ' Carousel elminado con éxito.')->with('typealert', 'success');

        endif;
    }



    ////  Galeria  ////////////////////


    public function getHometGallery()
    {
        $cats = Carousel::orderBy('name', 'ASC')->where('type', 1)->get();
        $gallery = Section::where('slug', 'galeria')->first();
            if (!$gallery) {
                $c = new Section;
                $c ->name                       = 'Galeria';
                $c ->slug                       = 'galeria';
                $c->save();
            }
        $data = [
            'cats' => $cats,
            'gallery' => $gallery
        ];
        return view('admin.gallery.home', $data);

    }

    public function postGalleryAdd(Request $request)
    {
        $rules = [

            'file'                              => 'required|image|mimes:jpg,png,jpeg|max:6144|dimensions:min_width=1920,min_height=1080,max_width=1920,max_height=1080'

        ];

        $messages = [
            'file.required'                     => 'Seleccione una imagen de galeria',
            'file.image'                        => 'El archivo no es una imagen. Formatos admitidos (jpg,png,jpeg)',
            'file.dimensions'                   => 'Se requiere una imagen de dimesiones 1920px x 1080px',
            'file.max'                          => 'La imagen pesa más de 6Mb',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):

            return back()->withErrors($validator)->with('message','Se ha producido un error')->with('typealert','danger');

        else:

            $path = '/Gallery';
            $fileExt = trim($request->file('file')->getClientOriginalExtension());
            $upload_path = Config::get('filesystems.disks.uploads.root');
            $name = Str::slug(str_replace($fileExt, '', $request->file('file')->getClientOriginalName()));
            $filename = rand(1,999).'-'.$name.'.'.$fileExt;
            $file_absolute = $upload_path.'/'.$path.'/'.$filename;

            $c = new Carousel;
            $c ->name                       = $filename;
            $c ->slug                       = $name;
            $c ->file_path                  = $path;
            $c ->file                       = $filename;
            $c ->url                        = e($request->input('url'));
            $c ->type                    = 1;
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

                return back()->with('message', ' Galería guardado con éxito.')->with('typealert', 'success');

            endif;

        endif;

    }

    public function getGalleryEdit($id)
    {

        $cat                = Carousel::find( $id);
        $data               = ['cat' => $cat];
        return view('admin.gallery.edit', $data);
    }

    public function postGalleryEdit(Request $request, $id)
    {
        if($request->hasFile('file')):
            $rules = [

                'file'                              => 'required|image|mimes:jpg,png,jpeg|max:6144|dimensions:min_width=1920,min_height=1080,max_width=1920,max_height=1080'

            ];
        else:
            $rules = [



            ];
        endif;
            $messages = [
                'file.required'                     => 'Seleccione una imagen de galeria',
                'file.image'                        => 'El archivo no es una imagen. Formatos admitidos (jpg,png,jpeg)',
                'file.dimensions'                   => 'Se requiere una imagen de dimesiones 1920px x 1080px',
                'file.max'                          => 'La imagen pesa más de 6Mb',
            ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):

            return back()->withErrors($validator)->with('message','Se ha producido un error')->with('typealert','danger')->withInput();

        else:

            $c = Carousel::findOrFail( $id);
            $imagepp                        = $c->file_path;
            $imagep                         = $c->file;
            $c ->status                    = $request->input('status');
            $c ->type                    = 1;

            if($request->hasFile('file')):

                $path = '/Gallery';
                $fileExt = trim($request->file('file')->getClientOriginalExtension());
                $upload_path = Config::get('filesystems.disks.uploads.root');
                $name = Str::slug(str_replace($fileExt, '', $request->file('file')->getClientOriginalName()));
                $filename = rand(1,999).'-'.$name.'.'.$fileExt;
                $file_absolute = $upload_path.'/'.$path.'/'.$filename;
                $c ->file_path                  = $path;
                $c ->file                       = $filename;
                $c ->name                       = $filename;
                $c ->slug                       = $name;

            endif;

            $c ->url   = e($request->input('url'));

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

                return back()->with('message', ' Galería guardado con éxito.')->with('typealert', 'success');

            endif;

        endif;

    }

    public function getGalleryDelete($id)
    {
        $c = Carousel::find( $id);

        if($c->delete()):

            return back()->with('message', ' Galería elminado con éxito.')->with('typealert', 'success');

        endif;
    }




}
