<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Artist;
use App\Category;
use App\Description;
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

        $tags = Tag::where('status', 1)->get();

        $data = [
            'cats' => $cats,
            'categories' => $categories,
            'tags' => $tags,
            'artists' => $artists,
        ];

        return view('admin.article.add', $data);
    }

    public function postArticleAdd(Request $request)
    {
        $input = $request->all();
        $input['slug'] = Str::slug($request->input('name'));
        // $product = Article::where('slug', $input['slug'])->first();
        // if ($product == null) {
        //     $rules = [
        //         'name' => 'required',
        //         // 'file'                              => 'required',
        //        // 'description'                              => 'required',
        //        // 'price'                              => 'required',
        //        // 'priceMax'                              => 'required',
        //         'height' => 'required',
        //         'width' => 'required',
        //         'technic' => 'required',
        //         //'slug' => 'slug|unique:articles,slug',
        //     ];

        //     $messages = [
        //         'name.required' => 'El nombre del artículo es requerido.',
        //         'file.required' => 'Seleccione una imagen destacada del artículo.',
        //         'description.required' => 'La descripción del artículo es requerida.',
        //         'price.required' => 'El precio del artículo es requerido.',
        //        // 'priceMax.required'                     => 'El precio maximo del artículo es requerido.',

        //         'height.required' => 'El Alto del artículo es requerido.',
        //         'width.required' => 'El Ancho del artículo es requerido.',
        //         'technic.required' => 'Se requiere de una técnica para crear el articulo.',

        //         //'slug.unique' => 'El artículo ya se encuentra registrado',
        //     ];

        //     $validator = Validator::make($request->all(), $rules, $messages);

        //     if ($validator->fails()) {
        //         return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withInput();
        //     } else {
                $s = Str::slug($request->input('name'));
                $artist_id = $request->input('artist_id');
                $path_ = 'Article';
                $path = 'Article/'.$s;
                $product = new Article();
                $product->status = '0';
                $product->user_id = Auth::id();
                $product->category_id = $request->input('category_id');
                $titleletter = strtoupper(substr($s, 0, 1));
                $artist = Artist::findOrFail($artist_id);
                $artisletter = strtoupper(substr($artist->slug, 0, 1));
                $numbers = rand(10000, 99999);
                $sku = $artisletter.$titleletter.$numbers;
                $product->sku = $sku;
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


                $product->year = $request->input('year');
                $product->artist_id = $request->input('artist_id');

                $product->name = e($request->input('name'));
                $product->slug = Str::slug($request->input('name'));
                $product->category_id = $request->input('category_id');
                $product->subcategory_id = $request->input('subcategory_id');
                // $sc = SubCategory::where('slug', $techname)->where('category_id', $category_id)->first();
                // if ($sc == null) {
                //     $c = new SubCategory();
                //     $c->name = e($request->input('technic'));
                //     $c->slug = Str::slug($request->input('technic'));
                //     $c->category_id = $request->input('category_id');
                //     $c->status = 1;

                //     if ($c->save()) {
                //         $product->subcategory_id = $c->id;
                //     }
                // } else {
                //     $product->subcategory_id = $sc->id;
                // }


                if ($request->hasFile('file')) {
                    $fileExt = trim($request->file('file')->getClientOriginalExtension());
                    $upload_path = Config::get('filesystems.disks.uploads.root');
                    $name = Str::slug(str_replace($fileExt, '', $request->file('file')->getClientOriginalName()));
                    $filename = rand(1, 999).'-'.$name.'.'.$fileExt;
                    $file_url = 'multimedia'.$path.'/t_'.$filename;
                    $file_absolute = $upload_path.'/'.$path.'/'.$filename;
                    $product->file_path = $path_;
                    $product->file = $filename;
                }

                $product->height = e($request->input('height'));
                $product->width = e($request->input('width'));
                $product->depth = e($request->input('depth'));

                if ($product->save()) {
                    $articleId = $product->id;

                    $articleTag = Article::findOrFail($articleId);
                    $articleTag->tags()->sync($request->get('tags'));
                    $articleTag->save();

                    if ($request->hasFile('file')) {
                        $fl = $request->file->storeAs($path, $filename, 'uploads');
                        $imagT = Image::make($file_absolute);
                        $imagT->resize(256, 256, function ($constraint) {
                            $constraint->upsize();
                        });
                        $imagW = Image::make($file_absolute);
                        // $imagW->resize(1920, 1080, function ($constraint) {
                        //     $constraint->upsize();
                        // });
                        $imagT->save($upload_path.'/'.$path.'/t_'.$filename);
                        $imagW->save($upload_path.'/'.$path.'/'.$filename);
                    }

                    return redirect('/admin/articles/all')->with('message', ' Artículo guardado con éxito.')->with('typealert', 'success');
                 }
        //     }
        // } else {
        //     $validator = 'El artículo ya se encuentra registrado';

        //     return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withInput();
        // }
    }

    public function getArticleEdit($id)
    {
        $ArticleTags = DB::table('article_tag')->where('article_id', $id)->get();

        $product = Article::findOrFail($id);
        $categories = Category::where('status', 1)->orderBy('name', 'ASC')->get();
        $clasi = [] + $categories->pluck('name', 'id')->toArray();
        $tecnics = SubCategory::where('category_id', $product->category_id)->where('status', 1)->orderBy('name', 'ASC')->get();
        $tecnics_ = [] + $tecnics->pluck('name', 'id')->toArray();

        $cats = Article::where('module', 'articulos')->pluck('name', 'id');
        $categories = Category::where('status', 1)->get();
        $tags = Tag::where('status', 1)->get();
        $foods0 = DB::table('article_tag')->where('article_id', $id) ->join('tags', 'article_tag.tag_id', '=', 'tags.id')->get();
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
            'tags' => $tags,
            'articleTags' => $ArticleTags,
            'foods0' => $foods0,
            'artists' => $artists,
            'technic' => $technic,

        ];

        return view('admin.article.edit', $data);
    }

    public function postArticleEdit(Request $request, $id)
    {
        // dd($request);
        if ($request->hasFile('file')) {
            $rules = [
     //           'file' => 'required|image|mimes:jpg,png,jpeg|max:6144|dimensions:min_width=1920,min_height=1080,max_width=1920,max_height=1080',
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
            $s = Str::slug($request->input('name'));

            $artist_id = $request->input('artist_id');
            $titleletter = strtoupper(substr($s, 0, 1));
            $artist = Artist::findOrFail($artist_id);
            $artisletter = strtoupper(substr($artist->slug, 0, 1));
            $numbers = rand(10000, 99999);
            $sku = $artisletter.$titleletter.$numbers;
            $path_ = 'Article';
            $path = 'Article/'.$sku;
            $product = Article::findOrFail($id);
            $carpeta = $product->file_path;

            $product->sku = $sku;
            if ($path != $carpeta) {

                $upload_path = Config::get('filesystems.disks.uploads.root');
                $file_absolute = $upload_path.'Article/'.$s;

                if (File::exists($file_absolute)) {
                    $nuevaRutaCarpeta = $upload_path.'Article/'.$sku;

                    File::move($file_absolute, $nuevaRutaCarpeta);

                }
            }
            $product->status = $request->input('status');

            $exchangeRate = getExchangeRate();
            // Eliminar las comas
            $price_min_ = str_replace(',', '', $request->input('price_min'));
            $price_max_ = str_replace(',', '', $request->input('price_max'));
            $price_min_us_ = str_replace(',', '', $request->input('price_min_us'));
            $price_max_us_ = str_replace(',', '', $request->input('price_max_us'));

            $price_min = number_format((float)$price_min_, 2, '.', '');
            $price_max = number_format((float)$price_max_, 2, '.', '');
            $price_min_us = number_format((float)$price_min_us_, 2, '.', '');
            $price_max_us = number_format((float)$price_max_us_, 2, '.', '');

            // dd($price_min);

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
            $product->tags()->sync($request->get('tags'));

            $product->name = e($request->input('name'));
            $product->slug = Str::slug($request->input('name'));
            $product->category_id = $request->input('category_id');
            $product->subcategory_id = $request->input('technic');


            if ($request->hasFile('file')) {
                $fileExt = trim($request->file('file')->getClientOriginalExtension());
                $upload_path = Config::get('filesystems.disks.uploads.root');
                $name = Str::slug(str_replace($fileExt, '', $request->file('file')->getClientOriginalName()));
                $filename = rand(1, 999).'-'.$name.'.'.$fileExt;
                $file_url = 'multimedia'.$path.'/t_'.$filename;
                $file_absolute = $upload_path.'/'.$path.'/'.$filename;
                $product->file_path = $path_;
                $product->file = $filename;
            }

            if ($product->save()) {
                if ($request->hasFile('file')) {
                    $fl = $request->file->storeAs($path, $filename, 'uploads');
                    $imagT = Image::make($file_absolute);
                    $imagT->resize(256, 256, function ($constraint) {
                        $constraint->upsize();
                    });
                    $imagW = Image::make($file_absolute);
                    // $imagW->resize(1920, 1080, function ($constraint) {
                    //     $constraint->upsize();
                    // });
                    $imagT->save($upload_path.'/'.$path.'/t_'.$filename);
                    $imagW->save($upload_path.'/'.$path.'/'.$filename);
                }

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

    public function postArticleSearch(Request $request)
    {
        $rules = [
            'search' => 'required',
        ];

        $messages = [
            'search.required' => 'Se requiere infomacion para buscar.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withInput();
        } else {
            $products = Article::where('name', 'LIKE', '%'.$request->input('search').'%')->where('status', $request->input('status'))->orderBy('id', 'DESC')->get();

            $data = ['article' => $products];

            return view('admin.article.search', $data);
        }
    }
}
