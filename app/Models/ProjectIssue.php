<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Ramsey\Uuid\Type\Integer;

class ProjectIssue extends Model
{
    use HasFactory;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['severity'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'attack_scenario',
        'recommendation',
        'updates',
        'likelihood',
        'impact',
        'status',
        'state',
        'user_id',
        'project_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'severity' => 'string',
        'impact' => 'integer',
        'likelihood' => 'integer',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(ProjectIssue::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the issue's severity
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function severity(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $this->getSeverity($attributes['impact'] *  $attributes['likelihood'])
        );
    }

    public function scopeApproved($query)
    {
        return $query->where('state', 'Approved');
    }

    public function getSeverity($severity) : string
    {
        match ($severity) {
            9 => $severity = 'Critical',
            6 => $severity = 'High',
            3, 4 => $severity = 'Medium',
            2 => $severity = 'Low',
            0 => $severity = 'Informational',
            default => $severity = 'Undetermined',
        };

        return $severity;
    }
}
