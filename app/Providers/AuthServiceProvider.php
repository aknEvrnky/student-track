<?php

namespace App\Providers;

use App\Policies\RolePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Policies\ActivityPolicy;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Activity::class => ActivityPolicy::class,
        Role::class => RolePolicy::class,
    ];
}
