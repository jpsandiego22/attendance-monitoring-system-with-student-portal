<?php

namespace App\Support;

use App\Models\UserType;
use App\Models\UserDetail;
use App\Models\User;
use App\Models\UserQR;
use App\Models\DetailLogs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Support\HelperRepository;

class HelperDashBoardRepository
{
  
    public function getCountDashboard()
    {
        $userDetailId    = Auth::user()->detail->id;
        $userId    = Auth::user()->id;
        $userType    = Auth::user()->user_type;
        $userSection = Auth::user()->detail->section;
        $userYear    = Auth::user()->detail->year;


        $dataAccess = HelperRepository::dataAccess($userType);

        // Base queries
         

        $userDetailQuery  = UserDetail::query();
        $userAccountQuery = User::query();
        $detailLogQuery = DetailLogs::query()
        ->whereDate('created_at', now()->toDateString());

        // Apply filter if not Super Admin (0)
        if ($userType != 0) {

            $userDetailQuery->where('section', $userSection)
                            ->where('year', $userYear)
                            ->where('id', '!=', $userDetailId)
                            ->whereIn('user_type',$dataAccess);

            $userAccountQuery->whereHas('detail', function ($q) use ($userSection, $userYear) {
                $q->where('section', $userSection)
                ->where('year', $userYear);
            })->where('id', '!=', $userId)
            ->whereIn('user_type',$dataAccess);

            $detailLogQuery->whereHas('log', function ($q) use ($userSection, $userYear) {
                $q->where('section', $userSection)
                ->where('year', $userYear);
            })->where('id', '!=', $userId)
            ->whereIn('user_type',$dataAccess);
        }

        $t_login = (clone $detailLogQuery)
        ->count();

        $data = [
            't_users'   => $userDetailQuery->count(),

            't_linked'  => $userAccountQuery->count(),

            't_google'  => (clone $userAccountQuery)
                                ->whereNotNull('google_id')
                                ->count(),

            't_pending' => (clone $userDetailQuery)
                                ->whereDoesntHave('user')
                                ->count(),

            't_locked'  => (clone $userDetailQuery)
                                ->where('lock', 1)
                                ->count(),

            't_login'  => $t_login,

            't_p_login'  => 'Users % ('. $this->percentage($userDetailQuery->count(), $t_login)."%)",

            't_logout'  => (clone $detailLogQuery)
                ->whereNull('t_out')
                ->count(),
        ];

        
        return $data;
    }
    protected function percentage($val1, $val2)
    {

        $logoutPercentage = $val1 > 0 ? ($val2 / $val1) * 100 : 0;

        // $logoutPercentage = round($logoutPercentage, 2);
        $truncated = floor($logoutPercentage * 100) / 100; // 0.99
        $formatted = number_format($truncated, 2, '.', ''); // "0.99"
        return $formatted;
        return number_format($logoutPercentage, 2, '.', '');;
    }
    public function getDataList($query)
    {
        $userDetailQuery  = UserDetail::query();
        // $userAccountQuery = User::query();

        $userId    = Auth::user()->detail->id;
        $userType    = Auth::user()->user_type;
        $userSection = Auth::user()->detail->section;
        $userYear    = Auth::user()->detail->year;

        $dataAccess = HelperRepository::dataAccess($userType);

        if ($userType != 0) {

            $userDetailQuery->where('section', $userSection)
                            ->where('year', $userYear)
                            ->where('id', '!=', $userId)
                            ->whereIn('user_type',$dataAccess);

            // $userAccountQuery->whereHas('detail', function ($q) use ($userSection, $userYear) {
            //     $q->where('section', $userSection)
            //     ->where('year', $userYear);
            // });
        }

        switch ($query) {
            case 1:
                $data = $userDetailQuery->with(['user:user_detail_id,email','type:type,description'])->get()->map(function ($detail) {
                    $detail->user_email = $detail->user->email ?? '<span class="badge badge-success p2">No Email Linked</span>';
                    $detail->type_description = $detail->type->description;
                    unset($detail->user, $detail->type); 
                    return $detail;
                });

                $result = [
                    'selected' => 'LIST - ALL USERS',
                    'data' => $data,
                ];
                return $result;

            case 2:
                $data = $userDetailQuery->whereHas('user')->with(['user:user_detail_id,email','type:type,description'])->get()
                ->map(function ($detail) {
                        $detail->user_email = $detail->user->email ?? '<span class="badge badge-success">No user linked</span>';
                        $detail->type_description = $detail->type->description;
                        unset($detail->user, $detail->type); 
                        return $detail;
                    });

                $result = [
                    'selected' => 'LIST - LINK ACCOUNTS',
                    'data' => $data,
                ];
                return $result;
               

            case 3:
                $data = $userDetailQuery->whereHas('user', function ($q) {
                        $q->whereNotNull('google_id');
                    })
                    ->with(['user:user_detail_id,email','type:type,description'])
                    
                    ->get()
                    ->map(function ($detail) {
                        $detail->user_email = $detail->user->email ?? '<span class="badge badge-success">No user linked</span>';
                        $detail->type_description = $detail->type->description;
                        unset($detail->user, $detail->type); 
                        return $detail;
                    });



                $result = [
                    'selected' => 'LIST - GOOGLE ACCOUNT',
                    'data' => $data,
                ];
                return $result;

            case 4:
                $data = $userDetailQuery->where('lock', 1)
                    ->with(['user:user_detail_id,email','type:type,description'])
                    
                    ->get()
                    ->map(function ($detail) {
                        $detail->user_email = $detail->user->email ?? '<span class="badge badge-success">No user linked</span>';
                        $detail->type_description = $detail->type->description;
                        unset($detail->user, $detail->type); 
                        return $detail;
                    });


                $result = [
                    'selected' => 'LIST - LOCK ACCOUNT',
                    'data' => $data,
                ];
                return $result;

            default:
                return collect(); // return empty collection if invalid
        }
    }
    public function getDataLogs($query)
    {

    }
}