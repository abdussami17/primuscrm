<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\IpRestriction;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    // /**
    //  * Attempt to log the user into the application.
    //  * We override to enforce IP restrictions prior to authenticating.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return bool
    //  */
    // protected function attemptLogin(Request $request)
    // {
    //     $ip = $request->ip();

    //     try {
    //         $restriction = IpRestriction::first();
    //     } catch (\Throwable $e) {
    //         // If table missing or other DB error, allow login to proceed and log the issue
    //         Log::warning('IpRestriction check failed: '.$e->getMessage());
    //         return $this->guard()->attempt($this->credentials($request), $request->filled('remember'));
    //     }

    //     if ($restriction && $restriction->mode) {
    //         $mode = strtolower(trim($restriction->mode));
    //         $raw = (string) ($restriction->allowed_ips ?? '');
    //         $list = collect(preg_split('/[\r\n,]+/', $raw))->map(fn($v) => trim($v))->filter()->values()->all();

    //         // Check for admin bypass (try to find user by login identifier)
    //         $bypassAdmin = (bool) $restriction->bypass_admin;
    //         $user = null;
    //         if ($bypassAdmin) {
    //             $identifier = $request->input($this->username());
    //             if ($identifier) {
    //                 try { $user = User::where($this->username(), $identifier)->first(); } catch (\Throwable $e) { /* ignore */ }
    //             }
    //         }

    //         $isAdmin = false;
    //         if ($user) {
    //             // best-effort admin check: common flags
    //             $isAdmin = ($user->is_admin ?? false) || (isset($user->role) && strtolower($user->role) === 'admin');
    //         }

    //         // If bypass for admins and user is admin, allow login attempt
    //         if ($bypassAdmin && $isAdmin) {
    //             return $this->guard()->attempt($this->credentials($request), $request->filled('remember'));
    //         }

    //         $blocked = false;
    //         if ($mode === 'allow' || $mode === 'whitelist') {
    //             // only allow ips in list
    //             if (empty($list) || !in_array($ip, $list, true)) $blocked = true;
    //         } elseif ($mode === 'block' || $mode === 'blacklist') {
    //             // block ips in list
    //             if (!empty($list) && in_array($ip, $list, true)) $blocked = true;
    //         }

    //         if ($blocked) {
    //             if ($restriction->log_blocked) {
    //                 Log::warning('Blocked login attempt by IP', ['ip' => $ip, 'identifier' => $request->input($this->username())]);
    //             }
    //             return $this->sendIpBlockedResponse($request);
    //         }
    //     }

    //     // no restriction or allowed
    //     return $this->guard()->attempt($this->credentials($request), $request->filled('remember'));
    // }

    // /**
    //  * Throw a validation exception for blocked IP.
    //  */
    // protected function sendIpBlockedResponse(Request $request)
    // {
    //     throw ValidationException::withMessages([
    //         $this->username() => [trans('auth.ip_blocked', [], 'en') ?: 'Login from your IP address is not allowed.']
    //     ]);
    // }
}
