<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectScope extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type',
        'link',
        'value',
        'status_id',
        'project_id',
    ];

    public function scopeFiles():HasMany
    {
        return $this->hasMany(ProjectScopeFile::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(AuditProject::class,'project_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
}
