<?php

namespace App\Http\Controllers;

use App\Models\UserDetail;
use App\Support\HelperRepository;
use Illuminate\Http\Request;


class QrScannerController extends Controller
{

    protected $helper;

    public function __construct(HelperRepository $helper)
    {
        $this->helper = $helper;
    }

    public function index(Request $request)
    {
        return view('qr-scanner.index');
    }
    public function scan_qr(Request $request)
    {
        
        return response()->json($request->input('qr_code'));
    }
}