<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;


class AdminController extends Controller
{
    public function index() {
        return view("Admin.admin", [
            'admins' => User::all()
        ]);
    }

    public function edit(User $admin) {
        return view('Admin.edit-admin', [
            'admin' => $admin
        ]);
    }

    public function update(Request $request, User $admin) {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'password' => 'nullable|max:15|min:5',
            'no_telepon' => 'nullable|max:15',
            'no_rek' => 'nullable|max:100',
            'email' => [
                'required',
                'email',
                'min:15',
                'unique:admin,email,' . $admin->id,
                'unique:customers,email',
            ],
        ]);

        if (!$request->filled('password')) {
            unset($validated['password']);
        }


        $admin->update($validated);

        return redirect('/admin')->with('success', "Berhasil mengupdate data " .  $admin->name);

    }
}
