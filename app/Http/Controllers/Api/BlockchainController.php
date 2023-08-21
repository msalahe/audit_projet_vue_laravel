<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlockchainResource;
use App\Models\Blockchain;
use Illuminate\Http\Request;

class BlockchainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blockchains = Blockchain::all(); // Blockchain::paginate(8);
        return response()->json(BlockchainResource::collection($blockchains));
    }

}
