<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\UserDetail;
use App\Support\HelperRepository;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function register(Request $request)
    {
        return view('auth.register');
    }
    public function search_identification(Request $request)
    {
       $keyword = $request->input('query');
     
       $user_data = $this->userDetail::searchIdentification($keyword)
                ->with('user')
                ->first(['id','name','identification','lock']);

        if ($user_data) {
            if($user_data->lock == 1)
            {
                 return response()->json([
                    'status' => 'error',
                    'message' => 'Identification Detail is locked, Please Contact Administrator.'
                ]);
            }
            if ($user_data->user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Identification is already linked to an email.'
                ]);
            }

            return response()->json($user_data);

        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No users found'
            ]);
        }
     
    }
    public function registerUser(Request $request)
    {
        $user = $request->input('data');

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|string|max:100|unique:user_account,email',
            'password' => 'required|string|max:100',
        ]);

        if ($validator->fails()) 
        {
            $errors = $validator->errors()->all(); // array of error messages
            $responses = $this->helper->handler('error', 'danger', implode('<br>', $errors));

            return response()->json($responses);
        }

        if(count($user) === 1)
        {
            $record = UserDetail::with('type')->find($user[0]['id']);

            $data = ['user_detail_id' => $user[0]['id'],
            'email'=> $request->input('email'),
            'password'=> $request->input('password'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'user_type' => $record->type->type,
            ];

            try {
                $saveUser = User::create($data);
                $responses = $this->helper->handler('success', 'success', 'Record Successfully Saved.');
                return response()->json($responses);
            } catch (\Exception $e) {
              
                  $responses = $this->helper->handler('error', 'error', 'Failed to create user: ' . $e->getMessage());
                return response()->json($responses,500);
            }
        }
        else
        {
             return response()->json($user);
        }
    }
    protected function validator(array $data)
    {
       
        

        
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
