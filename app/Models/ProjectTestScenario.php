<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectTestScenario extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'test_scenario',
        'test_status',
        'project_id'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(AuditProject::class);
    }
}
