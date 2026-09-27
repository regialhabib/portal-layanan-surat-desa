<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        // Validasi
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        // Data login
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        // Cek login
        /*
    if (Auth::attempt($credentials)) {

            // regenerate session
            $request->session()->regenerate();

            return redirect()->route('home')
                ->with('success', 'Login berhasil');
        }
    */


        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            return redirect()->route(
                Auth::user()->role === 'admin' ? 'dashboard' : 'profile'
            )->with('success', 'Login berhasil');
        }

        return back()->with('error', 'Email atau password salah');
    }

    protected function redirectTo()
    {
        session()->flash('success', 'You are logged in!');
        return $this->redirectTo;
    }
}
