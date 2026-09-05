@extends('layouts.dashboard')
@section('title', 'Tableau de bord')

@section('content')
<!-- Cartes statistiques -->
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon" style="background:#e8f0fe;">
                    <i class="bi bi-people-fill" style="color:#4d8af0;"></i>
                </div>
                <span class="text-muted small">Total</span>
            </div>
            <h3 class="fw-bold mb-0">{{ $totalPatients }}</h3>
            <p class="text-muted small mb-0">Patients enregistrés</p>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon" style="background:#fff3cd;">
                    <i class="bi bi-clock-fill" style="color:#f0a500;"></i>
                </div>
                <span class="text-muted small">Aujourd'hui</span>
            </div>
            <h3 class="fw-bold mb-0">{{ $appointmentsToday }}</h3>
            <p class="text-muted small mb-0">Rendez-vous du jour</p>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon" style="background:#d1e7dd;">
                    <i class="bi bi-check-circle-fill" style="color:#198754;"></i>
                </div>
                <span class="text-muted small">Statut</span>
            </div>
            <h3 class="fw-bold mb-0">{{ $confirmedCount }}</h3>
            <p class="text-muted small mb-0">Confirmés</p>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon" style="background:#fff3cd;">
                    <i class="bi bi-hourglass-split" style="color:#fd7e14;"></i>
                </div>
                <span class="text-muted small">Statut</span>
            </div>
            <h3 class="fw-bold mb-0">{{ $pendingCount }}</h3>
            <p class="text-muted small mb-0">En attente</p>
        </div>
    </div>
</div>

<!-- Rendez-vous récents -->
<div class="content-card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span><i class="bi bi-calendar-week me-2 text-primary"></i>Rendez-vous récents</span>
        <a href="{{ route('admin.appointments.index') }}" class="btn btn-sm btn-outline-primary">
            Voir tout
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Patient</th>
                        <th>Date &amp; Heure</th>
                        <th>Motif</th>
                        <th>Statut</th>
                        <th class="pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentAppointments as $appointment)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="user-avatar" style="width:32px;height:32px;font-size:.8rem;">
                                        {{ strtoupper(substr($appointment->patient?->user?->name ?? '?', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold small">{{ $appointment->patient?->user?->name ?? 'Inconnu' }}</div>
                                        <div class="text-muted" style="font-size:.75rem;">{{ $appointment->patient?->user?->email ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-semibold small">{{ $appointment->date->format('d/m/Y') }}</div>
                                <div class="text-muted" style="font-size:.75rem;">{{ \Carbon\Carbon::parse($appointment->time)->format('H\hi') }}</div>
                            </td>
                            <td class="small">{{ Str::limit($appointment->reason, 30) }}</td>
                            <td>
                                <span class="badge status-badge bg-{{ $appointment->getStatusBadgeClass() }}">
                                    @if($appointment->status === 'pending') En attente
                                    @elseif($appointment->status === 'confirmed') Confirmé
                                    @else Annulé
                                    @endif
                                </span>
                            </td>
                            <td class="pe-4">
                                <div class="d-flex gap-1">
                                    @if($appointment->status === 'pending')
                                        <form method="POST" action="{{ route('admin.appointments.confirm', $appointment) }}">
                                            @csrf @method('PATCH')
                                            <button class="btn btn-sm btn-success" title="Confirmer">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.appointments.cancel', $appointment) }}">
                                            @csrf @method('PATCH')
                                            <button class="btn btn-sm btn-warning" title="Annuler">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('admin.appointments.edit', $appointment) }}" class="btn btn-sm btn-outline-secondary" title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Aucun rendez-vous.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
