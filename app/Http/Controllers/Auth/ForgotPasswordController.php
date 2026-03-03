<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\HelperRepository;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

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
    
    public function showForm(Request $request)
    {
        return view('auth.reset');
    }
    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc,dns|string',
        ]);


        if ($validator->fails()) 
        {
            $errors = $validator->errors()->all(); // array of error messages
            $responses = $this->helper->handler('error','danger',implode('<br>', $errors));
            return response()->json($responses);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $responses = $this->helper->handler('error','danger','We can’t find a user with that email address.');
            return response()->json($responses);
        }

        if (!is_null($user->google_id)) {
             $responses = $this->helper->handler('error','danger','This account uses Google login. Please sign in using Google.');
            return response()->json($responses);
           
        }

        // ✅ Normal users → send reset link
        $response = Password::sendResetLink(
            $request->only('email')
        );

        if ($response == Password::RESET_LINK_SENT) {
            return response()->json([
                'status' => 'success',
                'message' => 'Password reset link sent to your email.',
                'class' => 'success'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Unable to send reset link. Email not found.',
            'class' => 'danger'
        ], 400);
    }
}
