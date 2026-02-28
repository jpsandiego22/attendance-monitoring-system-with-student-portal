<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetail;
use App\Support\HelperRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $helper;
    protected $userDetail;
    protected $userAccount;

    public function __construct(HelperRepository $helper, UserDetail $userDetail, User $userAccount)
    {
        
        $this->middleware('auth');
        $this->helper = $helper;
        $this->userDetail = $userDetail;
        $this->userAccount = $userAccount;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $page = $this->helper->page(
            'Hi, '. Auth::user()->detail->name,
            'Your web analytics dashboard view.');

        $data = [
            't_users' => $this->userDetail::count(),
            't_linked' => $this->userAccount::count(),
            't_google' => $this->userAccount::whereNotNull('google_id')->count(),
            't_pending' => $this->userDetail->whereDoesntHave('user')->count(),
            't_locked' => $this->userDetail::where('lock',1)->count()
        ];


        return view('admin.home.index',array_merge($page, $data));
    }
    public function studentindex()
    {
      
        $page = $this->helper->page(
            'Student Attendance Monitoring System',
            'Your web analytics dashboard template.');
        
        return view('admin.home.index',$page);
    }

    
}
