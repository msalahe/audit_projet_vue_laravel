<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Status extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    public function projects(): HasMany
    {
        return $this->hasMany(AuditProject::class);
    }

    public function scope(): HasMany
    {
        return $this->hasMany(ProjectScope::class);
    }
    public function scopesFiles(): HasMany
    {
        return $this->hasMany(ProjectScopeFile::class);
    }
}
