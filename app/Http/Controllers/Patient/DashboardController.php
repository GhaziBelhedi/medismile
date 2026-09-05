<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $patient      = auth()->user()->patient;
        $appointments = $patient
            ? $patient->appointments()->latest()->take(5)->get()
            : collect();

        $upcomingCount  = $patient ? $patient->appointments()->whereDate('date', '>=', today())->where('status', '!=', 'cancelled')->count() : 0;
        $confirmedCount = $patient ? $patient->appointments()->where('status', 'confirmed')->count() : 0;
        $pendingCount   = $patient ? $patient->appointments()->where('status', 'pending')->count() : 0;

        return view('patient.dashboard', compact(
            'appointments',
            'upcomingCount',
            'confirmedCount',
            'pendingCount'
        ));
    }
}
