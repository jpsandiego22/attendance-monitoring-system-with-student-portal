<?php

namespace App\Http\Controllers;

use App\Models\UserDetail;
use App\Models\UserQR;
use App\Models\UserType;
use App\Support\HelperRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    protected $helper;

    public function __construct(HelperRepository $helper)
    {
        $this->middleware('auth');
        $this->helper = $helper;
    }

    public function register()
    {
      

        $page = $this->helper->page(
            'Create User Account',
            'Use this form to register a new user in the system.'
        );

        // $page['user_types'] = UserType::all(['type','description']);

        return view('admin.users.register', $page);
        
    }
    public function user_create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'identification' => 'required|string|max:100|unique:user_details,identification',
            'name' => 'required|string|max:100',
            'year' => 'required_if:user_type,2|nullable|string|max:10',
            'section' => 'required_if:user_type,2|nullable|string|max:100',
            'user_type' => 'required|integer|between:0,2',
        ]);
        

        if ($validator->fails()) 
        {
            $errors = $validator->errors()->all(); // array of error messages
            $responses = $this->helper->handler('error', 'danger', implode('<br>', $errors));

            return back()->with($responses);
        }

        try {
            $user = UserDetail::create([
                'identification' => $request->input('identification'),
                'name' => $request->input('name'),
                'year' => $request->input('year'),
                'section' => $request->input('section'),
                'user_type' => $request->input('user_type'),
            ]);

            $qrcode = $this->helper->GenerateQrCode($user);
            UserQR::create($qrcode);

            $responses = $this->helper->handler('success','success','New Record has been successfully saved.');

            return back()->with($responses);

        } catch (\Exception $e) {
            
            $responses = $this->helper->handler('error', 'error', 'Failed to create user: ' . $e->getMessage());
            return response()->json($responses,500);
        }

        
    }
    public function list()
    {
        $page = $this->helper->page(
            'List of Users Account',
            'View and manage all user accounts registered in the system.');

        $page['users']= UserDetail::with('type')->with('user')->get();
        

        return view('admin.users.list', $page);
        
    }
    public function user_update(Request $request,$id)
    {
        try {
            $record = UserDetail::findOrFail($id);
            // Toggle lock
            $record->lock = $record->lock == 0 ? 1 : 0;
            $record->save();

            $responses = $this->helper->handler('success',$record->lock == 0 ? 'success'  : 'warning', $record->lock == 0 ? 'User Details Unlocked.' : 'User Details Locked.');

            return back()->with($responses);
        } catch (\Exception $e) {
            
            $responses = $this->helper->handler('error', 'error', 'Failed to update user: ' . $e->getMessage());
            return response()->json($responses,500);
        }
    }
}
