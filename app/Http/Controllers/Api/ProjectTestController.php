<?php

namespace App\Http\Controllers\Api;

use App\Models\AuditProject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectTestRequest;
use App\Http\Resources\ProjectTestResource;
use App\Models\ProjectTest;
use App\Services\ProjectTestService;

class ProjectTestController extends Controller
{
    public function __construct(
        private ProjectTestService $projectTestService,
        public ?AuditProject $auditProject = null
    ) {
        $this->projectTestService = new ProjectTestService($this->auditProject);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AuditProject $auditProject)
    {
        $this->authorize('viewAny', [ProjectTest::class,$auditProject]);
        return response()->json(ProjectTestResource::collection($auditProject->tests));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreProjectTestRequest  $request
     * @param  App\Models\AuditProject $auditProject
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectTestRequest $request,AuditProject $auditProject)
    {
        $this->authorize('create', [ProjectTest::class,$auditProject]);
        return $this->projectTestService->create($request);
    }
}
