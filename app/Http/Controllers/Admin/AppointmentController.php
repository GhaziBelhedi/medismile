<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Appointment::with('patient.user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient.user', fn($q) =>
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
            );
        }

        $appointments = $query->paginate(15);

        return view('admin.appointments.index', compact('appointments'));
    }

    public function show(Appointment $appointment): View
    {
        $appointment->load(['patient.user', 'patient.notes.dentist']);

        return view('admin.appointments.show', compact('appointment'));
    }

    public function create(): View
    {
        $patients = Patient::with('user')->get();

        return view('admin.appointments.create', compact('patients'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'date'       => 'required|date|after_or_equal:today',
            'time'       => 'required',
            'reason'     => 'required|string|max:500',
            'status'     => 'required|in:pending,confirmed,cancelled',
        ]);

        Appointment::create($request->only('patient_id', 'date', 'time', 'reason', 'status'));

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Rendez-vous créé avec succès.');
    }

    public function edit(Appointment $appointment): View
    {
        $patients = Patient::with('user')->get();

        return view('admin.appointments.edit', compact('appointment', 'patients'));
    }

    public function update(Request $request, Appointment $appointment): RedirectResponse
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'date'       => 'required|date',
            'time'       => 'required',
            'reason'     => 'required|string|max:500',
            'status'     => 'required|in:pending,confirmed,cancelled',
        ]);

        $appointment->update($request->only('patient_id', 'date', 'time', 'reason', 'status'));

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Rendez-vous mis à jour avec succès.');
    }

    public function destroy(Appointment $appointment): RedirectResponse
    {
        $appointment->delete();

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Rendez-vous supprimé avec succès.');
    }

    public function confirm(Appointment $appointment): RedirectResponse
    {
        $appointment->update(['status' => 'confirmed']);

        return back()->with('success', 'Rendez-vous confirmé.');
    }

    public function cancel(Appointment $appointment): RedirectResponse
    {
        $appointment->update(['status' => 'cancelled']);

        return back()->with('success', 'Rendez-vous annulé.');
    }
}
