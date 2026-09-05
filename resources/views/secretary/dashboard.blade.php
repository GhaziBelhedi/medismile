@extends('layouts.dashboard')
@section('title', 'Tableau de bord')

@section('content')
<!-- Cartes statistiques -->
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-4">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon" style="background:#e8f0fe;">
                    <i class="bi bi-calendar-day-fill" style="color:#4d8af0;"></i>
                </div>
                <span class="text-muted small">Aujourd'hui</span>
            </div>
            <h3 class="fw-bold mb-0">{{ $appointmentsToday }}</h3>
            <p class="text-muted small mb-0">Rendez-vous du jour</p>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon" style="background:#d1e7dd;">
                    <i class="bi bi-people-fill" style="color:#198754;"></i>
                </div>
                <span class="text-muted small">Total</span>
            </div>
            <h3 class="fw-bold mb-0">{{ $totalPatients }}</h3>
            <p class="text-muted small mb-0">Patients enregistrés</p>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon" style="background:#fff3cd;">
                    <i class="bi bi-hourglass-split" style="color:#fd7e14;"></i>
                </div>
                <span class="text-muted small">Statut</span>
            </div>
            <h3 class="fw-bold mb-0">{{ $pendingCount }}</h3>
            <p class="text-muted small mb-0">En attente de confirmation</p>
        </div>
    </div>
</div>

<!-- Actions rapides -->
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <a href="{{ route('secretary.appointments.create') }}" class="btn btn-primary w-100 py-3">
            <i class="bi bi-plus-circle fs-5 d-block mb-1"></i>Nouveau rendez-vous
        </a>
    </div>
    <div class="col-md-6">
        <a href="{{ route('secretary.patients.create') }}" class="btn btn-outline-primary w-100 py-3">
            <i class="bi bi-person-plus fs-5 d-block mb-1"></i>Ajouter un patient
        </a>
    </div>
</div>

<!-- Prochains rendez-vous -->
<div class="content-card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-calendar-week me-2 text-primary"></i>Prochains rendez-vous</span>
        <a href="{{ route('secretary.appointments.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Patient</th>
                        <th>Date</th>
                        <th>Heure</th>
                        <th>Motif</th>
                        <th class="pe-4">Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($upcomingAppointments as $appt)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-semibold small">{{ $appt->patient?->user?->name ?? 'Inconnu' }}</div>
                                <div class="text-muted" style="font-size:.75rem;">{{ $appt->patient?->phone ?? 'N/A' }}</div>
                            </td>
                            <td class="small">{{ $appt->date->format('d/m/Y') }}</td>
                            <td class="small">{{ \Carbon\Carbon::parse($appt->time)->format('H\hi') }}</td>
                            <td class="small">{{ Str::limit($appt->reason, 30) }}</td>
                            <td class="pe-4">
                                <span class="badge status-badge bg-{{ $appt->getStatusBadgeClass() }}">
                                    @if($appt->status === 'pending') En attente
                                    @elseif($appt->status === 'confirmed') Confirmé
                                    @else Annulé
                                    @endif
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4 small">Aucun rendez-vous à venir.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
