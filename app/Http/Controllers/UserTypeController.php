<?php

namespace App\Http\Controllers;

use App\Models\UserDetail;
use App\Models\UserQR;
use App\Models\UserType;
use App\Support\HelperRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserTypeController extends Controller
{
    protected $helper;

    public function __construct(HelperRepository $helper)
    {
        $this->middleware('auth');
        $this->helper = $helper;
    }

    public function index()
    {
        $page = $this->helper->page(
            'Create User Role',
            'Use this form to create new user role / type.'
        );

        $userType = Auth::user()->user_type;
        $userSection = Auth::user()->detail->section;
        $userYear= Auth::user()->detail->year;

        $dataAccess = HelperRepository::dataAccess($userType);

        $data = UserType::query()->get(); 

        $page['datas']= $data;

        return view('admin.users.user_type', $page);
    }
}