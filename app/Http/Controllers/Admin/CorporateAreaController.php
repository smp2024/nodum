<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\CorporateArea;

class CorporateAreaController extends Controller
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
        $corporateareas = CorporateArea::orderBy('orden_dash', 'ASC')->get();

        $data = [
                    'corporateareas' => $corporateareas
                ];

        return view('admin.company.home', $data);

    }

    public function getCompanyEdit($slug)
    {

        $corporatearea  = CorporateArea::where('slug', $slug)->first();
        $data = [
                    'corporatearea' => $corporatearea
                ];

        return view('admin.company.edit', $data);
    }

    public function postCompanyEdit(Request $request, $slug)
    {
        $rules = [


        ];

        $messages = [

            'name.required'                     => 'Se requiere un nombre para editar una familia.'

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):

            return back()->withErrors($validator)->with('message','Se ha producido un error')->with('typealert','danger')->withInput();

        else:

            $c  = CorporateArea::where('slug', $slug)->first();

            if($request->has('company_name')):
                $c ->company_name                       = e($request->input('company_name'));
            endif;

            if($request->has('description')):
                $c ->description                       = e($request->input('description'));
            endif;

            if($request->has('phone')):
                $c ->phone                       = e($request->input('phone'));
            endif;

            if($request->has('phone2')):
                $c ->phone2                     = e($request->input('phone2'));
            endif;

            if($request->has('email')):
                $c ->email                     = e($request->input('email'));
            endif;

            if($request->has('direction')):
                $c ->direction                     = e($request->input('direction'));
            endif;

            if($request->has('status')):
                $c ->status                     = e($request->input('status'));
            endif;

            if($request->hasFile('file') ):
                $imagepp                        = $c->file_path;
                $imagep                         = $c->file;
                $path = '/Company';
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
                    $imagT->resize(150, 150, function($constraint){
                        $constraint->upsize();
                    });
                    $imagW = Image::make($file_absolute);
                    // $imagW->resize(500, 500, function($constraint){
                    //     $constraint->upsize();
                    // });
                    $imagT->save($upload_path.'/'.$path.'/t_'.$filename);
                    $imagW->save($upload_path.'/'.$path.'/'.$filename);
                    Storage::disk('uploads')->delete('/'.$imagepp.'/'.$imagep);
                    Storage::disk('uploads')->delete('/'.$imagepp.'/t_'.$imagep);
                endif;

                return redirect('/admin/company')->with('message', 'Datos guardados con éxito.')->with('typealert', 'success');

            endif;

        endif;

    }
}
