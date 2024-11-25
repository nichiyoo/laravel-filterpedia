<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\Pool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = session()->get('user');
        if (!$user) return redirect()->route('auth.login', [
            'redirect' => $request->fullurl(),
        ]);

        $selected = $request->get('type') ?? 'all';
        $base = env('FILTERPEDIA_BACKEND_URL', 'http://localhost');

        $res = Http::backend()->get($base . '/transactions');
        $orders = $res->object();


        if ($selected !== 'all') {
            $filter = match ($selected) {
                'pending' => 0,
                'ongoing' => 1,
                'delivered' => 2,
                'cancelled' => 6,
            };

            $orders->data = array_filter($orders->data, fn($order) => $order->status == $filter);
        }

        return view('orders.index', [
            'orders' => $orders->data,
            'selected' => $selected,
        ]);
    }

    /**
     * Show the order.
     *
     * @param  object  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $user = session()->get('user');
        if (!$user) return redirect()->route('auth.login', [
            'redirect' => $request->fullurl(),
        ]);

        $base = env('FILTERPEDIA_BACKEND_URL', 'http://localhost');
        $res = Http::backend()->get($base . '/transactions/' . $id);
        $success = $res->successful();

        if (!$success) {
            session()->flash('error', 'Tidak dapat menampilkan pesanan ini');
            return redirect()->back();
        }

        $order = $res->object();
        return view('orders.show', [
            'order' => $order->data,
        ]);
    }

    /**
     * Cancel the order.
     * 
     * @param  object  $request
     * @return \Illuminate\Http\Response
     */
    public function cancel(Request $request)
    {
        $user = session()->get('user');
        if (!$user) return redirect()->route('auth.login', [
            'redirect' =>  $request->session()->previousUrl(),
        ]);

        $base = env('FILTERPEDIA_BACKEND_URL', 'http://localhost');
        $res = Http::backend()->get($base . '/transactions/' . $request->get('transaction_id'));
        $success = $res->successful();

        if (!$success) {
            session()->flash('error', 'Tidak dapat menampilkan pesanan ini');
            return redirect()->back();
        }

        $res = Http::backend()->post('/cancel/transactions', [
            'transaction_id' => $request->get('transaction_id'),
        ]);
        $success = $res->successful();

        if ($success) session()->flash('success', 'Berhasil membatalkan pesanan!');
        else session()->flash('error', 'Gagal membatalkan pesanan!');

        return redirect()->back();
    }

    /**
     * Pay the order.
     *
     * @param  object  $request
     * @return \Illuminate\Http\Response
     */
    public function payment(Request $request)
    {
        $user = session()->get('user');
        if (!$user) return redirect()->route('auth.login', [
            'redirect' =>  $request->session()->previousUrl(),
        ]);

        $base = env('FILTERPEDIA_BACKEND_URL', 'http://localhost');
        $res = Http::backend()->get($base . '/transactions/' . $request->get('transaction_id'));
        $success = $res->successful();

        if (!$success) {
            session()->flash('error', 'Tidak dapat menampilkan pesanan ini');
            return redirect()->back();
        }

        $request->validate([
            'receipt' => ['required', 'image'],
        ]);

        $res = Http::backend()->post('/confirm-payment', [
            'transaction_id' => $request->get('transactions_id'),
            'images' => $request->file('receipt'),
        ]);

        $success = $res->successful();
        if ($success) session()->flash('success', 'Berhasil melakukan pembayaran!');
        else session()->flash('error', 'Gagal melakukan pembayaran!');

        return redirect()->back();
    }
}
