<?php

namespace App\Http\Middleware;

use App\Services\CachingService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SwitchDatabase
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $school_database_name = Session::get('school_database_name');
        if ($school_database_name) {
            DB::setDefaultConnection('school');
            Config::set('database.connections.school.database', $school_database_name);
            DB::purge('school');
            DB::connection('school')->reconnect();
            DB::setDefaultConnection('school');
            if (Auth::user()) {
                // Isolate Spatie's in-memory array cache by tenant database
                app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
                Config::set('permission.cache.key', 'spatie.permission.cache.' . $school_database_name);
                app()->make(\Spatie\Permission\PermissionRegistrar::class)->initializeCache();

                // Clear the explicitly cached relations so Spatie is forced to re-query the new connection
                Auth::user()->unsetRelation('roles');
                Auth::user()->unsetRelation('permissions');

                return $next($request);
            }
            return redirect()->back()->with('error', 'Invalid credential.');
        } else {
            DB::purge('school');
            DB::connection('mysql')->reconnect();
            DB::setDefaultConnection('mysql');
        }

        return $next($request);
    }
}
