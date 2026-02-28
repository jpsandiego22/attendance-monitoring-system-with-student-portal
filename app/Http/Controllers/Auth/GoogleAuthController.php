<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDetail;
use App\Providers\RouteServiceProvider;
use App\Support\HelperRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;

class GoogleAuthController extends Controller

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
    protected $userDetail;
    protected $userAccount;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(HelperRepository $helper, UserDetail $userDetail, User $userAccount)
    {
        $this->helper = $helper;
        $this->userDetail = $userDetail;
        $this->userAccount = $userAccount;
        
    }
    protected function redirectToGoogle(Request $request)
    {  
        // Decode JSON if Vue sends application/json
        $data = $request->all();

        // Force auth_type as string and trim spaces
        $data['auth_type'] = isset($data['auth_type']) ? trim($data['auth_type']) : '';
        $data['regrem']    = $data['regrem'] ?? '';



        $validator = Validator::make($data, [
            'auth_type' => [
                'required',
                'string',
                'max:100',
                Rule::in(['login', 'registration']),
            ],
            'regrem' => 'required_if:auth_type,registration|nullable|json',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all(); 
            $responses = $this->helper->handler('error','danger',implode('<br>', $errors));
                session()->forget(['auth_type', 'regrem']);
                return view('error',$responses);
        }

        if($data['auth_type'] =='login')
        {
            session(['auth_type' => $data['auth_type']]);
            return Socialite::driver('google')->redirect();
        }
        session(['auth_type' => $data['auth_type'],
            'regrem' => $data['regrem']]);
        return Socialite::driver('google')->redirect();
    }
    protected function auth_login(Request $request)
    {
        $googleUser = Socialite::driver('google')->user();
        $email = $googleUser->getEmail();
        $google_id = $googleUser->getId();
        $userType = $request->session()->get('auth_type');

        if($userType == 'login')
        {
            Auth::logout();
            $request->session()->invalidate();

            $amsGoogleUser = $this->userAccount::where('google_id', $google_id)->first();
            if ($amsGoogleUser) {
                Auth::login($amsGoogleUser);
                $user = Auth::user();
  
                if ($user->detail && $user->detail->lock == 1) {
                    Auth::logout(); 
                    $responses = $this->helper->handler('error','danger','Your account is locked. Please contact admin.');
                    return redirect()->intended('/login')->with($responses);
                }
                $request->session()->regenerate();
                if ($user->detail && $user->detail->user_type == 2) {
                    return redirect()->intended('/student/portal');
                }
                return redirect()->intended($this->redirectTo); 
            }

            $responses = $this->helper->handler('error','danger','The provided credentials do not match our records.');
            return redirect()->intended('/login')->with($responses);
        }
        elseif($userType == 'registration')
        {
            $regrem = json_decode($request->session()->get('regrem'),true);
            $regrem[0]['email'] = $email;

            $validator = Validator::make($regrem[0], [
                'id' => 'required|integer',
                'identification' => 'required|string|max:100',
                'email' => 'required|email|string|max:100|unique:user_account,email',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->all(); // array of error messages
                $responses = $this->helper->handler('error','danger',implode('<br>', $errors));
                    session()->forget(['auth_type', 'regrem']);
                    return redirect()->intended('/registration')->with($responses);
            }

            $details = $this->userDetail::where('id', $regrem[0]['id'])->first(['id','identification','user_type']);

            if($details)
            {
                $data = ['user_detail_id' => $regrem[0]['id'],
                    'email'=> $email,
                    'email_verified_at' => now(),
                    'remember_token' => Str::random(10),
                    'google_id' => $google_id,
                    'user_type' => $details->user_type,
                ];

                try {
                    $saveUser = $this->userAccount::create($data);
                    $responses = $this->helper->handler('success', 'success', 'Registration completed successfully!');
                    session()->forget(['auth_type', 'regrem']);
                    return redirect()->intended('/registration')->with($responses);
                } catch (\Exception $e) {
                   session()->forget(['auth_type', 'regrem']);
                    $responses = $this->helper->handler('error', 'error', 'Failed to create user: ' . $e->getMessage());
                    return view('error')->with($responses);
                }
            }
           
        }
    }
}