<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class DetailLogs extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'detail_logs';
    protected $fillable = [
        'user_detail_id', 'identification', 'name', 't_in', 't_out'
    ];

   
    // protected $hidden = [
    //      'user_type',
    // ];

   
    public function scopeSearchIdentification($query, $keyword)
    {
       
        if ($keyword) {
            return $query->where('identification',$keyword);
        }
        return $query->whereRaw('0 = 1');
       
    }
    public function scopeSearchByUserAndDate($query, $userDetailId = null, $date = null)
    {
        if ($userDetailId) {
            $query->where('user_detail_id', $userDetailId);
        }

        if ($date) {
            // Filter by date (YYYY-MM-DD)
            $query->whereDate('created_at', $date);
        }

        return $query;
    }
}
