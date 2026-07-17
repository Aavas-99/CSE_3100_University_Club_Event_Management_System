<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        if ($user->role === 'admin') {
            return view('admin.profile.edit', compact('user'));
        }

        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'confirmed', 'min:8'],
        ];

        if ($user->role !== 'admin') {
            $rules = array_merge($rules, [
                'student_id' => ['required', 'string', 'max:50'],
                'department' => ['required', 'string', 'max:100'],
                'phone' => ['required', 'string', 'max:20'],
            ]);
        }

        $data = $request->validate($rules);

        if (!blank($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->fill($data);
        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }
}
