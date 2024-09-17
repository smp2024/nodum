<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
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

    public function getHome()
    {
        $Projects = Project::orderBy('id', 'DESC')->get();
        $data = ['projects' => $Projects];
        return view('admin.projects.home', $data);

    }

    public function postProjectAdd(Request $request)
    {
        $rules = [
            // 'file' => 'required|image|mimes:jpg,png,jpeg|max:6144|dimensions:min_width=1080,min_height=1920,max_width=1080,max_height=1920',
            // 'pdf'  => 'required|mimes:pdf|max:10000'
        ];

        $messages = [
            'file.required' => 'Seleccione una imagen destacada de proyecto.',
            'file.image'    => 'El archivo no es una imagen.',
            'file.dimensions' => 'Se requiere una imagen de dimensiones 1080px x 1920px',
            'file.max'      => 'La imagen pesa más de 6Mb',
            'pdf.required'  => 'Seleccione un PDF de proyecto.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger');
        }

        $fileExt = $request->file('file')->getClientOriginalExtension();
        $pdfExt = $request->file('pdf')->getClientOriginalExtension();
        $nameFile = Str::slug(pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_FILENAME));
        $namePDF = Str::slug(pathinfo($request->file('pdf')->getClientOriginalName(), PATHINFO_FILENAME));
        $project_name = Str::slug($request->input('name'));

        $path = 'Projects/' . $project_name;
        $upload_path = Config::get('filesystems.disks.uploads.root');
        $filename = $nameFile . '.' . $fileExt;
        $pdfname = $namePDF . '.' . $pdfExt;

        $project = new Project;
        $project->user_id = Auth::id();
        $project->status = 0;
        $project->module = 'project';
        $project->name = e($request->input('name'));
        $project->slug = Str::slug($request->input('name'));
        $project->file_path = $path;
        $project->file = $filename;
        $project->pdf = $pdfname;

        if ($project->save()) {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $file->storeAs($path, $filename, 'uploads');

                $imagePath = $upload_path . '/' . $path . '/' . $filename;

                $imageT = Image::make($imagePath);
                $imageT->fit(256, 256, function($constraint) {
                    $constraint->upsize();
                });
                $imageT->save($upload_path . '/' . $path . '/t_' . $filename);

                $imageW = Image::make($imagePath);
                $imageW->resize(1080, 1920, function($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $imageW->save($imagePath);
            }

            if ($request->hasFile('pdf')) {
                $request->file('pdf')->storeAs($path, $pdfname, 'uploads');
            }

            return back()->with('message', 'Proyecto guardado con éxito.')->with('typealert', 'success');
        }

        return back()->with('message', 'Se ha producido un error al guardar el proyecto.')->with('typealert', 'danger');
    }


    public function getProjectEdit($id)
    {
        $product        = Project::findOrFail($id);
        $data  = [
            'product' => $product,
        ];

        return view('admin.projects.edit', $data);
    }


    public function postProjectEdit(Request $request, $id)
    {
        $project = Project::find($id);

        if (!$project) {
            return back()->with('message', 'Proyecto no encontrado.')->with('typealert', 'danger');
        }

        $rules = [
            'file' => 'nullable|image|mimes:jpg,png,jpeg|max:6144|dimensions:min_width=1080,min_height=1920,max_width=1080,max_height=1920',
            'pdf'  => 'nullable|mimes:pdf|max:10000'
        ];

        $messages = [
            'file.image' => 'El archivo no es una imagen.',
            'file.dimensions' => 'Se requiere una imagen de dimensiones 1080px x 1920px',
            'file.max' => 'La imagen pesa más de 6Mb',
            'pdf.mimes' => 'El archivo no es un PDF válido.',
            'pdf.max' => 'El PDF pesa más de 10Mb'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger');
        }
        $oldProjectName = $project->slug;
        $newProjectName = Str::slug($request->input('name'));
        $upload_path = Config::get('filesystems.disks.uploads.root');
        $oldPath = 'Projects/' . $oldProjectName;
        $path = 'Projects/' . $newProjectName;

        $project->name = e($request->input('name'));
        $project->slug = Str::slug($request->input('name'));
        $project->file_path = $path;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileExt = $file->getClientOriginalExtension();
            $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $fileExt;

            $oldFilePath = $upload_path . '/' . $project->file_path . '/' . $project->file;
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }

            $file->storeAs($path, $filename, 'uploads');

            $imagePath = $upload_path . '/' . $path . '/' . $filename;
            $imageT = Image::make($imagePath);
            $imageT->fit(256, 256, function($constraint) {
                $constraint->upsize();
            });
            $imageT->save($upload_path . '/' . $path . '/t_' . $filename);

            $imageW = Image::make($imagePath);
            $imageW->resize(1080, 1920, function($constraint) {
                $constraint->upsize();
            });
            $imageW->save($imagePath);

            $project->file = $filename;
        }

        if ($request->hasFile('pdf')) {
            $pdf = $request->file('pdf');
            $pdfExt = $pdf->getClientOriginalExtension();
            $pdfname = Str::slug(pathinfo($pdf->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $pdfExt;

            $oldPdfPath = $upload_path . '/' . $project->file_path . '/' . $project->pdf;
            if (file_exists($oldPdfPath)) {
                unlink($oldPdfPath);
            }

            $pdf->storeAs($path, $pdfname, 'uploads');

            $project->pdf = $pdfname;
        }

        if ($oldPath !== $path) {
            Storage::disk('uploads')->move($oldPath, $path);
        }


        $project->save();

        return back()->with('message', 'Proyecto actualizado con éxito.')->with('typealert', 'success');
    }

    public function getProjectDelete($id)
    {
        $c = Project::find( $id);

        if($c->delete()):

            return back()->with('message', ' Proyecto elminado con éxito.')->with('typealert', 'success');

        endif;
    }

}
