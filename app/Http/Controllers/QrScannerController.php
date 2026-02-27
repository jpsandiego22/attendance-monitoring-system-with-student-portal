<?php

namespace App\Http\Controllers;

use App\Models\DetailLogs;
use App\Models\UserDetail;
use App\Models\UserQR;
use App\Support\HelperRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QrScannerController extends Controller
{

    protected $helper;
    protected $userDetail;
    protected $userQR;
    protected $detailLogs;
    public function __construct(HelperRepository $helper, UserDetail $userDetail, UserQR $userQR, DetailLogs $detailLogs)
    {
        $this->helper = $helper;
        $this->userDetail = $userDetail;
        $this->userQR = $userQR;
        $this->detailLogs = $detailLogs;
    }

    public function index(Request $request)
    {
        return view('qr-scanner.index');
    }
    public function scan_qr(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'qr_code' => 'required|string',
        ]);

        if ($validator->fails()) 
        {
            $errors = $validator->errors()->all(); // array of error messages
            $responses = $this->helper->handler('error', 'danger', implode('<br>', $errors));

            return response()->json($responses);
        }

        $validate_Qr = $this->userQR::SearchQrCode($request->input('qr_code'))->get();

        if($validate_Qr->isEmpty()) 
        {
            $responses = $this->helper->handler('error', 'danger', 'QR NOT FOUND.');

            return response()->json($responses);
        }
        

        $array = explode('-', $request->input('qr_code'));

        $user_data = $this->userDetail::searchIdentification($array[2])
                ->with('user')
                ->first(['id','img','name','identification','lock']);
 
        
        if($user_data->lock == 1)
        {
            $responses = $this->helper->handler('error','danger','Your account is locked. Please contact admin.');

            return response()->json($responses);
        }
         
        $now = date('Y-m-d');
        $logs = $this->detailLogs::searchByUserAndDate($user_data->id, $now)->first();
        $data = [];
        
        if(!$logs)
        {
              $this->detailLogs::Create([
                'user_detail_id' => $user_data->id,
                'identification' => $user_data->identification,
                'name' => $user_data->name,
                't_in' => now()->format('H:i:s'),
            ]);

            $data = [
                'img'=> $user_data->img,
                'name' => $user_data->name,
                'logType' => 'IN',
                't' => now()->format('H:i:s'),
            ];
            $responses = $this->helper->handler('success','success',$data);
            return response()->json($responses);
        }
        else
        {
             
            $logs->t_out = now()->format('H:i:s');
            $logs->save();
            $data = [
                'img'=> $user_data->img,
                'name' => $user_data->name,
                'logType' => 'OUT',
                't' => now()->format('H:i:s'),
            ];
             $responses = $this->helper->handler('success','success',$data);
            return response()->json($responses);
        }
       
    }
}