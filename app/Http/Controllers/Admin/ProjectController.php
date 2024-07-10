<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


use App\Project;
use App\Description;
use App\PGallery;



class ProjectController extends Controller
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
        // switch ($status) {

        //     case '1':
        //         $products = Project::where('status', '1')->orderBy('id', 'DESC')->get();
        //         break;
        //     case '0':
        //         $products = Project::where('status', '0')->orderBy('id', 'DESC')->get();
        //         break;
        //     case 'trash':
        //         $products = Project::onlyTrashed()->orderBy('id', 'DESC')->get();
        //         break;

        //     default:
        //         # code...

        //         break;
        // }
        $products = Project::orderBy('id', 'DESC')->get();
        // dd($products);
        $data = ['projects' => $products];
        return view('admin.projects.home', $data);

    }

    public function postProjectAdd(Request $request)
    {
        $input = $request->all();
        $input['slug']= Str::slug($request->input('name'));
        $product    = Project::where('slug', $input['slug'])->first();
        if ($product == null) {
            $rules = [
                'name'                              => 'required',
                'file'                              => 'required',
                'date'                              => 'required',
                'slug'                              => 'slug|unique:projects,slug',
            ];

            $messages = [
                'name.required'                     => 'El nombre de la proyecto es requerido.',
                'file.required'                     => 'Seleccione una imagen destacada de proyecto.',
                'date.required'                     => 'La fecha del proyecto es requerida.',
                'slug.unique'                        => 'El proyecto ya se encuentra registrado',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if($validator->fails()):

                return back()->withErrors($validator)->with('message','Se ha producido un error')->with('typealert','danger')->withInput();

            else:

                $s = Str::slug($request->input('name'));
                $path_ = '/Projects';
                $path = '/Projects/'.$s;
                $fileExt = trim($request->file('file')->getClientOriginalExtension());
                $upload_path = Config::get('filesystems.disks.uploads.root');
                $name = Str::slug(str_replace($fileExt, '', $request->file('file')->getClientOriginalName()));
                $filename = rand(1,999).'-'.$name.'.'.$fileExt;

                $file_url = 'multimedia'.$path.'/t_'.$filename;


                $file_absolute = $upload_path.'/'.$path.'/'.$filename;

                $product = new Project;
                $product->status                = '0';
                $product->module                = 'project';
                $product ->name                 = e($request->input('name'));
                $product ->slug                 = Str::slug($request->input('name'));
                $product ->file_path            = $path_;
                $product ->file                 = $filename;
                //$product ->mobile               = asset($file_url);
                $product ->date                 = e($request->input('date'));
                $product ->sections               = e($request->input('sections'));

                if($product->save()):

                    $p = Project::where('slug', $s)->first();
                    $s = e($request->input('sections'));

                    for ($i=0; $i <= $s; $i++) {
                        $content = new Description();
                        $content->project_id            = $p->id;
                        $content->type                  = 'description';
                        $content ->section              = $i;
                        $content->save();

                        $content = new Description();
                        $content->project_id            = $p->id;
                        $content->type                  = 'video';
                        $content ->section              = $i;
                        $content->save();
                    }

                    if($request->hasFile('file')):
                        $fl = $request->file->storeAs($path,$filename, 'uploads');
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

                    return redirect('/admin/projects/1')->with('message', ' Proyecto guardado con éxito.')->with('typealert', 'success');

                endif;

            endif;
        }else {
            $rules = [
                'name'                              => 'required',
                'file'                              => 'required',
                'date'                              => 'required',
                'slug'                              => 'required|slug|unique:projects,slug',
            ];
             $messages = [
                'slug.required'                     => 'La proyecto ya se encuentra registrado',
                'slug.unique'                        => 'La proyecto ya se encuentra registrado',
            ];
            $validator ='El proyecto ya se encuentra registrado';
            return back()->withErrors($validator)->with('message','Se ha producido un error')->with('typealert','danger')->withInput();

        }

    }

    public function getProjectEdit($id)
    {
        $product        = Project::findOrFail($id);
        $galerias        =PGallery::where('project_id', $product->id)->get();
        $descriptions       = Description::where('project_id', $product->id)->where('type', 'description')->get();
        $videos       = Description::where('project_id', $product->id)->where('type', 'video')->get();
        //dd($videos);
        $data  = [
            'product' => $product,
            'galerias' => $galerias,
            'descriptions' => $descriptions,
            'videos' => $videos
        ];

        return view('admin.projects.edit', $data);
    }

    public function postProjectEdit(Request $request, $id)
    {
        $rules = [
    		'name'                              => 'required'
        ];

        $messages = [
            'name.required'                     => 'El nombre de la proyecto es requerida.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):

            return back()->withErrors($validator)->with('message','Se ha producido un error')->with('typealert','danger')->withInput();

        else:

            $product                        = Project::findOrFail( $id);
            $imagepp                        = $product->file_path;
            $imagep                         = $product->file;
            $product->status                = e($request->input('status'));
            $product->module                = 'project';
            $product ->name                 = e($request->input('name'));
            $product ->slug                 = Str::slug($request->input('name'));

            $product ->date                 = e($request->input('date'));

            $contacto =  request([

                'description'

            ]);

            foreach($contacto as $clave=> $valor){
                for($i=0;$i<count($contacto[$clave]);$i++){
                    $descriptions = Description::where('project_id', $product->id)->where('type', 'description')->where('section', $i)->first();
                    //dd($descriptions);
                    if ($descriptions == null) {
                        $content = new Description();
                        $content->project_id                = $product->id;
                        $content->type                  = 'description';
                        $content ->section                 = $i;
                        $content ->content                 =$contacto[$clave][$i];
                        $content->save();
                    }else {
                        $descriptions ->content                 =$contacto[$clave][$i];
                        $descriptions->save();
                    }
                }
            }



            $contacto =  request([

                'video'

            ]);

            foreach($contacto as $clave=> $valor){
                for($i=0;$i<count($contacto[$clave]);$i++){
                    $descriptions = Description::where('project_id', $product->id)->where('type', 'video')->where('section', $i)->first();
                    //dd($descriptions);
                    if ($descriptions == null) {
                        $content = new Description();
                        $content->project_id                = $product->id;
                        $content->type                  = 'video';
                        $content ->section                 = $i;
                        $content ->content                 =$contacto[$clave][$i];
                        $content->save();
                    }else {
                        $descriptions ->content                 =$contacto[$clave][$i];
                        $descriptions->save();
                    }
                }
            }


            if($request->hasFile('file')):

                $s = Str::slug($request->input('name'));
                $path_ = '/Project';
                $path = '/Project/'.$s;
                $fileExt = trim($request->file('file')->getClientOriginalExtension());
                $upload_path = Config::get('filesystems.disks.uploads.root');
                $name = Str::slug(str_replace($fileExt, '', $request->file('file')->getClientOriginalName()));
                $filename = rand(1,999).'-'.$name.'.'.$fileExt;
                $file_absolute = $upload_path.'/'.$path.'/'.$filename;
                $file_url = 'multimedia'.$path.'/t_'.$filename;
                $product ->mobile               = asset($file_url);
                $product ->file_path            = $path_;
                $product ->file                 = $filename;

            endif;

            if($product->save()):

                if($request->hasFile('file')):
                    $fl = $request->file->storeAs($path, $filename, 'uploads');
                    $imag = Image::make($file_absolute, function($constraint){
                        $constraint->upsize();
                    });
                    $imag->resize(256, 256, function($constraint){
                        $constraint->upsize();
                    });
                    $imag->save($upload_path.'/'.$path.'/t_'.$filename);
                    Storage::disk('uploads')->delete('/'.$imagepp.'/'.$imagep);
                    Storage::disk('uploads')->delete('/'.$imagepp.'/t_'.$imagep);
                endif;

                return back()->with('message', ' Proyecto actualizada con éxito.')->with('typealert', 'success');

            endif;


        endif;

    }


    public function getProjectDelete($id)
    {
        $c = Project::find( $id);

        if($c->delete()):

            return back()->with('message', ' Proyecto elminado con éxito.')->with('typealert', 'success');

        endif;
    }

    public function getProjectRestore($id)
    {
        $product = Project::onlyTrashed()->where('id', $id)->first();
        $product ->deleted_at   = null;

        if ($product->save()):

            return redirect('/admin/project/'.$product->id.'/edit')->with('message', ' El proyecto se restauro correctamente.')->with('typealert', 'success')->withInput();

        endif;

    }

    public function postProjectGalleryAdd($id, $gallery, Request $request)
    {

        $rules = [
    		'file'                        => 'required',
        ];

        $messages = [
            'file.required'               => 'Seleccione una imagen.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):

            return back()->withErrors($validator)->with('message','Se ha producido un error')->with('typealert','danger')->withInput();

        else:
            //dd($gallery);
            $p = Project::find( $id);

            for ($i=0; $i <= $p->sections ; $i++) {

                if($request->hasFile('file')):
                    $new =  DB::table('projects')->orderBy('id', 'DESC')->where('id', $id)->first();
                    $path = '/Project/'.$new->slug;
                    $fileExt = trim($request->file('file')->getClientOriginalExtension());
                    $upload_path = Config::get('filesystems.disks.uploads.root');

                    $name = Str::slug(str_replace($fileExt, '', $request->file('file')->getClientOriginalName()));

                    $filename = rand(1,999).'-'.$name.'.'.$fileExt;
                    $file_absolute = $upload_path.'/'.$path.'/'.$filename;


                    $g =new PGallery;
                    $g->project_id = $id;
                    $g->after = $gallery;
                    $g->file_path = $path;
                    $g->file_name = $filename;


                    if($g->save()):

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

                        return back()->with('message', ' Archivo multimedia guardado con éxito.')->with('typealert', 'success')->withInput();

                    endif;
                endif;
            }

        endif;

    }

    public function getProjectGalleryDelete($id, $gid)
    {
        $g = PGallery::findOrFail( $gid);
        $path = $g->file_path;
        $file = $g->file_name;
        $upload_path = Config::get('filesystems.disks.uploads.root');

        if($g->project_id != $id):

            return back()->with('message', 'La imagen no se puede eliminar.')->with('typealert', 'danger')->withInput();

        else:

            if($g->delete()):

                Storage::disk('uploads')->delete('/'.$path.'/'.$file);
                Storage::disk('uploads')->delete('/'.$path.'/t_'.$file);
                return back()->with('message', 'Imagen borrada con éxito.')->with('typealert', 'success')->withInput();

            endif;

        endif;
    }

    public function postProjectSearch (Request $request)
    {

        $rules = [
    		'search'                              => 'required'
        ];

        $messages = [
            'search.required'                     => 'Se requiere infomacion para buscar.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):

            return back()->withErrors($validator)->with('message','Se ha producido un error')->with('typealert','danger')->withInput();

        else:

            $products = Project::where('name', 'LIKE', '%'.$request->input('search').'%')->where('status', $request->input('status'))->orderBy('id', 'DESC')->get();


            $data = ['projects' => $products];
            return view('admin.projects.search', $data);

        endif;
    }

}
