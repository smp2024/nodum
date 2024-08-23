<?php

namespace App\Http\Controllers\Blog;

use App\Article;
use App\Artist;
use App\Carousel;
use App\Category;
use App\Http\Controllers\Controller;
use App\SubCategory;
use App\Tag;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getCategorySearch(Request $request)
    {
        $categories = Category::where('name', 'like', '%'.$request->input('texto').'%')
        ->orderBy('name', 'ASC')->get();

        $data = ['cats' => $categories];

        return view('admin.partials.categorySearch', $data);
    }

    public function getTagSearch(Request $request)
    {
        $tags = Tag::where('name', 'like', '%'.$request->input('texto').'%')
        ->orderBy('name', 'ASC')->get();

        $data = ['cats' => $tags];

        return view('admin.partials.tagSearch', $data);
    }

    public function findsubcategories(Request $request)
    {
        $search = $request->get('term');
        $result = Category::where('name', 'LIKE', '%'.$search.'%')->get();

        return response()->json($result);
    }

    public function changeCategoryStatus(Request $request)
    {
        $id = $request->input('id');
        $c = Category::findOrFail($id);
        $status = $c->status;
        if ($status == 1) {
            $c->status = 0;
            if ($c->save()) {
                return redirect('/admin/categories')->with('message', ' Categoria desactivada con éxito.')->with('typealert', 'success');
            }
        } else {
            $c->status = 1;
            if ($c->save()) {
                return redirect('/admin/categories')->with('message', ' Categoria activada con éxito.')->with('typealert', 'success');
            }
        }
    }

    public function changeArtistStatus($id)
    {
        $technic = Artist::find($id);
        $technic->status = !$technic->status;
        $technic->save();

        return response()->json(['success' => 'Status change successfully.']);
    }

    public function changeArticleStatus($id)
    {
        $technic = Article::find($id);
        $technic->status = !$technic->status;
        $technic->save();

        return response()->json(['success' => 'Status change successfully.']);
    }

    public function changeTagStatus($id)
    {
        $technic = Tag::find($id);
        $technic->status = !$technic->status;
        $technic->save();

        return response()->json(['success' => 'Status change successfully.']);
    }

    public function changeCarouselStatus($id)
    {
        $technic = Carousel::find($id);
        $technic->status = !$technic->status;
        $technic->save();

        return response()->json(['success' => 'Status change successfully.']);
    }

    public function changeUserStatus($id)
    {
        $technic = User::find($id);
        $technic->status = !$technic->status;
        $technic->save();

        return response()->json(['success' => 'Status change successfully.']);
    }

    // Resto de tus métodos de controlador aquí...

    public function test(Request $request)
    {
        if ($request->isMethod('post') && $request->has('api_key')) {
            return response()->json(['success' => 'Method allowed.']);
        } else {
            return response()->json(['error' => 'Method not allowed.']);
        }
    }

    public function uploadMassiveArticle(Request $request)
    {
        $formData = $request->input('formData');
        // dd($formData);

        return response()->json(['formData' => $request]);
        // $response = $request;
        // echo json_encode($formData);
        // exit;
    }
    public function getTechniquesByCategory(Request $request)
    {
        $categoryId = $request->input('category_id');
        $techniques = SubCategory::where('category_id', $categoryId)->get();

        return response()->json($techniques);
    }
    public function getTechniquesByExtent(Request $request)
    {
        $categoryId = $request->input('category_id');
        $techniques = SubCategory::where('category_id', $categoryId)->get();

        return response()->json($techniques);
    }


    public function articleSearch(Request $request)
    {
        $query = Article::where('status', 1);
        if ($request->has('user_id')) {
            $query->where('user_id',  $request->input('user_id'));
        }
        if ($request->categoria_checkbox) {
            $categories = $request->categoria_checkbox;
            if (is_array($categories)) {
                $query->whereIn('category_id', $categories);
            }
        }
        if ($request->artista_checkbox) {
            $artists = $request->artista_checkbox;
            if (is_array($artists)) {
                $query->whereIn('artist_id', $artists);
            }
        }

        if ($request->tecnica_checkbox) {
            $technics = $request->tecnica_checkbox;
            if (is_array($technics)) {
                $query->whereIn('subcategory_id', $technics);
            }
        }

        if ($request->price_min) {
            $query->where('price_min', '>=', $request->input('price_min'));
        }
        if ($request->price_max) {
            $query->where('price_max', '<=', $request->input('price_max'));
        }
        // if ($request->has('price_min_us')) {
        //     $query->where('price_min_us', '>=', $request->input('price_min_us'));
        // }
        // if ($request->has('price_max_us')) {
        //     $query->where('price_max_us', '<=', $request->input('price_max_us'));
        // }

        $measures = $request->input('measures', []);
        $has1 = in_array(1, $measures);
        $has2 = in_array(2, $measures);
        $has3 = in_array(3, $measures);
        if ($measures) {

            if ($has1 || $has2 || $has3) {
            $query->where(function (Builder $query) use ($has1, $has2, $has3) {
                if ($has1 && !$has2 && !$has3) {
                    // Solo 1: Menor a 40
                    $query->where(function ($query) {
                        $query->whereNull('height')->orWhere('height', '<=', 40);
                    })
                    ->where(function ($query) {
                        $query->whereNull('width')->orWhere('width', '<=', 40);
                    })
                    ->where(function ($query) {
                        $query->whereNull('depth')->orWhere('depth', '<=', 40);
                    });
                } elseif ($has2 && !$has1 && !$has3) {
                    // Solo 2: Entre 40 y 100
                    $query->orWhereBetween('height', [40, 100])
                              ->orWhereNull('height');
                              $query->orWhereBetween('width', [40, 100])
                              ->orWhereNull('width');
                              $query->orWhereBetween('depth', [40, 100])
                              ->orWhereNull('depth');
                } elseif ($has3 && !$has1 && !$has2) {
                    // Solo 3: Mayor a 100
                    $query->where('height', '>=', 100)
                              ->orWhereNull('height');
                              $query->where('width', '>=', 100)
                              ->orWhereNull('width');
                              $query->where('depth', '>=', 100)
                              ->orWhereNull('depth');
                } elseif ($has1 && $has2 && !$has3) {
                    // 1 y 2: Menor a 40 y Entre 40 y 100
                    $query->whereBetween('height', [0, 100])
                    ->orWhereNull('height');
                    $query->whereBetween('width', [0, 100])
                                  ->orWhereNull('width');
                                  $query->whereBetween('depth', [0, 100])
                                  ->orWhereNull('depth');

                } elseif ($has1 && $has3 && !$has2) {
                    // 1 y 3: Menor a 40 y Mayor a 100
                    $query->where(function ($query) {
                        $query->whereNull('height')
                              ->orWhere('height', '<=', 40)
                              ->orWhere('height', '>=', 100);
                    })
                    ->where(function ($query) {
                        $query->whereNull('width')
                              ->orWhere('width', '<=', 40)
                              ->orWhere('width', '>=', 100);
                    })
                    ->where(function ($query) {
                        $query->whereNull('depth')
                              ->orWhere('depth', '<=', 40)
                              ->orWhere('depth', '>=', 100);
                    });
                } elseif ($has2 && $has3 && !$has1) {
                    // 2 y 3: Entre 40 y 100 y Mayor a 100
                    $query->whereBetween('height', [40, 100])
                              ->orWhere('height', '>=', 100)
                              ->orWhereNull('height');
                              $query->whereBetween('width', [40, 100])
                              ->orWhere('width', '>=', 100)
                              ->orWhereNull('width');
                              $query->whereBetween('depth', [40, 100])
                              ->orWhere('depth', '>=', 100)
                              ->orWhereNull('depth');
                    // $query->where(function ($query) {

                    // })
                    // ->where(function ($query) {

                    // })
                    // ->where(function ($query) {

                    // });
                } elseif ($has1 && $has2 && $has3) {
                    // 1, 2 y 3: Menor a 40, Entre 40 y 100, y Mayor a 100
                    $query->where(function ($query) {
                        $query->where(function ($query) {
                            $query->whereNull('height')
                                  ->orWhere('height', '<=', 40);
                        })
                        ->orWhere(function ($query) {
                            $query->whereBetween('height', [40, 100])
                                  ->orWhereNull('height');
                        })
                        ->orWhere(function ($query) {
                            $query->where('height', '>=', 100)
                                  ->orWhereNull('height');
                        });
                    })
                    ->where(function ($query) {
                        $query->where(function ($query) {
                            $query->whereNull('width')
                                  ->orWhere('width', '<=', 40);
                        })
                        ->orWhere(function ($query) {
                            $query->whereBetween('width', [40, 100])
                                  ->orWhereNull('width');
                        })
                        ->orWhere(function ($query) {
                            $query->where('width', '>=', 100)
                                  ->orWhereNull('width');
                        });
                    })
                    ->where(function ($query) {
                        $query->where(function ($query) {
                            $query->whereNull('depth')
                                  ->orWhere('depth', '<=', 40);
                        })
                        ->orWhere(function ($query) {
                            $query->whereBetween('depth', [40, 100])
                                  ->orWhereNull('depth');
                        })
                        ->orWhere(function ($query) {
                            $query->where('depth', '>=', 100)
                                  ->orWhereNull('depth');
                        });
                    });
                }
            });

            }
        }
        $foods = $query->get();
        $i = 0;
        foreach ($foods as  $food) {
            $response[$i]['id'] = $food->id;
            $response[$i]['user_id'] = $food->user_id;
            $response[$i]['category_id'] = $food->category_id;
            $response[$i]['subcategory_id'] = $food->subcategory_id;
            $response[$i]['subcategory_name'] = $food->getSubCategory->name;
            $response[$i]['artist_id'] = $food->artist_id;
            $response[$i]['artist_name'] = $food->getArtist->name.' '.$food->getArtist->lastname;
            $response[$i]['status'] = $food->status;
            $response[$i]['module'] = $food->module;
            $response[$i]['name'] =  ucwords($food->name);
            $response[$i]['slug'] = $food->slug;
            $response[$i]['file_path'] = $food->file_path;
            $response[$i]['file'] = $food->file;
            $response[$i]['description'] = $food->description;
            $response[$i]['sku'] = $food->sku;
            $response[$i]['height'] = $food->height;
            $response[$i]['width'] = $food->width;
            $response[$i]['depth'] = $food->depth;
            $response[$i]['price_min'] = $food->price_min;
            $response[$i]['price_min_us'] = $food->price_min_us;
            $response[$i]['price_max'] = $food->price_max;
            $response[$i]['price_max_us'] = $food->price_max_us;
            $response[$i]['year'] = $food->year;

            ++$i;
        }

        return response()->json($response);

    }
}
