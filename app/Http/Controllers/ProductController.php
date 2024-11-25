<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\Pool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $base = env('FILTERPEDIA_BACKEND_URL', 'http://localhost');

        $res = Http::pool(fn(Pool $pool) => [
            $pool->as('products')->get($base . '/products'),
            $pool->as('categories')->get($base . '/product-category'),
        ]);

        $products = $res['products']->object();
        $categories = $res['categories']->object();

        return view('products.index', [
            'products' => $products->data,
            'categories' => $categories->data,
        ]);
    }

    /**
     * Show detail of the product.
     *
     * @param  object  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $product)
    {
        $base = env('FILTERPEDIA_BACKEND_URL', 'http://localhost');
        $res = Http::backend()->get($base . '/products/' . $product);
        $product = $res->object();

        $chat = route('whatsapp', [
            'phone' => '6285773548687',
            'text' => 'Hello Admin, Saya ingin bertanya tentang product ' . $product->data->product_name,
        ]);

        return view('products.show', [
            'product' => $product->data,
            'thumbnails' => $product->image,
            'similars' => $product->product_serupa,
            'chat' => $chat,
        ]);
    }

    /**
     * Like the product.
     *
     * @param  object  $request
     * @return \Illuminate\Http\Response
     */
    public function like(Request $request)
    {
        $user = session()->get('user');
        if (!$user) return redirect()->route('auth.login', [
            'redirect' =>  $request->session()->previousUrl(),
        ]);

        $base = env('FILTERPEDIA_BACKEND_URL', 'http://localhost');
        $res = Http::backend()->post($base . '/liked/product', [
            'product_id' => $request->product_id,
        ]);

        if ($res->successful()) session()->flash('success', 'Berhasil disukai!');
        else session()->flash('error', 'Gagal disukai! ' . $res->json('message'));

        return redirect()->back();
    }
}
