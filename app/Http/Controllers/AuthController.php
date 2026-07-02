<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register-choice');
    }

    public function showRegisterStudent()
    {
        return view('auth.register-student');
    }

    public function showRegisterOrganizer()
    {
        return view('auth.register-organizer');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'student_id' => ['required', 'string', 'max:50'],
            'department' => ['required', 'in:EEE,CSE,CE,ME,ECE,IEM,ESE,BME,URP,LE,TE,BECM,ARCH,MSE,CHE,MTE'],
            'phone' => ['required', 'string', 'max:20'],
            'role' => ['required', 'in:organizer,student'],

            // club fields for organizers
            'club_name' => ['nullable', 'string', 'max:255'],
            'club_description' => ['nullable', 'string'],
            'club_logo' => ['nullable', 'string', 'max:255'],

            // Strong password validation
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'max:255',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[^A-Za-z0-9]/',
            ],
        ]);

        // Prepare user data and create user
        $userData = $data;
        unset($userData['password_confirmation']);

        $user = User::create([
            ...array_intersect_key($userData, array_flip(['name','email','student_id','department','phone','role','profile_photo'])),
            'password' => Hash::make($data['password']),
        ]);

        // If organizer provided club details, create the club and assign organizer_id
        if ($user->role === 'organizer' && !empty($data['club_name'])) {
            \App\Models\Club::create([
                'name' => $data['club_name'],
                'description' => $data['club_description'] ?? null,
                'logo' => $data['club_logo'] ?? null,
                'organizer_id' => $user->id,
                'status' => 'active',
            ]);
        }

        // Do not auto-login; redirect to role-specific login page
        if ($user->role === 'organizer') {
            return redirect()->route('login.organizer')->with('success', 'Registration successful. Please sign in using Club Representative login.');
        }

        return redirect()->route('login.student')->with('success', 'Registration successful. Please sign in.');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    private function loginByRole(Request $request, string $role)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user?->role !== $role) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'This account is not allowed for this role login.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended('/dashboard');
    }

    public function showStudentLogin()
    {
        return view('auth.login-student');
    }

    public function loginStudent(Request $request)
    {
        return $this->loginByRole($request, 'student');
    }

    public function showOrganizerLogin()
    {
        return view('auth.login-organizer');
    }

    public function loginOrganizer(Request $request)
    {
        return $this->loginByRole($request, 'organizer');
    }

    public function showAdminLogin()
    {
        return view('auth.login-admin');
    }

    public function loginAdmin(Request $request)
    {
        return $this->loginByRole($request, 'admin');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}