<?php

namespace App\Services;

use App\Models\AuditProject;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ProjectTestScenarioResource;

class ProjectTestScenarioService
{
    public function __construct(
        public AuditProject $auditProject
    ) {
    }

    public function create($request)
    {

        try {
            DB::beginTransaction();
            $test_scenario = $this->auditProject->testScenarios()->create([
                'test_scenario' => $request->test_scenario,
                'test_status' => $request->test_status,
            ]);


            DB::commit();

            return response()->json([
                'status' => 'success',
                'projectBp' => new ProjectTestScenarioResource($test_scenario)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            logger(' Error storing project test scenario' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error storing test scenario ' . $e->getMessage(),
            ], 400);
        }
    }

    public function update($request, $id)
    {
        try {
            DB::beginTransaction();
            $test_scenario = $this->auditProject->testScenarios()->findOrFail($id)->update([
                'test_scenario' => $request->test_scenario,
                'test_status' => $request->test_status,
            ]);

            DB::commit();
            return response()->json([
                'status' => 'success',
                'project' => new ProjectTestScenarioResource($test_scenario)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            logger('Error updating test scenario' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error updating test scenario',
            ], 400);
        }
    }

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
