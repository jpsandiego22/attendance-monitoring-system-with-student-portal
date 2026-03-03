<?php

namespace App\Http\Controllers;

use App\Models\UserDetail;
use App\Support\HelperRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QrController extends Controller
{

    protected $helper;

    public function __construct(HelperRepository $helper)
    {
        $this->middleware('auth');
        $this->helper = $helper;
    
    }

    public function index(Request $request)
    {
        $page = $this->helper->page(
            'List of Users QR',
            'View and manage all user accounts registered in the system.');

        $perPage = $request->input('per_page', 10);

        $page['perPage'] = $perPage;
            // Use paginate() directly on the query, no ->get()

        $userType = Auth::user()->user_type;
        $userSection = Auth::user()->detail->section;
        $userYear= Auth::user()->detail->year;

        $userDetail = $userType === 0 
            ? UserDetail::with('type')
            ->with('user')
            ->with('qr')
            ->paginate($perPage) 
            : UserDetail::with('type')
            ->whereNotIn('user_type',[0,1])
            ->where('section',$userSection)
            ->where('year',$userYear)
            ->with('user')
            ->with('qr')
            ->paginate($perPage); 

        $page['qrLists'] = $userDetail;

        return view('admin.qr.index', $page);
    }
   

    
}
