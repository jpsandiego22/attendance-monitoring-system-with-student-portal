<?php

namespace App\Http\Controllers;

use App\Models\UserDetail;
use App\Support\HelperRepository;
use Illuminate\Http\Request;


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
                $page['qrLists'] = UserDetail::with('type')
                    ->with('user')
                    ->with('qr')
                    ->paginate($perPage); // <-- here

        return view('admin.qr.index', $page);
    }
   

    
}
