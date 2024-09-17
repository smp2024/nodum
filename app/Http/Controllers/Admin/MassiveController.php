<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Artist;
use App\Category;
use App\Http\Controllers\Controller;
use App\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;

class MassiveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user.status');
        $this->middleware('isadmin');
    }

    public function getHome()
    {
        $csvData = session('csvData', []);
        $data = [
            'csvData' => $csvData,
        ];

        return view('admin.massive.home', $data);
    }

    public function uploadCsv(Request $request)
    {

        $exchangeRate = getExchangeRate();

        $articulos = Article::get();

        foreach ($articulos as  $articulo) {
            $product = Article::findOrFail($articulo->id);
            $product->price_min_us = ($articulo->price_min / $exchangeRate);
            $product->price_max_us = ($articulo->price_max / $exchangeRate);
            $product->save();
        }




        $request->validate([
            'file' => 'required|mimes:csv,txt,xls,xlsx|max:2048',
        ]);

        $file = $request->file('file');
        $data = Excel::toArray([], $file)[0]; // Lee el primer sheet del archivo Excel

        $headers = array_shift($data);

        $data = [
            'data' => $data,
            'headers' => $headers,
        ];

        return view('admin.massive.home', $data);
    }

    // Función para eliminar caracteres especiales
    public function normalizeString($str)
    {
        return iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $str);
    }

    public function uploadMassiveArticle(Request $request)
    {
        $data = json_decode($request->input('data'), true); // Obtener todos los datos del formulario
        $i = 0;
        // dd($data);
        foreach ($data as $datos) {
            $slug = Str::slug($datos[1]);
            $articuloExistente = Article::where('slug', $slug)->first();

            if ($articuloExistente) {

                // Si el artículo ya existe, actualizar sus datos
                $product = Article::findOrFail($articuloExistente->id);

                $product->user_id = Auth::id();

                $artista = Str::slug($datos[0]);
                $user = Artist::where('slug',$artista)->first();
                $product->artist_id = $user->id;

                $product->name = $datos[1];
                $product->slug = Str::slug($datos[1]);

                $categoria = Str::slug($datos[2]);
                $cat = Category::where('slug',$categoria)->first();
                $product->category_id = $cat->id;

                $tecnica = Str::slug($datos[3]);
                $tec = SubCategory::where('slug',$tecnica)->first();
                $product->subcategory_id = $tec->id;

                $product->height = $datos[4];
                $product->width = $datos[5];
                $product->depth = $datos[6];

                $product->year = $datos[7];

                if ($datos[10] == 'MX') {

                    $exchangeRate = getExchangeRate();
                    $product->price_min = $datos[8];
                    $product->price_max = $datos[9];

                    $product->price_min_us = ($datos[8] / $exchangeRate);
                    $product->price_max_us = ($datos[9] / $exchangeRate);

                } else {

                    $exchangeRate = getExchangeRate();
                    $product->price_min_us = $datos[8];
                    $product->price_max_us = $datos[9];

                    $product->price_min = ($datos[8] * $exchangeRate);
                    $product->price_max = ($datos[9] * $exchangeRate);

                }

                if ($datos[11] == 'Activo') {
                    $product->status = '1';
                } else {
                    $product->status = '0';
                }

                $product->sku = $datos[12];


                $product->save();
            } else {
                // Si el artículo no existe, crear un nuevo artículo
                $product = new Article();

                $product->user_id = Auth::id();

                $artista = Str::slug($datos[0]);
                $user = Artist::where('slug',$artista)->first();
                $product->artist_id = $user->id;

                $product->name = $datos[1];
                $product->slug = Str::slug($datos[1]);

                $categoria = Str::slug($datos[2]);
                $cat = Category::where('slug',$categoria)->first();
                $product->category_id = $cat->id;

                $tecnica = Str::slug($datos[3]);
                $tec = SubCategory::where('slug',$tecnica)->first();
                $product->subcategory_id = $tec->id;

                $product->height = $datos[4];
                $product->width = $datos[5];
                $product->depth = $datos[6];

                $product->year = $datos[7];

                if ($datos[10] == 'MX') {

                    $exchangeRate = getExchangeRate();
                    $product->price_min = $datos[8];
                    $product->price_max = $datos[9];

                    $product->price_min_us = ($datos[8] / $exchangeRate);
                    $product->price_max_us = ($datos[9] / $exchangeRate);

                } else {

                    $exchangeRate = getExchangeRate();
                    $product->price_min_us = $datos[8];
                    $product->price_max_us = $datos[9];

                    $product->price_min = ($datos[8] * $exchangeRate);
                    $product->price_max = ($datos[9] * $exchangeRate);

                }

                if ($datos[11] == 'Activo') {
                    $product->status = '1';
                } else {
                    $product->status = '0';
                }

                $product->sku = $datos[12];


                $product->save();
            }
            ++$i;
        }
        return redirect('/admin/massive_modifications')->with('message', 'Datos guardados correctamente.')->with('typealert', 'success');
    }

    public function uploadAvatars(Request $request)
    {
        // $rules = [

        //     'images.*'              => 'required|image|mimes:jpg,png,jpeg|max:2048'

        // ];

        // $messages = [
        //     'images.*.required'     => 'Debe seleccionar al menos una imagen.',
        //     'images.*.image'        => 'El archivo no es una imagen.',
        //     'images.*.mimes'        => 'Solo se permiten imágenes en formato jpeg, png, jpg.',
        //     'images.*.max'          => 'La imagen no puede tener más de 2MB.',
        // ];
        // $validator = Validator::make($request->all(), $rules, $messages);

        // if ($validator->fails()) {
        //     return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger');
        // }
        $images = $request->file('images');

        $results = [];
        if ($request->isMethod('POST')) {
            foreach ($images as $image) {
                $fileExt = trim($image->getClientOriginalExtension());
                $upload_path = Config::get('filesystems.disks.uploads.root');
                $name = Str::slug(str_replace($fileExt, '', $image->getClientOriginalName()));
                $path = 'Article/'.$name;
                $filename = $name.'.'.$fileExt;
                $file_url = 'multimedia'.$path.'/t_'.$filename;
                $file_absolute = $upload_path.'/'.$path.'/'.$filename;

                $articuloExistente = Article::where('sku', $name)->first();
                $product = Article::findOrFail($articuloExistente->id);

                $product->file_path = $path;
                $product->file = $filename;

                $product->save();

                $fl = $image->storeAs($path, $filename, 'uploads');
                $imagT = Image::make($file_absolute);
                $imagT->fit(256, 256, function ($constraint) {
                    $constraint->upsize();
                });
                $imagW = Image::make($file_absolute);
                $imagW->resize(1920, 1080, function ($constraint) {
                    $constraint->upsize();
                });
                $imagT->save($upload_path.'/'.$path.'/t_'.$filename);
                $imagW->save($upload_path.'/'.$path.'/'.$filename);

            }

            return back()->with('message', 'Se actualizaron las imágenes')->with('typealert', 'success');
        } else {
            return back()->with('message', 'Error de actualización, intentar nuevamente.')->with('typealert', 'danger');
        }
    }



}
