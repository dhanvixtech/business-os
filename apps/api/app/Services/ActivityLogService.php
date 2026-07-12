<?php

namespace App\Services;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLogService
{
    public function log(
        string $description,
        ?Model $subject = null,
        array $properties = [],
        ?Authenticatable $causer = null
    ): void {
        activity()
            ->causedBy($causer ?? Auth::user())
            ->performedOn($subject)
            ->withProperties($properties)
            ->log($description);
    }
}
