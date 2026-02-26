<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserDetail extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $table = 'user_details';
    protected $fillable = [
        'img', 'identification', 'name', 'year', 'section', 'user_type','lock'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
         'user_type',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function user()
    {
        return $this->hasOne(User::class, 'user_detail_id');
    }
    public function type()
    {
        return $this->belongsTo(UserType::class, 'user_type','type');
    }
    public function qr()
    {
        return $this->hasOne(UserQR::class, 'user_detail_id');
    }
    public function scopeSearchIdentification($query, $keyword)
    {
       
        if ($keyword) {
            return $query->where('identification',$keyword);
        }
        return $query->whereRaw('0 = 1');
       
    }
}
