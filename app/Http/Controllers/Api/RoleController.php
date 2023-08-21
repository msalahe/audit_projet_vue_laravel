<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::where('name','!=','Lead Auditor')->get();
        return response()->json(RoleResource::collection($roles));
    }
}
