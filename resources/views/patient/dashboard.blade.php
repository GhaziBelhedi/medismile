@extends('layouts.dashboard')
@section('title', 'Mon tableau de bord')

@section('content')
{{-- Welcome banner --}}
<div class="p-4 mb-4 rounded-4 text-white position-relative overflow-hidden"
     style="background: linear-gradient(135deg, #1a2236 0%, #2d4270 100%);">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3" style="position:relative;z-index:1;">
        <div>
            <h4 class="fw-bold mb-1">Bonjour, {{ auth()->user()->name }} !</h4>
            <p class="mb-0 opacity-75 small">Bienvenue sur votre espace patient MediSmile.</p>
        </div>
        <a href="{{ route('patient.appointments.create') }}" class="btn btn-light fw-semibold shadow-sm">
            <i class="fa-solid fa-calendar-plus me-1"></i>Prendre un rendez-vous
        </a>
    </div>
    {{-- Decorative circle --}}
    <div style="position:absolute;right:-40px;top:-40px;width:200px;height:200px;border-radius:50%;background:rgba(255,255,255,.04);"></div>
</div>

{{-- Next appointment banner (if any upcoming confirmed) --}}
@php
    $patient = auth()->user()->patient;
    $next = $patient?->appointments()
        ->where('status', 'confirmed')
        ->whereDate('date', '>=', today())
        ->orderBy('date')->orderBy('time')
        ->first();
@endphp
@if($next && $next->timeRemaining)
<div class="alert border-0 mb-4 d-flex align-items-center gap-3 rounded-4"
     style="background:#eff6ff; border-left: 4px solid #4d8af0 !important; border-left-style:solid !important;">
    <i class="fa-solid fa-circle-check fa-xl" style="color:#4d8af0;"></i>
    <div class="flex-grow-1">
        <div class="fw-bold" style="color:#1d4ed8;">
            Prochain rendez-vous confirmé — {{ $next->timeRemaining }}
        </div>
        <div class="text-muted small">
            Le {{ $next->date->format('d/m/Y') }} à {{ \Carbon\Carbon::parse($next->time)->format('H\hi') }}
            · {{ Str::limit($next->reason, 40) }}
        </div>
    </div>
    <a href="{{ route('patient.appointments.show', $next) }}" class="btn btn-sm btn-outline-primary">
        Voir <i class="fa-solid fa-arrow-right ms-1"></i>
    </a>
</div>
@endif

{{-- Stats --}}
<div class="row g-4 mb-4">
    <div class="col-sm-4">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon" style="background:#e8f0fe;">
                    <i class="fa-solid fa-calendar-check" style="color:#4d8af0;"></i>
                </div>
                <span class="text-muted small">À venir</span>
            </div>
            <h3 class="fw-bold mb-0">{{ $upcomingCount }}</h3>
            <p class="text-muted small mb-0">Rendez-vous à venir</p>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon" style="background:#d1e7dd;">
                    <i class="fa-solid fa-circle-check" style="color:#198754;"></i>
                </div>
                <span class="text-muted small">Statut</span>
            </div>
            <h3 class="fw-bold mb-0">{{ $confirmedCount }}</h3>
            <p class="text-muted small mb-0">Confirmés</p>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon" style="background:#fff3cd;">
                    <i class="fa-solid fa-hourglass-half" style="color:#fd7e14;"></i>
                </div>
                <span class="text-muted small">Statut</span>
            </div>
            <h3 class="fw-bold mb-0">{{ $pendingCount }}</h3>
            <p class="text-muted small mb-0">En attente</p>
        </div>
    </div>
</div>

{{-- Recent appointments table --}}
<div class="content-card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fa-solid fa-clock-rotate-left me-2 text-primary"></i>Mes derniers rendez-vous</span>
        <a href="{{ route('patient.appointments.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Date</th>
                        <th>Heure</th>
                        <th>Motif</th>
                        <th>Temps restant</th>
                        <th class="pe-4">Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appt)
                        <tr onclick="window.location='{{ route('patient.appointments.show', $appt) }}'">
                            <td class="ps-4 small fw-semibold">{{ $appt->date->format('d/m/Y') }}</td>
                            <td class="small">{{ \Carbon\Carbon::parse($appt->time)->format('H\hi') }}</td>
                            <td class="small">{{ Str::limit($appt->reason, 35) }}</td>
                            <td>
                                @if($appt->timeRemaining && $appt->status !== 'cancelled')
                                    <span class="badge time-badge bg-{{ $appt->timeRemainingClass }} bg-opacity-15 text-{{ $appt->timeRemainingClass }}">
                                        <i class="fa-regular fa-clock me-1"></i>{{ $appt->timeRemaining }}
                                    </span>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td class="pe-4">
                                <span class="badge status-badge bg-{{ $appt->getStatusBadgeClass() }}">
                                    @if($appt->status === 'pending') En attente
                                    @elseif($appt->status === 'confirmed') Confirmé
                                    @else Annulé @endif
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none">
                                        <rect x="3" y="4" width="18" height="17" rx="2" fill="#f0f4ff" stroke="#c7d4f0" stroke-width="1.5"/>
                                        <rect x="3" y="4" width="18" height="6" rx="2" fill="#dce8ff"/>
                                        <line x1="3" y1="10" x2="21" y2="10" stroke="#c7d4f0" stroke-width="1.5"/>
                                        <line x1="8" y1="2" x2="8" y2="6" stroke="#4d8af0" stroke-width="1.5" stroke-linecap="round"/>
                                        <line x1="16" y1="2" x2="16" y2="6" stroke="#4d8af0" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M9 16.5 Q12 19.5 15 16.5" stroke="#4d8af0" stroke-width="1.5" fill="none" stroke-linecap="round"/>
                                        <circle cx="9.5" cy="14" r=".8" fill="#4d8af0"/>
                                        <circle cx="14.5" cy="14" r=".8" fill="#4d8af0"/>
                                    </svg>
                                    <h5>Aucun rendez-vous pour le moment</h5>
                                    <p>Commencez par prendre votre premier rendez-vous.</p>
                                    <a href="{{ route('patient.appointments.create') }}" class="btn btn-primary btn-sm">
                                        <i class="fa-solid fa-calendar-plus me-1"></i>Prendre un rendez-vous
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
