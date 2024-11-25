<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthenticationController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function login()
    {
        $user = session()->get('user');
        if ($user) return redirect()->route('landing');

        return view('auth.login');
    }

    /**
     * Display the register view.
     *
     * @return \Illuminate\View\View
     */
    public function register()
    {
        $user = session()->get('user');
        if ($user) return redirect()->route('landing');

        return view('auth.register');
    }

    /**
     * Display the forgot password view.
     *
     * @return \Illuminate\View\View
     */
    public function forgot()
    {
        $user = session()->get('user');
        if ($user) return redirect()->route('landing');

        return view('auth.forgot');
    }

    /** 
     * Display the change password view.
     *
     * @return \Illuminate\View\View
     */
    public function change()
    {
        $user = session()->get('user');
        if ($user) return redirect()->route('landing');

        return view('auth.change');
    }

    /**
     * Handle an incoming login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function signin(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $credentials = $request->only('email', 'password');
        $base = env('FILTERPEDIA_BACKEND_URL', 'http://localhost');
        $res = Http::backend()->post($base . '/login', $credentials);
        $success = $res->successful();


        if ($success) {
            $result = $res->object();
            $user = $result->data;
            $token = $result->token;

            session()->put('user', $user);
            session()->put('token', $token);

            $prev = $request->session()->previousUrl();

            if ($prev) {
                $request = Request::create($prev, 'GET');
                $redirect = $request->input('redirect');
                return redirect()->to($redirect);
            }

            return redirect()->route('landing');
        }

        return redirect()->back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Email atau kata sandi salah']);
    }

    /** 
     * Handle an incoming signup request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function signup(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
            'confirmation' => ['required', 'string', 'same:password'],
            'bussiness' => ['required', 'string', 'in:1,0'],
            'company' => ['nullable', 'required_if:bussiness,1', 'string', 'max:255'],
            'npwp' => ['nullable', 'required_if:bussiness,1', 'string', 'max:255'],
            'image' => ['nullable', 'required_if:bussiness,1', 'image'],
        ]);

        $bussiness = $request->get('bussiness');

        if ($bussiness == '1') {
            $res = Http::backend()->post('/register', [
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => $request->get('password'),
                'password_confirmation' => $request->get('confirmation'),
                'nama_pt' => $request->get('company'),
                'npwp' => $request->get('npwp'),
                'npwp_image' => $request->file('image'),
            ]);
        } else {
            $res = Http::backend()->post('/register', [
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => $request->get('password'),
                'password_confirmation' => $request->get('confirmation'),
            ]);
        }

        $status = $res->successful();

        if ($status) {
            session()->flash('success', 'Berhasil mendaftar!');
            return redirect()->route('landing');
        }

        $messages = $res->json('message');
        $error = array_reduce($messages, function ($result, $item) {
            return $result . $item[0] . ' ';
        });
        session()->flash('error', 'Gagal mendaftar! ' . $error);
        return redirect()->back();
    }

    /** 
     * Handle an incoming recovery request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function recovery(Request $request)
    {
        $user = session()->get('user');
        if ($user) return redirect()->route('landing');

        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $email = $request->get('email');
        $base = env('FILTERPEDIA_BACKEND_URL', 'http://localhost');
        $res = Http::backend()->post($base . '/forget-password', [
            'email' => $email,
        ]);

        $status = $res->successful();

        if ($status) {
            session()->flash('success', 'Link verifikasi sudah dikirim!');
            return redirect()->route('landing');
        }

        $error = $res->json('message');
        session()->flash('error', 'Gagal mengirim link verifikasi! ' . $error);
        return redirect()->back();
    }

    /** 
     * Handle an incoming reset password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset(Request $request)
    {
        $user = session()->get('user');
        if ($user) return redirect()->route('landing');

        $request->validate([
            'email' => ['required', 'email'],
            'otp' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6'],
            'confirmation' => ['required', 'string', 'same:password'],
        ]);

        $base = env('FILTERPEDIA_BACKEND_URL', 'http://localhost');
        $res = Http::backend()->post($base . '/reset-password', [
            'token' => $request->get('otp'),
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            'password_confirmation' => $request->get('confirmation'),
        ]);

        $status = $res->successful();
        if ($status) {
            session()->flash('success', 'Berhasil mengatur ulang password!');
            return redirect()->route('landing');
        }

        $error = $res->json('message');
        session()->flash('error', 'Gagal mengatur ulang password! ' . $error);
        return redirect()->back();
    }

    /**
     * Handle an incoming logout request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        session()->flush();
        return redirect()->route('landing');
    }
}
