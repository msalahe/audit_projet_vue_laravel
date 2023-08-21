<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\AuditProject;
use App\Services\ProjectQaService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectQasRequest;
use App\Http\Resources\ProjectQAResource;
use App\Http\Resources\ProjectUserResource;
use App\Http\Requests\SyncProjectUsersRequest;
use App\Http\Requests\UpdateProjectQasRequest;

class ProjectQAController extends Controller
{
    public function __construct(
        private ProjectQaService $projectQaService,
        public ?AuditProject $auditProject = null
    ) {
        $this->projectQaService = new ProjectQaService($this->auditProject);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AuditProject $auditProject)
    {
        $this->authorize('viewAny', [ProjectQa::class,$auditProject]);
        return response()->json(ProjectQAResource::collection($auditProject->qas));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreProjectQasRequest  $request
     * @param  App\Models\AuditProject $auditProject
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectQasRequest $request,AuditProject $auditProject)
    {
        $this->authorize('create', [ProjectQa::class,$auditProject]);
        return $this->projectQaService->create($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\UpdateProjectQasRequest  $request
     * @param  App\Models\AuditProject $auditProject
     * @param  int $QaId
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectQasRequest $request,AuditProject $auditProject,$QaId)
    {
        $this->authorize('update', [ProjectQa::class,$QaId]);
        return $this->projectQaService->update($request,$QaId);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  AuditProject $auditProject
     * @param  int $QaId
     * @return \Illuminate\Http\Response
     */
    public function destroy(AuditProject $auditProject, $QaId)
    {
        $this->authorize('delete', [ProjectQa::class,$QaId]);
        return $this->projectQaService->delete($QaId);
    }
}
