<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // $userid
                $userId = auth()->user()->userid;

                $joinedData = DB::connection('dohdtr')
                    ->table('users')
                    ->leftJoin('dts.users', 'users.userid', '=', 'dts.users.username')
                    ->where('users.userid', '=', $userId)
                    ->select('users.section', 'users.division')
                    ->first();

                if ($joinedData) {
                    if ($joinedData->section == 6) {
                        return redirect(RouteServiceProvider::BUDGET);
                    } elseif ($joinedData->section == 105 || $userId == 2760 || $userId == 201400208
                                || $joinedData->section == 36 || $joinedData->section == 31) {
                        return redirect(RouteServiceProvider::MAIF);
                    }elseif($userId == 1027 || $userId == 2660){
                        return redirect(RouteServiceProvider::ACCOUNTING);
                    }elseif($joinedData->section == 7){
                        return redirect(RouteServiceProvider::CASHIER);
                    }
                }
                // if (auth()->user()->roles == 'maif') {
                    // return redirect(RouteServiceProvider::MAIF);
                // } elseif (auth()->user()->roles == 'budget') {
                //     return redirect(RouteServiceProvider::BUDGET);
                // }
            }
        }

        return $next($request);
    }
}
