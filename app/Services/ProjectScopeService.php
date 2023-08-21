<?php

namespace App\Services;

use App\Http\Resources\AuditProjectResource;
use App\Http\Resources\ProjectScopeResource;
use App\Models\AuditProject;
use App\Models\ProjectScope;

class ProjectScopeService
{
    public function __construct(
        public AuditProject $auditProject,
    ) {}

    public function create($request)
    {
        try {
            $scope = $this->auditProject->scopes()->create([
                'name' => $request->name,
                'link' => $request->link,
                'value' => $request->value,
                'type' => $request->type,
                'status_id' => $request->status,
            ]);
            return response()->json([
                'status' => 'success',
                'scope' => new ProjectScopeResource($scope)
            ]);
        } catch (\Exception $e) {
            logger(' Error storing scope' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error storing ' . $e->getMessage(),
            ], 400);
        }
    }



    public function update($request,ProjectScope $scope)
    {
       auth()->user()->can('create', [ProjectScope::class,$this->auditProject]);
       try {

            $scope->update([
                'name' => $request->name,
                'link' => $request->link,
                'value' => $request->value,
                'type' => $request->type,
                'status_id' => $request->status,
            ]);



        } catch (\Exception $e) {
            logger(' Error updating scope ' . $scope->id . ' ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Scope not found',
            ], 400);
        }
    }

    public function delete(ProjectScope $scope)
    {
        try {
            $scope->delete();
            return response()->json([
                'status' => 'success',
            ]);
        } catch (\Exception $e) {
            logger(' Error deleting scope ' . $scope . ' ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting',
            ], 400);
        }
    }


}
