<?php

namespace App\Services;

use App\Http\Resources\AuditProjectResource;
use App\Models\AuditProject;

class ProjectService
{
    protected AuditProject $auditProject;
    public function __construct()
    {
    }

    public function create($request)
    {

        try {
            $project = auth()->user()->myProjects()->create([
                'name' => $request->projet_name,
                'client' => $request->client_name,
                'start_date' => $request->start_date,
                'finish_date' => $request->finish_date,
                'description' => $request->description,
                

            ]);
            return response()->json([
                'status' => 'success',
                'project' => new AuditProjectResource($project)
            ]);
        } catch (\Exception $e) {
            logger(' Error storing project' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error storing ' . $e->getMessage(),
            ], 400);
        }
    }

    public function show($id)
    {
        try {
            $project = AuditProject::with('languages','creator','blockchains','tags','users')->findOrFail($id);
            return response()->json([
                'status' => 'success',
                'project' => new AuditProjectResource($project),
                'stats' => $this->getStats($id)
            ]);
        } catch (\Exception $e) {
            logger(' Error finding project ' . $id . ' ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Project not found',
            ], 400);
        }
    }

    public function updateProjectDetails($request, $id)
    {
        try {
            $project = AuditProject::findOrFail($id);
            $this->setAuditProject($project);

            $project->update([
                'name' => $request->detail["name"],
                'client' => $request->detail["client_name"],
                'start_date' => $request->detail["start_date"],
                'finish_date' => $request->detail["finish_date"],
                'description' => $request->detail["description"],
                'summary' => $request->summary["description"],
                'disclaimer' => $request->summary["Disclaimer"],
                'findings' => $request->key_fiding["description"],
                'conclusion' => $request->conclusion,
                
            ]);
            
            if ($request->has('tags')) {
                $project->tags()->sync($request->tags);
            }

            if ($request->has('languages')) {
                $project->languages()->sync($request->languages);
            }
        } catch (\Exception $e) {
            logger(' Error finding project ' . $id . ' ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Project not found',
            ], 400);
        }
    }

    public function delete($id)
    {
        try {
            $project = AuditProject::findOrFail($id)->delete();
            return response()->json([
                'status' => 'success',
            ]);
        } catch (\Exception $e) {
            logger(' Error deleting project ' . $id . ' ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting',
            ], 400);
        }
    }

    public function syncTags()
    {
    }

    public function syncUsers($request)
    {
        if ($request->has('users')) {
            //return $this->auditProject->users()->sync($request->users, $request->roles);

            $this->auditProject->users()->sync([]);
        }
        return;
    }

    public function deleteUser($id)
    {
        return $this->auditProject->users()->detach($id);
    }

    public function setAuditProject(AuditProject $auditProject)
    {
        $this->auditProject = $auditProject;
    }
    public function getStats($id)
    {
        try {
            $project = AuditProject::with('issues')->findOrFail($id);
            $project_issues = $project->issues();
            $issues['by_severity'] = $project_issues
                ->selectRaw('(impact * likelihood) as severityy, count(*) as count')
                ->addSelect('impact', 'likelihood')
                ->groupBy('severityy')
                ->get()
                ->pluck('count', 'severity');

            $issues['by_user'] = $project_issues
                ->join('users', 'users.id', '=', 'project_issues.user_id')
                ->selectRaw('project_issues.user_id, users.full_name as full_name ,count(*) as count')
                ->groupBy('project_issues.user_id', 'users.full_name')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item['user_id'] => ['full_name' => $item['full_name'], 'count' => $item['count']]];
                });
            $issues['by_day'] = $project_issues
                ->selectRaw('DATE(project_issues.created_at) as day, count(*) as count')
                ->groupBy('day')
                ->pluck('count', 'day');



            return response()->json([
                'status' => 'success',
                'issues' => $issues,

            ]);
        } catch (\Exception $e) {
            logger(' Error finding project ' . $id . ' ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error getting stats ' . $e->getMessage(),
            ], 400);
        }
    }
}
