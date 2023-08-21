<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AuditProject;
use App\Models\ProjectBestPractice;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectBestPracticePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AuditProject  $auditProject
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user,AuditProject  $auditProject)
    {
        /* isProjectMember or
        isAdmin ) or
        isCompleted */

        return $user->can('view',$auditProject);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProjectBestPractice  $projectBestPractice
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ProjectBestPractice $projectBestPractice)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProjectBestPractice  $projectBestPractice
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ProjectBestPractice $projectBestPractice)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProjectBestPractice  $projectBestPractice
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ProjectBestPractice $projectBestPractice)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProjectBestPractice  $projectBestPractice
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ProjectBestPractice $projectBestPractice)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProjectBestPractice  $projectBestPractice
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ProjectBestPractice $projectBestPractice)
    {
        //
    }
}
