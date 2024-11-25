<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CategoryController extends Controller
{
    /**
     * Show detail of the category.
     *
     * @param  object  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $category)
    {
        $base = env('FILTERPEDIA_BACKEND_URL', 'http://localhost');
        $res = Http::backend()->get($base . '/product-category/' . $category);
        $category = $res->object();

        return view('categories.show', [
            'category' => $category->data,
            'products' => $category->data->products,
        ]);
    }
}
