<?php

namespace App\Http\Controllers\Api;

use App\Models\Skill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SkillResource;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Skill::all(); // Skill::paginate(8);
        return response()->json(SkillResource::collection($categories));
    }


}
