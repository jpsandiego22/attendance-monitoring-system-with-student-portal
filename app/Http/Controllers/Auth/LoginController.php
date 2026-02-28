<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Support\HelperRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = '/admin/home';
    protected $helper;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(HelperRepository $helper)
    {
        $this->middleware('guest')->except('logout');

        $this->helper = $helper;

        
    }
    protected function showLoginForm(Request $request)
    {
        return view('auth.login');
    }
    protected function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => [
                'required',
                'string',
                'regex:/\S+/' // ensures at least one non-space character
            ],
        ]);


        if ($validator->fails()) 
        {
            $errors = $validator->errors()->all(); // array of error messages
            $responses = $this->helper->handler('error','danger',implode('<br>', $errors));
            return back()->with($responses);
        }

        $credentials = $request->only('email', 'password');
     
        Auth::logout();
        $request->session()->invalidate();

        if (Auth::attempt($credentials)) {
            // Check lock in user_details
             $user = Auth::user(); // get logged-in user
            // Check lock in related user_detail
            if ($user->detail && $user->detail->lock == 1) {
                Auth::logout(); // immediately log out
                $responses = $this->helper->handler('error','danger','Your account is locked. Please contact admin.');
                return back()->with($responses);
                
            }

            $request->session()->regenerate();
            if ($user->detail && $user->detail->user_type == 2) {
                return redirect()->intended('/student/portal'); // or any route
            }
            return redirect()->intended($this->redirectTo); // or any route
        }

        $responses = $this->helper->handler('error','danger','The provided credentials do not match our records.');

        return back()->with($responses);
       
    }
    public function logout(Request $request)
    {
        
        Auth::logout(); // Destroy the user session

        // Optional: invalidate session & regenerate CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login'); // Redirect to login page
    }

    
}
