<?php

namespace App\Http\Controllers\Api;

use App\Models\ProjectScope;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectScopeRequest;
use App\Http\Requests\UpdateProjectScopeRequest;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\ProjectScopeResource;
use App\Models\AuditProject;
use App\Services\ProjectScopeService;

class ProjectScopeController extends Controller
{
    public function __construct(
        protected ProjectScopeService $projectScopeService,
        public ?AuditProject $auditProject = null
    ) {
        $this->projectScopeService = new ProjectScopeService($auditProject);
        //$this->authorizeResource(ProjectScope::class, 'projectScope');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getScopes(AuditProject $auditProject)
    {
        $this->authorize('viewAny', [projectScope::class,$auditProject]);
        // $this->auditProject = $auditProject;
        return response()->json(ProjectScopeResource::collection($auditProject->scopes));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectScopeRequest $request, AuditProject $auditProject)
    {
        $this->authorize('create', [ProjectScope::class,$auditProject]);
       return $this->projectScopeService->create($request);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\UpdateProjectRequest  $request
     * @param  AuditProject $auditProject
     * @param  ProjectScope $scope
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectScopeRequest $request, AuditProject $auditProject, ProjectScope $scope)
    {
        $this->authorize('update', $scope);
        return $this->projectScopeService->update($request, $scope);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  AuditProject $auditProject
     * @param  ProjectScope $scope
     * @return \Illuminate\Http\Response
     */
    public function destroy(AuditProject $auditProject, ProjectScope $scope)
    {
        $this->authorize('delete', $scope);
        return $this->projectScopeService->delete($scope);
    }
}
