<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Permission;

class Role extends Model {

    public function permissions() {
        return $this->belongsToMany(Permission::class);
    }

    public static function hasPermission($code = null) {
        $admin  = Auth::guard('admin')->user();

        if ($admin->id > 1) {
            $routeName      = $code ?? str_replace('admin.', '', request()->route()->getName());
            $permissions    = $admin->role->permissions->pluck('code')->toArray();
            $allPermissions = Permission::select('code')->get()->pluck('code')->toArray();

            if (in_array($routeName, $allPermissions) && !in_array($routeName, $permissions)) {
                return false;
            }
        }

        return true;
    }
}