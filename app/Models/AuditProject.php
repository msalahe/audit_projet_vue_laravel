<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AuditProject extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    //protected $table = 'audit_projects';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    public function bestPractices(): HasMany
    {
        return $this->hasMany(ProjectBestPractice::class,'project_id');
    }

    public function blockchains(): BelongsToMany
    {
        return $this->belongsToMany(Blockchain::class, 'project_blockchains','project_id')->withTimestamps();
    }

    public function contractCoverages(): HasMany
    {
        return $this->hasMany(ProjectScopeFile::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function issues(): HasMany
    {
        return $this->hasMany(ProjectIssue::class,'project_id');
    }

    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'project_languages','project_id')->withTimestamps();
    }

    public function qas(): HasMany
    {
        return $this->hasMany(ProjectQa::class,'project_id');
    }

    public function scopes(): HasMany
    {
        return $this->hasMany(ProjectScope::class,'project_id');
    }

    public function scopeFiles(): HasMany
    {
        return $this->hasMany(ProjectScopeFile::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class,'project_tag','project_id')->withTimestamps();
    }

    public function tests(): HasMany
    {
        return $this->hasMany(ProjectTest::class,'project_id');
    }

    public function testScenarios(): HasMany
    {
        return $this->hasMany(ProjectTestScenario::class,'project_id');
    }

    public function totalCoverages(): HasMany
    {
        return $this->hasMany(ProjectTotalCoverage::class,'project_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'project_user','project_id')->using(ProjectUser::class)->withPivot('role_id')->withTimestamps();
    }

    public function scopeFilter($query)
    {
        $query->when(request('status') != '', function ($qu) {
            return $qu->where('status_id',request('status'));
        });

        $query->when(request('language') != '', function ($qu) {
            return $qu->whereHas('languages', function ($q) {
                return $q->where('skills.id',  request('language'));
            });
        });

        $query->when(request('tag') != '', function ($qu) {
            return $qu->whereHas('tags', function ($q) {
                return $q->where('tags.id', request('tag'));
            });
        });

        $query->when(request('name') != '', function ($qu) {
            return $qu->where('name', 'LIKE', '%' . request('name') . '%');
        });

        return $query;
    }

    public function scopeLead($query)
    {
            return $query->whereHas('users', function ($q) {
                $q->where('project_user.user_id', auth()->id())
                  ->where('project_user.role_id', Role::where('name','Lead Auditor')->first()->id);
            });

    }

}
