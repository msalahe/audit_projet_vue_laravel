<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectScopeFile extends Model
{
    use HasFactory;
/**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'file_path',
        'hash',
        'project_id',
        'status_id',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(AuditProject::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
