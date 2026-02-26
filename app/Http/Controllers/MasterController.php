<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetail;
use App\Support\HelperRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MasterController extends Controller
{
    protected $helper;

    public function __construct(HelperRepository $helper)
    {
        $this->middleware('auth');
        $this->helper = $helper;
    
    }
    public function upload_photo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'img' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

      if ($validator->fails()) 
        {
            $errors = $validator->errors()->all(); // array of error messages
            $responses = $this->helper->handler('error', 'danger', implode('<br>', $errors));

            return response()->json($responses);
        }

        if ($request->hasFile('img')) {
            $userDetail = Auth::user()->detail->img;
            if ($userDetail && File::exists(public_path($userDetail))) {
                File::delete(public_path($userDetail));
            }

            $filename = time().'.'.$request->img->extension();
            $request->img->move(public_path('img/faces'), $filename);
            
            $update_detail_img = UserDetail::findOrFail(Auth::user()->detail->id);
            // Toggle lock
            $update_detail_img->img = 'img/faces/'.$filename;
            $update_detail_img->save();
            

            $responses = $this->helper->handler('success','success','Applying Changes Done.');
            return response()->json($responses);
        }

        $responses = $this->helper->handler('error', 'danger', 'No File to Upload.');
        return response()->json($responses);
    }
    public function change_password(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'old' => 'required|string',
            'new' => 'required|string|min:6',
            'confirm'  => 'required|string|same:new',
        ]);

        if ($validator->fails()) 
        {
            $errors = $validator->errors()->all(); // array of error messages
            $responses = $this->helper->handler('error', 'danger', implode('<br>', $errors));

            return response()->json($responses);
        }
        $user = User::findOrFail(Auth::user()->id);

        if (!Hash::check($request->input('old'), $user->password)) {
             $responses = $this->helper->handler('error', 'danger', 'Old password is incorrect');
             return response()->json($responses);
        }

        $user->password = Hash::make($request->input('new'));
        $user->save();

        $responses = $this->helper->handler('success', 'success', 'Password updated successfully');
        return response()->json($responses);
    }
}