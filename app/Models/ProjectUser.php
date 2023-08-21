<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class ProjectUser extends Pivot
{

    public function rp() :BelongsTo
    {
        return $this->belongsTo(AuditProject::class,'project_id','id');
    }

    public function role() :BelongsTo
    {
         return $this->belongsTo(Role::class,'role_id');
    }

    public function user() :BelongsTo
    {
         return $this->belongsTo(User::class,'user_id');
    }

    public function scopeByUser($query,$id)
    {
        return $query->whereHas('user', function ($q) use($id){
            $q->where('id', $id);
        });
    }

    public function scopeFilter($query)
    {
        return $query->whereHas('rp', function ($q) {
            $q->filter();
        });
    }

    public function scopeLead($query)
    {
        return $query->whereHas('role', function ($q) {
            $q->where('name', 'Lead Auditor');
        });
    }

}
