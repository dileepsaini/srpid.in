<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{

    use GlobalStatus;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $fillable = [
    'role_id',
    'name',
    'email',
    'mobile',
    'username',
    'image',
    'password',
    'status',
    'remember_token',
    'profile',
    'partner',
    'phone',
    'addresh',      // Note: Consider correcting spelling to 'address' if it's a typo
    'code',
    'fields',
];


    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class, 'agent_id');
    }
    public function badgeData()
    {
        $html = '';
        if ($this->status == Status::ENABLE) {
            $html = '<span class="badge badge--success">' . trans('Active') . '</span>';
        } else {
            $html = '<span><span class="badge badge--warning">' . trans('Banned') . '</span></span>';
        }
        return $html;
    }
}
