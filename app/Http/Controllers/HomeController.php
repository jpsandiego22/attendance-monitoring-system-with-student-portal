<?php

namespace App\Http\Controllers;

use App\Support\HelperRepository;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $helper;

    public function __construct(HelperRepository $helper)
    {
        $this->middleware('auth');
        $this->helper = $helper;
    
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $page = $this->helper->page(
            'Student Attendance Monitoring System',
            'Your web analytics dashboard template.');

        return view('admin.home.index',$page);
    }
    public function studentindex()
    {
      
        $page = $this->helper->page(
            'Student Attendance Monitoring System',
            'Your web analytics dashboard template.');
        
        return view('admin.home.index',$page);
    }

    
}
