<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectBestPractice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'code',
        'description',
        'status',
        'state',
        'project_id',
        'user_id',
    ];

    public function affectedFiles():HasMany
    {
        return $this->hasMany(AffectedFile::class,'root_id')->where('type', 2);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(AuditProject::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
