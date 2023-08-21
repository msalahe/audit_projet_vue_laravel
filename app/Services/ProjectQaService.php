<?php

namespace App\Services;

use App\Http\Resources\AuditProjectResource;
use App\Http\Resources\ProjectQAResource;
use App\Models\AuditProject;

class ProjectQaService
{
    public function __construct(
        public AuditProject $auditProject
    ) {
    }

    public function create($request)
    {

        try {
            $qa = $this->auditProject->qas()->create([
                'name' => $request->name,
                'link' => $request->link,
                'quality' => $request->quality,

            ]);
            return response()->json([
                'status' => 'success',
                'project' => new ProjectQAResource($qa)
            ]);
        } catch (\Exception $e) {
            logger(' Error storing project qa' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error storing qa' . $e->getMessage(),
            ], 400);
        }
    }

    public function update($request, $id)
    {
        try {
            $qa = $this->auditProject->qas()->findOrFail($id)->update([
                'name' => $request->name,
                'link' => $request->link,
                'quality' => $request->quality,

            ]);
            return response()->json([
                'status' => 'success',
                'project' => new ProjectQAResource($qa)
            ]);
        } catch (\Exception $e) {
            logger('Error updating qa' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error updating qa',
            ], 400);
        }
    }

    public function delete($id)
    {
        try {
            $qa = $this->auditProject->qas()->findOrFail($id)->delete();
            return response()->json([
                'status' => 'success',
            ]);
        } catch (\Exception $e) {
            logger(' Error deleting qa ' . $id . ' ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting qa',
            ], 400);
        }
    }
}
