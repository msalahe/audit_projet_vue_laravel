<?php

namespace App\Http\Controllers\Api;

use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StatusResource;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuses = Status::all(); // Status::paginate(8);
        return response()->json(StatusResource::collection($statuses));
    }
}
