<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserType extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $table = 'user_type';
    protected $fillable = [
        'type', 'description'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
 

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function user()
    {
        return $this->hasOne(User::class, 'type', 'user_type'); 
        // 'user_type' is the foreign key in user_account table
    }

}
