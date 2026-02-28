<?php

namespace App\Support;

use App\Models\UserType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class HelperRepository
{
    public function handler($status, $class, $message)
    {
        return $responses = [
            'status'=> $status,
            'class'=> $class,
            'message' => $message];
    }
    public function page($page_title, $page_sub)
    {
        return $page = [
                'page_title' => Str::upper($page_title),
                'page_sub' => $page_sub,
                'user_types'=> UserType::all(['type','description'])
            ];

    }
    public static function GenerateQrCode($value)
    {
        $data = ["user_detail_id"=> $value->id,"qr_code"=> Str::random(10)."-". $value->id."-".$value->identification ];
        return $data;
    }
    public function kill_session(Request $request)
    {
        Auth::logout(); // Destroy the user session
    }
    public function error_page($status, $class, $message)
    {
         return $responses = [
            'status'=> $status,
            'class'=> $class,
            'message' => $message];

        return view('error',$responses);
    }
    
}