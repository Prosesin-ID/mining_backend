<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ValidateUserMiddleware
{
    public function handle($request, Closure $next)
    {
        // 1️⃣ kalau belum login = tendang
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login dulu ya.');
        }

        // 2️⃣ kalau login tapi usernya udah kehapus = tendang + reset session
        $userId = Auth::id();
        $exists = User::where('id', $userId)->exists();

        if (!$exists) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->with('error', 'Akun tidak ditemukan, silakan login kembali.');
        }

        return $next($request);
    }

}
