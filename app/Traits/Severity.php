<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait Severity{

    public function initializeSeverity()
    {
        $this->appends[] = 'severity';
        $this->casts[] =  [
            'severity' => 'string',
            'impact' => 'integer',
            'likelihood' => 'integer',
        ];
    }
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    /* protected $appends = ['severity']; */

    /**
     * Get the issue's severity
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function severity(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $this->getSeverity((integer) $attributes['impact'] *  (integer) $attributes['likelihood'])
        );
    }

    protected function getSeverity($severity) : string
    {
        match ($severity) {
            9 => $severity = 'Critical',
            6 => $severity = 'High',
            3, 4 => $severity = 'Medium',
            2 => $severity = 'Low',
            0 => $severity = 'Infomational',
            default => $severity = 'Undetermined',
        };

        return $severity;
    }
}
