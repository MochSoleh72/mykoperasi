<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Post;
use App\LoanRequest;

class User extends Authenticatable
{
    use Notifiable;

    const ACCESS_ADMIN = 1;
    const ACCESS_MEMBER = 2;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'level', 'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'level'
    ];

    public function isAdmin()
    {
        return $this->level == static::ACCESS_ADMIN;
    }

    public function isMember()
    {
        return $this->level == static::ACCESS_MEMBER;
    }

    public function loanRequests()
    {
        return $this->hasMany(LoanRequest::class, 'member_id');
    }

    public function scopeMember($query)
    {
        return $query->where('level', User::ACCESS_MEMBER);
    }

    public function scopeAdmin($query)
    {
        return $query->where('level', User::ACCESS_ADMIN);
    }
}
