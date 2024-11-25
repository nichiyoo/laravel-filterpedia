<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\Pool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;

class CartController extends Controller
{
    /**
     * Display the cart view.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = session()->get('user');
        if (!$user) return redirect()->route('auth.login', [
            'redirect' => $request->fullUrl(),
        ]);

        $res = Http::backend()->get('/cart');
        $cart = $res->object();

        if (!$cart || !isset($cart->data)) {
            session()->flash('error', 'Tidak ada produk di keranjang!');
            return view('cart.index', [
                'cart' =>  [],
                'total' => 0,
            ]);
        }

        $total = array_sum(array_column($cart->data, 'total_price'));
        return view('cart.index', [
            'cart' => $cart->data,
            'total' => $total,
        ]);
    }

    /**
     * Display the checkout view.
     *
     * @return \Illuminate\View\View
     */
    public function checkout(Request $request)
    {
        $user = session()->get('user');
        if (!$user) return redirect()->route('auth.login', [
            'redirect' => $request->fullurl(),
        ]);

        $res = Http::backend()->get('/cart');
        $cart = $res->object();
        if (!$cart || !isset($cart->data)) {
            session()->flash('error', 'Tidak ada produk di keranjang!');
            return view('cart.index', [
                'cart' => [],
                'total' => 0,
            ]);
        }

        $total = array_sum(array_column($cart->data, 'total_price'));

        $base = env('FILTERPEDIA_BACKEND_URL', 'http://localhost');
        $res = Http::pool(fn(Pool $pool) => [
            $pool->as('profile')->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'authorization' => 'Bearer ' . session()->get('token'),
            ])->get($base . '/profile'),

            $pool->as('methods')->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'authorization' => 'Bearer ' . session()->get('token'),
            ])->get($base . '/payment-method'),

            $pool->as('provinces')->get($base . '/provinsi'),
        ]);

        $profile = $res['profile']->object();
        $methods = $res['methods']->object();
        $provinces = $res['provinces']->object();

        return view('cart.checkout', [
            'cart' => $cart->data ?? [],
            'total' => $total,
            'user' => $profile->data,
            'provinces' => $provinces->data,
            'methods' => $methods->data,
            'delivery' => 90000,
        ]);
    }

    /** 
     * Display the checkout view for direct checkout.
     *
     * @return \Illuminate\View\View
     */
    public function direct(Request $request, $slug)
    {
        $user = session()->get('user');
        if (!$user) return redirect()->route('auth.login', [
            'redirect' => $request->fullurl(),
        ]);

        $product = Http::backend()->get('/products/' . $slug);
        $success = $product->successful();

        if (!$success) {
            session()->flash('error', 'Tidak dapat menampilkan produk ini');
            return redirect()->back();
        }

        $product = $product->object();
        $total = $product->data->product_price;

        $base = env('FILTERPEDIA_BACKEND_URL', 'http://localhost');
        $res = Http::pool(fn(Pool $pool) => [
            $pool->as('profile')->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'authorization' => 'Bearer ' . session()->get('token'),
            ])->get($base . '/profile'),

            $pool->as('methods')->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'authorization' => 'Bearer ' . session()->get('token'),
            ])->get($base . '/payment-method'),

            $pool->as('provinces')->get($base . '/provinsi'),
        ]);

        $profile = $res['profile']->object();
        $methods = $res['methods']->object();
        $provinces = $res['provinces']->object();

        return view('cart.direct', [
            'product' => $product->data,
            'user' => $profile->data,
            'provinces' => $provinces->data,
            'methods' => $methods->data,
            'total' => $total,
            'delivery' => 90000,
        ]);
    }

    /**
     * Add the product to the cart.
     *
     * @param  object  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        $user = session()->get('user');
        if (!$user) return redirect()->route('auth.login', [
            'redirect' =>  $request->session()->previousUrl(),
        ]);

        $res = Http::backend()->post('/add-to-cart', [
            'user_id' => $user->id,
            'product_id' => $request->product_id,
            'qty' => 1,
        ]);
        $success = $res->successful();

        if ($success) session()->flash('success', 'Berhasil ditambahkan ke keranjang!');
        else {
            $message = $res->json('message');
            session()->flash('error', 'Gagal ditambahkan ke keranjang! ' . $message);
        }
        return redirect()->back();
    }

    /**
     * Update the cart.
     *
     * @param  object  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = session()->get('user');
        if (!$user) return redirect()->route('auth.login', [
            'redirect' =>  $request->session()->previousUrl(),
        ]);

        $request->validate([
            'type' => ['required', 'string', 'in:add,subtract,remove'],
            'cart_id' => ['required', 'string'],
        ]);

        $type = $request->get('type');
        $cart_id = $request->get('cart_id');

        $endpoint = match ($type) {
            'add' => 'plus_one',
            'subtract' => 'minus_one',
            'remove' => '/cart/delete/' . $cart_id,
        };

        if ($type === 'add' || $type === 'subtract') {
            $res = Http::backend()->post($endpoint, [
                'user_id' => $user->id,
                'cart_id' => $cart_id,
            ]);
        } else $res = Http::backend()->delete($endpoint);

        $success = $res->successful();
        if ($success) session()->flash('success', 'Berhasil diupdate!');
        else session()->flash('error', 'Gagal diupdate!');

        return redirect()->back();
    }

    /**
     * Confirm the order.
     *
     * @param  object  $request
     * @return \Illuminate\Http\Response
     */
    public function confirm(Request $request)
    {
        $user = session()->get('user');
        if (!$user) return redirect()->route('auth.login', [
            'redirect' =>  $request->session()->previousUrl(),
        ]);

        $res = Http::backend()->get('/payment-method');
        $result = $res->object();
        $methods = $result->data;
        $ids = array_column($methods, 'id');

        $request->validate([
            'method' => ['required', Rule::in($ids)],
        ]);

        $res = Http::backend()->post('/checkout', [
            'user_id' => session()->get('user')->id,
            'payment_code_id' => $request->get('method'),
        ]);

        $success = $res->successful();
        if ($success) session()->flash('success', 'Berhasil membuat pesanan!');
        else {
            $message = $res->json('message');
            session()->flash('error', 'Gagal membuat pesanan! ' . $message);
        }

        return redirect()->route('landing');
    }

    /**
     * Confirm a single product order.
     *
     * @param  object  $request
     * @return \Illuminate\Http\Response
     */
    public function single(Request $request)
    {
        $user = session()->get('user');
        if (!$user) return redirect()->route('auth.login', [
            'redirect' =>  $request->session()->previousUrl(),
        ]);

        $res = Http::backend()->get('/payment-method');
        $result = $res->object();
        $methods = $result->data;
        $ids = array_column($methods, 'id');

        $request->validate([
            'method' => ['required', Rule::in($ids)],
        ]);

        $res = Http::backend()->post('/beli-langsung', [
            'product_id' => $request->get('product_id'),
            'payment_code_id' => $request->get('method'),
        ]);

        $success = $res->successful();
        if ($success) session()->flash('success', 'Pesanan berhasil dibuat!');
        else {
            $error = $res->json('message');
            session()->flash('error', 'Gagal membuat pesanan! ' . $error);
        }

        return redirect()->back();
    }
}
