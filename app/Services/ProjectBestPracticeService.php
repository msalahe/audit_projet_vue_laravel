<?php

namespace App\Services;

use App\Models\AuditProject;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ProjectBestPracticeResource;
use App\Http\Resources\AuditProjectResource;

class ProjectBestPracticeService
{
    public function __construct(
        public AuditProject $auditProject
    ) {
    }

    public function create($request)
    {

        try {
            DB::beginTransaction();
            $bestPractice = $this->auditProject->bestPractices()->create([
                'title' => $request->title,
                'code' => $request->code,
                'description' => $request->description,
                'status' => "Not Fixed",
                'state' => "Draft",
                'user_id' => auth()->id(),

            ]);

            $bestPractice->files()->create([
                'root_id' => $this->auditProject->id,
                'type' => 2,
                'order' => count($this->auditProject->bestPractices),
                'file_name' => $request->file_name,
                'start_line' => $request->start_line,
                'code' => $request->code,
            ]);
            DB::commit();

            return response()->json([
                'status' => 'success',
                'projectBp' => new ProjectBestPracticeResource($bestPractice)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            logger(' Error storing project best practice' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error storing best practice ' . $e->getMessage(),
            ], 400);
        }
    }

    public function update($request, $id)
    {
        try {
            DB::beginTransaction();
            $bestPractice = $this->auditProject->bestPractices()->findOrFail($id)->update([
                'title' => $request->title,
                'code' => $request->code,
                'description' => $request->description,
            ]);
            $bestPractice->files()->where('root_id', $this->auditProject->id)->update([
                'file_name' => $request->file_name,
                'start_line' => $request->start_line,
                'code' => $request->code,
            ]);
            DB::commit();
            return response()->json([
                'status' => 'success',
                'project' => new ProjectBestPracticeResource($bestPractice)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            logger('Error updating best practice' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error updating best Practice',
            ], 400);
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $bestPractice = $this->auditProject->bestPractices()->findOrFail($id);

            $bestPractice->files()->delete();
            $bestPractice->delete();
            DB::commit();
            return response()->json([
                'status' => 'success',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            logger(' Error deleting best practice ' . $id . ' ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting best practice',
            ], 400);
        }
    }

    public function me()
    {
        $bps = $this->auditProject->bestPractices()->where('user_id', auth()->id())->get();
        return response()->json(ProjectBestPracticeResource::collection($bps));
    }

    public function updateStatus($request, $id)
    {
        try {
            DB::beginTransaction();
            $bp = $this->auditProject->bestPractices()->findOrFail($id)->update([
                'status' => $request->status
            ]);
            DB::commit();
            return response()->json([
                'status' => 'success',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            logger('Error updating best practice ' . $id . ' status ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting best practice' . $id . ' status ',
            ], 400);
        }
    }

    public function updateState($id)
    {
        try {
            DB::beginTransaction();
            $bp = $this->auditProject->bestPractices()->findOrFail($id)->update([
                'state' => 'Pending'
            ]);
            DB::commit();
            return response()->json([
                'status' => 'success',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            logger('Error updating best practice ' . $id . ' state ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting best practice' . $id . ' state ',
            ], 400);
        }
    }
}
