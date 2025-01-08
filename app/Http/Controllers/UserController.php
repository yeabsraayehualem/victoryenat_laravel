<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
        public function register(Request $request)
        {
            $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
            ]);
            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->phone = "0987654321";
            $user->password = bcrypt($request->password);
            $user->role="staff";
            $user->save();
            return redirect('/login');
        }
        public function login(Request $request)
    {
        // Validate login credentials
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Attempt login
        if (Auth::attempt($request->only('email', 'password'))) {
            $role = Auth::user()->role;
            if ($role === 'staff') {
                return redirect()->route('staff.dashboard');
            } elseif ($role === 'student') {
                return redirect()->route('student.dashboard');
            } 
            elseif ($role === 'teacher') {
                return redirect()->route('teacher.dashboard');
            } 
            elseif ($role === 'school_manager') {
                return redirect()->route('manager.dashboard');
            }
            else {
                return redirect('/')->with('error', 'Unauthorized role.');
            }
        }

        // Login failed
        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->withInput();
    }
public function dashboard(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;
        if ($role === 'staff') {
            return redirect()->route('staff.dashboard');
        } elseif ($role === 'student') {
            return  redirect()->route('student.dashboard');
        }  elseif ($role === 'teacher') {
            return redirect()->route('teacher.dashboard');
        } elseif ($role === 'school_manager') {
            return redirect()->route('manager.dashboard');
        }
        else {
            return redirect('/')->with('error', 'Unauthorized role.');
        }
    }
    /**
     * Handle logout.
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'You have been logged out.');
    }
}
