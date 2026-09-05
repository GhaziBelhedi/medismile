<?php

namespace App\Http\Controllers\Secretary;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $appointmentsToday = Appointment::whereDate('date', today())->count();
        $totalPatients     = Patient::count();
        $pendingCount      = Appointment::where('status', 'pending')->count();
        $upcomingAppointments = Appointment::with('patient.user')
            ->whereDate('date', '>=', today())
            ->where('status', '!=', 'cancelled')
            ->orderBy('date')
            ->orderBy('time')
            ->take(8)
            ->get();

        return view('secretary.dashboard', compact(
            'appointmentsToday',
            'totalPatients',
            'pendingCount',
            'upcomingAppointments'
        ));
    }
}
