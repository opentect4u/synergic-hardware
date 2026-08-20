<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Hash;
use App\Models\User;

class LoginController extends Controller
{
    // public function __construct() {
    //     $this->middleware('guest');
    // }

    public function Show()
    {
        return view('login');
    }

    public function Login(Request $request)
    {
        $login = trim($request->input('email', ''));
        $password = $request->input('password', '');
        $user = User::where('user_status', 'A')
            ->where(function ($query) use ($login) {
                $query->where('email', $login)
                    ->orWhere('user_name', $login);
            })
            ->first();

        if ($user && Auth::attempt([
            'email' => $user->email,
            'password' => $password,
            'user_status' => 'A',
        ])) {
            $auditId = DB::table('td_audit_trail')->insertGetId([
                'login_dt' => now(),
                'user_id' => (string) $user->id,
                'user_name' => $user->user_name,
                'terminal_name' => null,
                'logout_dt' => null,
            ]);
            $request->session()->put('audit_trail_id', $auditId);

            return redirect()->intended('dashboard');
        }

        return redirect()->back()
            ->withInput($request->only('email'))
            ->with('error', 'The username/email or password is incorrect.');
    }

    public function logout(Request $request) {
        $auditId = $request->session()->get('audit_trail_id');
        if ($auditId) {
            DB::table('td_audit_trail')
                ->where('sl_no', $auditId)
                ->update(['logout_dt' => now()]);
        }

        session()->flush();
        Auth::guard('web')->logout();
        // Auth::logout();

        return redirect()->route('dashboard');
        //        return redirect('/login');
    }

    public function ShowChangePassword()
    {
        return view('change_password');
    }

    public function ChangePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Password changed successfully.');
    }
}