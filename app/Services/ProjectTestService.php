<?php

namespace App\Services;

use App\Models\AuditProject;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ProjectTestResource;

class ProjectTestService
{
    public function __construct(
        public AuditProject $auditProject
    ) {
    }

    public function create($request)
    {

        try {
            DB::beginTransaction();
            $test = $this->auditProject->tests()->create([
                'introduction' => $request->introduction,
                'conclusion' => $request->conclusion,

            ]);


            DB::commit();

            return response()->json([
                'status' => 'success',
                'projectBp' => new ProjectTestResource($test)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            logger(' Error storing project test' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error storing test ' . $e->getMessage(),
            ], 400);
        }
    }

    /* public function update($request, $id)
    {
        try {
            DB::beginTransaction();
            $test = $this->auditProject->tests()->findOrFail($id)->update([
                'introduction' => $request->introduction,
                'conclusion' => $request->conclusion,
            ]);

            DB::commit();
            return response()->json([
                'status' => 'success',
                'project' => new ProjectTestResource($test)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            logger('Error updating test' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error updating test',
            ], 400);
        }
    } */

    /* public function delete($id)
    {
        try {
            DB::beginTransaction();
            $test = $this->auditProject->tests()->findOrFail($id);
            $test->delete();
            DB::commit();
            return response()->json([
                'status' => 'success',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            logger(' Error deleting test ' . $id . ' ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting test',
            ], 400);
        }
    } */
}
