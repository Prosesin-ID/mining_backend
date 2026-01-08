<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UnitTruck;
use Illuminate\View\View;
use App\Models\CheckPoint;
use Illuminate\Http\Request;
use App\Models\DriverLogActivity;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class AuthUserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('guest', except: ['home', 'logout']),
            new Middleware('auth', only: ['home', 'logout']),
        ];
    }

    public function register(): View
    {
        return view('auth.register');
    }
    
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|string|email:rfc,dns|max:250|unique:users,email',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);

        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->route('home')
            ->withSuccess('You have successfully registered & logged in!');
    }

    public function login(): View
    {
        return view('auth.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials))
        {
            $request->session()->regenerate();
            return redirect()->intended('home');
        }

        return back()->withErrors([
            'email' => 'Your provided credentials do not match in our records.',
        ])->onlyInput('email');

    }
    
    public function home()
    {
        $trucks = UnitTruck::count();
        $checkpoints = CheckPoint::count();
        $onLocationDrivers = DriverLogActivity::where('status', 'on_location')->count();
        $maintenanceTrucks = UnitTruck::where('status', 'maintenance')->count();   
        $completedDrivers = DriverLogActivity::where('status', 'selesai')->count();
        $notCheckOutDrivers = DriverLogActivity::whereNull('check_Out')->count();
        $mtTruckDatas = UnitTruck::where('status', 'maintenance')->with('driver')->get();
        $logs = DriverLogActivity::with('driver.unitTruck', 'checkPoint')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('auth.home', compact('trucks', 'checkpoints', 'onLocationDrivers', 'maintenanceTrucks', 
        'logs', 'mtTruckDatas', 'completedDrivers', 'notCheckOutDrivers'));
    } 
    
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
            ->withSuccess('You have logged out successfully!');
    }
    
    /**
     * Get checkpoint locations for map
     */
    public function getCheckpointLocations()
    {
        // Log immediately at method entry
        error_log("===== CHECKPOINT LOCATIONS METHOD CALLED =====");
        \Log::info('===== Getting checkpoint locations =====');
        \Log::info('Request URL: ' . request()->url());
        \Log::info('Request method: ' . request()->method());
        
        try {
            
            $checkpoints = CheckPoint::where('status', 'active')->get();
            
            \Log::info('Found checkpoints: ' . $checkpoints->count());
            
            $data = $checkpoints->map(function ($checkpoint) {
                return [
                    'id' => $checkpoint->id,
                    'name' => $checkpoint->name ?? 'Checkpoint ' . $checkpoint->id,
                    'latitude' => (float) $checkpoint->latitude,
                    'longitude' => (float) $checkpoint->longitude,
                    'status' => $checkpoint->status,
                    'radius' => $checkpoint->radius ?? 100,
                    'kategori' => $checkpoint->kategori,
                ];
            });

            \Log::info('Mapped data count: ' . $data->count());

            $response = [
                'success' => true,
                'data' => $data,
                'count' => $data->count(),
            ];
            
            \Log::info('Sending response...');

            return response()->json($response);
        } catch (\Exception $e) {
            \Log::error('===== Error in getCheckpointLocations =====');
            \Log::error('Error: ' . $e->getMessage());
            \Log::error('Line: ' . $e->getLine());
            \Log::error('Trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to get checkpoint locations',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}