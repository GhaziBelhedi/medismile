<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalPatients      = Patient::count();
        $appointmentsToday  = Appointment::whereDate('date', today())->count();
        $pendingCount       = Appointment::where('status', 'pending')->count();
        $confirmedCount     = Appointment::where('status', 'confirmed')->count();
        $recentAppointments = Appointment::with('patient.user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPatients',
            'appointmentsToday',
            'pendingCount',
            'confirmedCount',
            'recentAppointments'
        ));
    }
}
