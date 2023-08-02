<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permissions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionsController extends Controller
{
    public function PermissionsList(Request $request)
    {
        return Permissions::with('employeesNames')->paginate(100);
    }
}
