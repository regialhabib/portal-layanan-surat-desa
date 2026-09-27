<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Penduduk;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nik' => ['required', 'string', 'size:16'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:3'],
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.size' => 'NIK harus berjumlah 16 digit.',
            'email.unique' => 'Email ini sudah terdaftar.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // Find Penduduk by NIK
        $penduduk = Penduduk::where('nik', $data['nik'])->first();
        
        if (!$penduduk) {
            throw ValidationException::withMessages([
                'nik' => ['NIK tidak ditemukan dalam basis data penduduk desa. Pastikan Anda warga terdaftar.'],
            ]);
        }

        // Check if this Penduduk already has an account
        if (User::where('penduduk_id', $penduduk->id)->exists()) {
            throw ValidationException::withMessages([
                'nik' => ['Akun untuk NIK ini sudah terdaftar. Silakan lakukan Login.'],
            ]);
        }

        return User::create([
            'penduduk_id' => $penduduk->id,
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => 'masyarakat', // Default role for standard citizens
        ]);
    }
}
