<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;
    protected function redirectTo()
    {
        $userId = auth()->user()->userid;

            $joinedData = DB::connection('dohdtr')
                ->table('users')
                ->leftJoin('dts.users', 'users.userid', '=', 'dts.users.username')
                ->where('users.userid', '=', $userId)
                ->select('users.section')
                ->first();

            if ($joinedData) {
                if ($joinedData->section == 6) {
                    return RouteServiceProvider::BUDGET;
                } elseif ($joinedData->section == 105 || $userId == 2760 || $userId == 201400208
                            || $joinedData->section == 36 || $joinedData->section == 31) {
                    return RouteServiceProvider::MAIF;
                } elseif($userId == 1027 || $userId == 2660){
                    return RouteServiceProvider::ACCOUNTING;
                }elseif($joinedData->section == 7){
                    return RouteServiceProvider::CASHIER;
                }
            }
        // if (auth()->user()->roles == 'maif') {
        //     return RouteServiceProvider::MAIF;
        // } elseif (auth()->user()->roles == 'budget') {
            // return RouteServiceProvider::BUDGET;
        // }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
