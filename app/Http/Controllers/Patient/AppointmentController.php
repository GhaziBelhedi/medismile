<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    private const START_HOUR    = '08:00';
    private const END_HOUR      = '17:00';
    private const SLOT_DURATION = 30;

    public function index(): View
    {
        $patient      = auth()->user()->patient;
        $appointments = $patient
            ? $patient->appointments()->latest()->paginate(10)
            : collect();

        return view('patient.appointments.index', compact('appointments'));
    }

    public function show(Appointment $appointment): View
    {
        $this->authorize('view', $appointment);

        $appointment->load('patient.user');

        return view('patient.appointments.show', compact('appointment'));
    }

    public function create(): View
    {
        $selectedDate = request('date', now()->addDay()->format('Y-m-d'));
        $slots        = $this->getAvailableSlots($selectedDate);

        return view('patient.appointments.create', compact('slots', 'selectedDate'));
    }

    public function slots(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate(['date' => 'required|date|after_or_equal:today']);

        return response()->json($this->getAvailableSlots($request->date));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'date'   => 'required|date|after_or_equal:today',
            'time'   => 'required',
            'reason' => 'required|string|max:500',
        ]);

        $patient = auth()->user()->patient;

        if (! $patient) {
            return back()->with('error', 'Profil patient introuvable. Veuillez contacter la clinique.');
        }

        $available = collect($this->getAvailableSlots($request->date))
            ->where('available', true)
            ->pluck('time')
            ->contains($request->time);

        if (! $available) {
            return back()
                ->with('error', 'Ce créneau n\'est plus disponible. Veuillez en choisir un autre.')
                ->withInput();
        }

        Appointment::create([
            'patient_id' => $patient->id,
            'date'       => $request->date,
            'time'       => $request->time,
            'reason'     => $request->reason,
            'status'     => 'pending',
        ]);

        return redirect()->route('patient.appointments.index')
            ->with('success', 'Rendez-vous demandé avec succès. Nous confirmerons prochainement.');
    }

    public function cancel(Appointment $appointment): RedirectResponse
    {
        $this->authorize('cancel', $appointment);

        $appointment->update(['status' => 'cancelled']);

        return back()->with('success', 'Rendez-vous annulé avec succès.');
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    private function getAvailableSlots(string $date): array
    {
        $bookedTimes = Appointment::whereDate('date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('time')
            ->map(fn($t) => Carbon::parse($t)->format('H:i'))
            ->toArray();

        $slots  = [];
        $cursor = Carbon::parse($date . ' ' . self::START_HOUR);
        $end    = Carbon::parse($date . ' ' . self::END_HOUR);

        while ($cursor < $end) {
            $timeStr = $cursor->format('H:i');
            $slots[] = [
                'time'      => $timeStr,
                'label'     => $cursor->format('H\hi'),
                'available' => ! in_array($timeStr, $bookedTimes),
            ];
            $cursor->addMinutes(self::SLOT_DURATION);
        }

        return $slots;
    }
}
