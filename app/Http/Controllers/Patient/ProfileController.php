<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        $user    = auth()->user();
        $patient = $user->patient;

        return view('patient.profile.edit', compact('user', 'patient'));
    }

    public function update(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $user->id,
            'date_of_birth' => 'nullable|date|before:today',
            'phone'         => 'nullable|string|max:20',
            'address'       => 'nullable|string|max:500',
            'password'      => 'nullable|min:6|confirmed',
        ]);

        $user->update(['name' => $data['name'], 'email' => $data['email']]);

        if (! empty($data['password'])) {
            $user->update(['password' => $data['password']]);
        }

        $user->patient?->update([
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'phone'         => $data['phone'] ?? null,
            'address'       => $data['address'] ?? null,
        ]);

        return back()->with('success', 'Profil mis à jour avec succès.');
    }
}
