<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Log;
use Symfony\Component\HttpFoundation\Response;

class MustVerifyEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if ($user && $user->hasRole('School Admin')) {
            $mainUser = DB::connection('mysql')->table('users')->where('email', $user->email)->first();

            if ($mainUser && !is_null($mainUser->email_verified_at)) {
                // Main DB is verified! Sync to Tenant DB if not already verified
                if (!$user->hasVerifiedEmail()) {
                    $user->email_verified_at = $mainUser->email_verified_at;
                    $user->save();
                }
            } else {
                // Main DB is NOT verified
                if (!$user->hasVerifiedEmail()) {
                    return redirect('/email/verify');
                } else {
                    // Tenant DB IS verified (somehow). Sync to Main DB!
                    if ($mainUser && is_null($mainUser->email_verified_at)) {
                        DB::connection('mysql')->table('users')->where('email', $user->email)->update(['email_verified_at' => Carbon::now()]);
                    }
                }
            }
        }
        return $next($request);
    }
}
