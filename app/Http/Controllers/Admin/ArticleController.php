<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Artist;
use App\Category;
use App\Http\Controllers\Controller;
use App\SubCategory;
use App\Tag;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;


class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user.status');
        $this->middleware('isadmin');
    }

    public function getHome($status)
    {
        $id = Auth::id();
        $user           = User::where('id',$id)->first();

        // dd($user->role);
        if ($user->role == 2) {

            $artist           = Artist::where('user_id',$id)->first();
            $products = Article::where('artist_id',  $artist->id)->orderBy('id', 'DESC')->get();
        } else {
            switch ($status) {
                case 'all':
                    $products = Article::orderBy('id', 'DESC')->get();
                    break;
                case 'borrador':
                    $products = Article::where('status', '0')->where('module', 'articulos')->orderBy('id', 'DESC')->get();
                    break;
                case 'trash':
                    $products = Article::onlyTrashed()->where('module', 'articulos')->orderBy('id', 'DESC')->get();
                    break;

                default:
                    // $products = Article::where('category_id', $status)->orderBy('id', 'DESC')->get();
                    break;
            }
        }


        $categories = DB::table('categories')->where('status', 1)->get();
        $data = [
            'articles' => $products,
            'categories' => $categories,
        ];

        return view('admin.article.home', $data);
    }

    public function getArticleAdd()
    {
        $cats = Article::where('module', 'articulos')->pluck('name', 'id');
        $categories = Category::where('status', 1)->get();
        $artists = Artist::where('status', 1)->orderBy('name', 'ASC')->get();

        $data = [
            'cats' => $cats,
            'categories' => $categories,
            'artists' => $artists,
        ];

        return view('admin.article.add', $data);
    }

    public function postArticleAdd(Request $request)
    {

        $rules = [
            // 'file' => 'required|image|mimes:jpg,png,jpeg|max:6144|dimensions:min_width=1920,min_height=1080,max_width=1920,max_height=1080',
        ];

        $messages = [
            'name.required' => 'El nombre del artículo es requerido.',
            'file.required' => 'Seleccione una imagen destacada del artículo.',
            'description.required' => 'La descripción del artículo es requerida.',
            'price.required' => 'El precio del artículo es requerido.',
            'height.required' => 'El Alto del artículo es requerido.',
            'width.required' => 'El Ancho del artículo es requerido.',
            'technic.required' => 'Se requiere de una técnica para crear el articulo.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withInput();
        } else {
            $sku =$request->input('sku');
            $path = 'Article/'.$sku;
            $product = new Article();
            $product->status = '0';
            $product->user_id = Auth::id();
            $product->year = $request->input('year');
            $product->artist_id = $request->input('artist_id');
            $product->name = e($request->input('name'));
            $product->slug = Str::slug($request->input('name'));
            $product->category_id = $request->input('category_id');
            $product->subcategory_id = $request->input('subcategory_id');
            $product->height = e($request->input('height'));
            $product->width = e($request->input('width'));
            $product->depth = e($request->input('depth'));

            $exchangeRate = getExchangeRate();

            if ($request->input('price_min') && $request->input('price_max')  != null && $request->input('price_min_us') && $request->input('price_max_us')  == null) {
                $product->price_min = $request->input('price_min');
                $product->price_max = $request->input('price_max');
                $product->price_min_us = ($request->input('price_min') / $exchangeRate);
                $product->price_max_us = ($request->input('price_max') / $exchangeRate);
            } else if ($request->input('price_min_us') && $request->input('price_max_us')  != null && $request->input('price_min') && $request->input('price_max')  == null) {
                $product->price_min_us = $request->input('price_min_us');
                $product->price_max_us = $request->input('price_max_us');
                $product->price_min = ($request->input('price_min_us') * $exchangeRate);
                $product->price_max = ($request->input('price_max_us') * $exchangeRate);
            } else {
                $product->price_min_us = $request->input('price_min_us');
                $product->price_max_us = $request->input('price_max_us');
                $product->price_min = $request->input('price_min');
                $product->price_max = $request->input('price_max') ;
            }

            if ($request->hasFile('file')) {
                $fileExt = trim($request->file('file')->getClientOriginalExtension());
                $upload_path = Config::get('filesystems.disks.uploads.root');
                $name = Str::slug(str_replace($fileExt, '', $request->file('file')->getClientOriginalName()));
                $filename = rand(1, 999).'-'.$name.'.'.$fileExt;
                $file_url = 'multimedia'.$path.'/t_'.$filename;
                $file_absolute = $upload_path.'/'.$path.'/'.$filename;
                $product->file_path = $path;
                $product->file = $filename;
                $fl = $request->file->storeAs($path, $filename, 'uploads');
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

            if ($product->save()) {

                return redirect('/admin/articles/all')->with('message', ' Obra guardada con éxito.')->with('typealert', 'success');
            }
        }

    }

    public function getArticleEdit($id)
    {
        $product = Article::findOrFail($id);
        $categories = Category::where('status', 1)->orderBy('name', 'ASC')->get();
        $clasi = [] + $categories->pluck('name', 'id')->toArray();
        $tecnics = SubCategory::where('category_id', $product->category_id)->where('status', 1)->orderBy('name', 'ASC')->get();
        $tecnics_ = [] + $tecnics->pluck('name', 'id')->toArray();

        $cats = Article::where('module', 'articulos')->pluck('name', 'id');
        $categories = Category::where('status', 1)->get();
        $technic = SubCategory::where('status', 1)->orderBy('name', 'ASC')->get();

        $artists_ = Artist::where('status', 1)
        ->orderBy('name', 'ASC')
        ->get(['id', 'name', 'lastname']);
        $artists = $artists_->mapWithKeys(function ($artist) {
            return [$artist->id => $artist->name . ' ' . $artist->lastname];
        })->toArray();

        $data = [
            'cats' => $cats,
            'product' => $product,
            'subclasi' => $clasi,
            'tecnicas' => $tecnics_,
            'categories' => $categories,
            'artists' => $artists,
            'technic' => $technic,

        ];

        return view('admin.article.edit', $data);
    }

    public function postArticleEdit(Request $request, $id)
    {

        if ($request->hasFile('file')) {
            $rules = [
                //'file' => 'required|image|mimes:jpg,png,jpeg|max:6144|dimensions:min_width=1920,min_height=1080,max_width=1920,max_height=1080',
            ];
        } else {
            $rules = [
            ];
        }

        $messages = [
            'name.required' => 'El nombre del producto es requerido.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withInput();
        } else {

            $product = Article::findOrFail($id);
            $sku = $product->sku;
            $product->status = $request->input('status');

            $exchangeRate = getExchangeRate();
            $price_min_ = str_replace(',', '', $request->input('price_min'));
            $price_max_ = str_replace(',', '', $request->input('price_max'));
            $price_min_us_ = str_replace(',', '', $request->input('price_min_us'));
            $price_max_us_ = str_replace(',', '', $request->input('price_max_us'));

            $price_min = number_format((float)$price_min_, 2, '.', '');
            $price_max = number_format((float)$price_max_, 2, '.', '');
            $price_min_us = number_format((float)$price_min_us_, 2, '.', '');
            $price_max_us = number_format((float)$price_max_us_, 2, '.', '');

            if ($request->input('price_min') && $request->input('price_max')  != null && $request->input('price_min_us') && $request->input('price_max_us')  == null) {
                $product->price_min = $price_min;
                $product->price_max = $price_max;
                $product->price_min_us = ($price_min / $exchangeRate);
                $product->price_max_us = ($price_max / $exchangeRate);
            } else if ($request->input('price_min_us') && $request->input('price_max_us')  != null && $request->input('price_min') && $request->input('price_max')  == null) {
                $product->price_min_us = $price_min_us;
                $product->price_max_us = $price_max_us;
                $product->price_min = ($price_min_us * $exchangeRate);
                $product->price_max = ($price_max_us * $exchangeRate);
            } else {
                $product->price_min_us = $price_min_us;
                $product->price_max_us = $price_max_us;
                $product->price_min = $price_min;
                $product->price_max = $price_max ;
            }

            $product->artist_id = $request->input('artist_id');
            $product->year = $request->input('year');

            $product->height = e($request->input('height'));
            $product->width = e($request->input('width'));
            $product->depth = e($request->input('depth'));

            $product->name = e($request->input('name'));
            $product->slug = Str::slug($request->input('name'));
            $product->category_id = $request->input('category_id');
            $product->subcategory_id = $request->input('technic');


            if ($request->hasFile('file')) {

                $path = 'Article/'.$sku;
                $fileExt = trim($request->file('file')->getClientOriginalExtension());
                $upload_path = Config::get('filesystems.disks.uploads.root');
                $name = Str::slug(str_replace($fileExt, '', $request->file('file')->getClientOriginalName()));
                $filename = rand(1, 999).'-'.$name.'.'.$fileExt;
                $file_url = 'multimedia'.$path.'/t_'.$filename;
                $file_absolute = $upload_path.'/'.$path.'/'.$filename;
                $product->file_path = $path;
                $product->file = $filename;
                $fl = $request->file->storeAs($path, $filename, 'uploads');
                $imagT = Image::make($file_absolute);
                $imagT->resize(256, 256, function ($constraint) {
                    $constraint->upsize();
                });
                $imagW = Image::make($file_absolute);
                $imagW->resize(1920, 1080, function ($constraint) {
                    $constraint->upsize();
                });
                $imagT->save($upload_path.'/'.$path.'/t_'.$filename);
                $imagW->save($upload_path.'/'.$path.'/'.$filename);
            }

            if ($product->save()) {

                return back()->with('message', ' Artículo actualizado con éxito.')->with('typealert', 'success');
            }
        }
    }

    public function getArticleDelete($id)
    {
        $product = Article::find($id);

        if ($product->delete()) {
            return back()->with('message', ' Artículo enviado con éxito a la papeplera.')->with('typealert', 'success');
        }
    }

    public function getArticleRestore($id)
    {
        $product = Article::onlyTrashed()->where('id', $id)->first();
        $product->deleted_at = null;

        if ($product->save()) {
            return redirect('/admin/articulos/'.$product->id.'/edit')->with('message', ' El artículo se restauro correctamente.')->with('typealert', 'success')->withInput();
        }
    }

}
