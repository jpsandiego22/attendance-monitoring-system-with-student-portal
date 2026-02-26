<?php

namespace App\Http\Controllers;

use App\Models\UserDetail;
use App\Models\UserQR;
use App\Models\UserType;
use App\Support\HelperRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    protected $helper;

    public function __construct(HelperRepository $helper)
    {
        $this->middleware('auth');
        $this->helper = $helper;
    }

    public function register()
    {

    }
}