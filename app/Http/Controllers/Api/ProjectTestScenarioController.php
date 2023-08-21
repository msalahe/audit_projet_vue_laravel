<?php

namespace App\Http\Controllers\Api;

use App\Models\AuditProject;
use Illuminate\Http\Request;
use App\Models\ProjectTestScenario;
use App\Http\Controllers\Controller;
use App\Services\ProjectTestScenarioService;
use App\Http\Requests\StoreProjectTestScenarioRequest;
use App\Http\Requests\UpdateProjectTestScenarioRequest;

class ProjectTestScenarioController extends Controller
{
    public function __construct(
        private ProjectTestScenarioService $projectTestScenarioService,
        public ?AuditProject $auditProject = null
    ) {
        $this->projectTestScenarioService = new ProjectTestScenarioService($this->auditProject);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreProjectTestScenarioRequest  $request
     * @param  App\Models\AuditProject $auditProject
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectTestScenarioRequest $request,AuditProject $auditProject)
    {
        $this->authorize('create', [ProjectTestScenario::class,$auditProject]);
        return $this->projectTestScenarioService->create($request);
    }

    /**
     * Batch update resource in storage.
     *
     * @param  App\Http\Requests\UpdateProjectTestScenarioRequest  $request
     * @param  App\Models\AuditProject $auditProject
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectTestScenarioRequest $request,AuditProject $auditProject)
    {
        $this->authorize('create', [ProjectTestScenario::class,$auditProject]);
        return $this->projectTestScenarioService->update($request,$auditProject);
    }
}
