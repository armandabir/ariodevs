<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function show(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
        ]);

        $user = User::where('name', $credentials['username'])->first();
        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return $this->failed($request);
        }

        Auth::login($user);
        $request->session()->regenerate();
        $request->session()->put('username', $user->name);

        return redirect()->route('users.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->forget('username');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function failed(Request $request): RedirectResponse
    {
        return redirect()->route('login')
            ->withInput($request->only('username'))
            ->withErrors(['username' => 'Invalid username or password.']);
    }
}
