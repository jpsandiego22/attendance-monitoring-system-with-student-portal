<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserQR extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'user_qr';
    protected $fillable = [
        'user_detail_id', 'qr_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_detail_id', 'qr_code',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function qr()
    {
        return $this->belongsTo(UserDetail::class, 'user_detail_id');
    }
    public function scopeSearchQrCode($query, $keyword)
    {
       
        if ($keyword) {
            return $query->where('qr_code',$keyword);
        }
        return $query->whereRaw('0 = 1');
       
    }
}
