<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\Pool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProfileController extends Controller
{
    /**
     * Display the profile view.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = session()->get('user');
        if (!$user) return redirect()->route('auth.login', [
            'redirect' => $request->fullurl(),
        ]);

        $base = env('FILTERPEDIA_BACKEND_URL', 'http://localhost');
        $res = Http::pool(fn(Pool $pool) => [
            $pool->as('profile')->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'authorization' => 'Bearer ' . session()->get('token'),
            ])->get($base . '/profile'),
            $pool->as('provinces')->get($base . '/provinsi'),
        ]);

        $profile = $res['profile']->object();
        $provinces = $res['provinces']->object();
        session()->put('user', $profile->data);

        return view('profiles.index', [
            'user' => $profile->data,
            'provinces' => $provinces->data,
        ]);
    }


    /**
     * Update the user's profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setting(Request $request)
    {
        $user = session()->get('user');
        if (!$user) return redirect()->route('auth.login', [
            'redirect' => $request->fullurl(),
        ]);
        return view('profiles.setting');
    }

    /**
     * Update the user's profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = session()->get('user');
        if (!$user) return redirect()->route('auth.login');

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'province' => ['nullable', 'string', 'max:255'],
            'zipcode' => ['nullable', 'string', 'max:6'],
            'avatar' => ['nullable', 'image'],
        ]);

        $res = Http::backend()->post('/profile', [
            'name' => $request->get('name'),
            'alamat' => $request->get('address'),
            'telepon' => $request->get('phone'),
            'handphone' => $request->get('phone'),
            'kode_pos' => $request->get('zipcode'),
            'provinsi_id' => $request->get('province'),
        ]);

        $status = $res->successful();
        if ($status) session()->flash('success', 'Berhasil update profile!');
        else session()->flash('error', 'Gagal update profile!');

        return redirect()->back();
    }


    /**
     * Update the user's profile password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(Request $request)
    {
        $user = session()->get('user');
        if (!$user) return redirect()->route('auth.login');

        $request->validate([
            'old_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6'],
            'confirmation' => ['required', 'string', 'same:password'],
        ]);

        $res = Http::backend()->post('/password/update', [
            'old_password' => $request->get('old_password'),
            'password' => $request->get('password'),
            'confirmation' => $request->get('confirmation'),
        ]);

        $status = $res->successful();
        if ($status) session()->flash('success', 'Berhasil update password!');
        else session()->flash('error', 'Gagal update password!');

        return redirect()->route('profile.index');
    }
}
