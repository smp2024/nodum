<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;

class ApiController extends Controller
{
    public function getFamilySearch (Request $request)
    {

        $productos = Category::where('name', 'like', '%'.$request->input('texto').'%')
        ->orderBy('name', 'ASC')->get();

        $data = ['cats' => $productos];
        return view('admin.partials.categorySearch', $data);
    }
}
