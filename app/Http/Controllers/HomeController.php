<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetail;
use App\Support\HelperDashBoardRepository;
use App\Support\HelperRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
    protected $helperDashBoard;

    public function __construct(HelperRepository $helper, UserDetail $userDetail, User $userAccount, HelperDashBoardRepository $helperDashBoardRepository)
    {
        $this->middleware('auth');
        $this->helper = $helper;
        $this->userDetail = $userDetail;
        $this->userAccount = $userAccount;
        $this->helperDashBoard = $helperDashBoardRepository;
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

        $data = $this->helperDashBoard->getCountDashboard();
        
        return view('admin.home.index',array_merge($page, $data));
    }
    public function studentindex()
    {
       Auth::logout(); 
        $page = $this->helper->page(
            'Student Attendance Monitoring System',
            'Your web analytics dashboard template.');
        
        return 'dsadas';
    }
    public function getDataList(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'query' => 'required|integer|between:1,4'
        ]);


        if ($validator->fails()) 
        {
            $errors = $validator->errors()->all();
            $responses = $this->helper->handler('error','danger',implode('<br>', $errors));
            return back()->with($responses);
        }
        $query = $request->input('query');

        $data = $this->helperDashBoard->getDataList($query);
       
        $responses = $this->helper->handler('success','success', $data);

        return response()->json($responses);

    }

    
}
