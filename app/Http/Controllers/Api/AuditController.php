<?php

namespace App\Http\Controllers\Api;

use App\Models\ProjectUser;
use App\Models\AuditProject;
use Illuminate\Http\Request;
use App\Services\ProjectService;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuditCollection;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\SyncProjectUsersRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\AuditProjectResource;

class AuditController extends Controller
{
    public function __construct(
        protected ProjectService $projectService,
    ) {
        //$this->authorizeResource(AuditProject::class, 'auditProject');
    }

    public function index(Request $request)
    {
        $audits = AuditProject::with('users','status')->filter()->paginate(8);
        //return response()->json(AuditProjectResource::collection($audits));
        return new AuditCollection($audits);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        //$this->authorize('create', AuditProject::class);
        return $this->projectService->create($request);
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$this->authorize('view', $id);
        return $this->projectService->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\UpdateProjectRequest  $request
     * @param  int  $auditProject
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, $auditProject)
    {
        //$this->authorize('update', $id);
        return $this->projectService->updateProjectDetails($request,$auditProject);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->projectService->delete($id);
    }

    public function lead(Request $request)
    {
        $audits =ProjectUser::with(['user','role','status'])
        ->whereHas('user', function ($q) {
            $q->where('id', auth()->id());
        })
        ->filter()
        ->lead()
        ->paginate(8);
        return new AuditCollection($audits);
    }

    public function me(Request $request)
    {
        $audits = auth()->user()->myProjects()->filter()->with('status')->paginate(8);
        return new AuditCollection($audits);
    }
}
