<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\AuditProject;
use App\Services\ProjectService;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectUserResource;
use App\Http\Requests\SyncProjectUsersRequest;

class ProjectUserController extends Controller
{
    public function __construct(
        protected ProjectService $projectService,
        protected ?AuditProject $auditProject = null
    ) {
        if ($auditProject) {
            $this->projectService->setAuditProject($auditProject);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUsers(AuditProject $auditProject)
    {
        return response()->json(ProjectUserResource::collection($auditProject->users));
    }

    public function syncUsers(SyncProjectUsersRequest $request,AuditProject $auditProject)
    {
        return $this->projectService->syncUsers($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  AuditProject $auditProject
     * @param  int $userId
     * @return \Illuminate\Http\Response
     */
    public function destroy(AuditProject $auditProject, $userId)
    {
        return $this->projectService->deleteUser($userId);
    }
}
