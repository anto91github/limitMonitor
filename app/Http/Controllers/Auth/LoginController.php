<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Helpers\AuditTrailHelper;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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

    public function username()
    {
        return 'username';
    }

    protected function attemptLogin(Request $request)
    {
        $credentials = [
            'password' => $request->password,
            'status' => 1 // Hanya izinkan login jika status = 1
        ];
    
         // Cek apakah input berupa email atau uid
        if (filter_var($request->input('username'), FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $request->input('username');
        } else {
            $credentials['uid'] = $request->input('username');
        }

        $loginSuccessful = $this->guard()->attempt(
            $credentials,
            $request->filled('remember')
        );
    
        // Cek apakah login berhasil
        if ($loginSuccessful) {
            AuditTrailHelper::add_log('Login', '');
        } else {
            AuditTrailHelper::add_log('Other', 'Failed Login '.$request->email);
        }

        return $loginSuccessful;
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        // Cek apakah pengguna ada di database
        $user = $this->guard()->getProvider()->retrieveByCredentials($request->only('email', 'password'));

        if ($user && $user->status != 1) {
            return redirect()->back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors([
                    'email' => 'Akun Anda tidak aktif. Silakan hubungi administrator.',
                ]);
        }

        // Jika tidak, kembalikan pesan error default
        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }

    public function logout(Request $request) {
         AuditTrailHelper::add_log('Logout', '');
         Auth::logout();
         return redirect('/login');
    }
}
