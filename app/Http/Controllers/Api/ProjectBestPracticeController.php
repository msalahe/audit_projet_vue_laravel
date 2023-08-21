<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\AuditProject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectUserResource;
use App\Services\ProjectBestPracticeService;
use App\Http\Requests\SyncProjectUsersRequest;
use App\Http\Resources\ProjectBestPracticeResource;
use App\Http\Requests\StoreProjectBestPracticeRequest;
use App\Http\Requests\UpdateProjectBestPracticeRequest;

class ProjectBestPracticeController extends Controller
{
    public function __construct(
        private ProjectBestPracticeService $projectBestPracticeService,
        public ?AuditProject $auditProject = null
    ) {
        $this->projectBestPracticeService = new ProjectBestPracticeService($this->auditProject);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AuditProject $auditProject)
    {
        return response()->json(ProjectBestPracticeResource::collection($auditProject->bestPractices));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function me(AuditProject $auditProject)
    {
        return $this->projectBestPracticeService->me();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreProjectBestPracticeRequest  $request
     * @param  App\Models\AuditProject $auditProject
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectBestPracticeRequest $request,AuditProject $auditProject)
    {
        return $this->projectBestPracticeService->create($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\UpdateProjectBestPracticeRequest  $request
     * @param  App\Models\AuditProject $auditProject
     * @param  int  $bestPractice
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectBestPracticeRequest $request,AuditProject $auditProject, $bestPractice)
    {
        return $this->projectBestPracticeService->update($request, $bestPractice);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  AuditProject $auditProject
     * @param  int  $bestPractice
     * @return \Illuminate\Http\Response
     */
    public function destroy(AuditProject $auditProject,  $bestPractice)
    {
        return $this->projectBestPracticeService->delete( $bestPractice);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  App\Models\AuditProject $auditProject
     * @param  int  $bestPractice
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request,AuditProject $auditProject, $bestPractice)
    {
        return $this->projectBestPracticeService->updateStatus($request, $bestPractice);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Models\AuditProject $auditProject
     * @param  int  $bestPractice
     * @return \Illuminate\Http\Response
     */
    public function updateState(AuditProject $auditProject, $bestPractice)
    {
        return $this->projectBestPracticeService->updateState($bestPractice);
    }
}
