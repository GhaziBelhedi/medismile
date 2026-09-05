<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Models\Patient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NoteController extends Controller
{
    public function create(Patient $patient): View
    {
        return view('admin.notes.create', compact('patient'));
    }

    public function store(Request $request, Patient $patient): RedirectResponse
    {
        $request->validate([
            'note' => 'required|string|max:2000',
        ]);

        Note::create([
            'patient_id' => $patient->id,
            'dentist_id' => auth()->id(),
            'note'       => $request->note,
        ]);

        return redirect()->route('admin.patients.show', $patient)
            ->with('success', 'Note ajoutée avec succès.');
    }
}
