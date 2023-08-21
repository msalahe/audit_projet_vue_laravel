<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\AuditProject;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class User extends Authenticatable
{
    use HasFactory;
    use HasApiTokens;
    use Notifiable;
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'role' => $this->role->id
        ];
    }

    /**
     * Get the users's stats
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function stats(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->projectIssuesStats()
        );
    }

    public function bestPractices(): hasMany
    {
        return $this->hasMany(ProjectBestPractice::class);
    }

    public function myProjects(): HasMany
    {
        return $this->hasMany(AuditProject::class, 'user_id');
    }

    public function userIssues(): HasMany
    {
        return $this->hasMany(ProjectIssue::class);
    }

    public function projectIssuesStats()
    {
        return $this->userIssues()->approved()->get()->groupBy(function ($item, $key) {
            return $item->severity;
        })
            ->mapWithKeys(function ($items, $severity) {
                return [$severity => $items->count()];
            })->toArray();
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(AuditProject::class, 'project_user', 'user_id', 'project_id')
            ->using(ProjectUser::class)
            ->withPivot('role_id')->withTimestamps();
    }

    public function role(): BelongsTo
    {
        return $this->BelongsTo(Role::class);
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class)->withPivot('level')->withTimestamps();
    }

    public function socialLinks(): HasMany
    {
        return $this->hasMany(SocialLink::class);
    }

    public function hasAnyRole(array|string $roles): bool
    {
        return $this->role()->whereIn('name', $roles)->count() >0;

    }

    public function hasRole(string $role): bool
    {
        return $this->role()->where('name', $role)->count() > 0;
    }
}
