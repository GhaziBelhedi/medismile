@extends('layouts.dashboard')
@section('title', 'Rendez-vous #' . $appointment->id)

@section('content')
<div class="mb-3 d-flex align-items-center gap-2">
    <a href="{{ route('admin.appointments.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <span class="text-muted small">Rendez-vous #{{ $appointment->id }}</span>
</div>

<div class="row g-4">

    {{-- Patient card --}}
    <div class="col-lg-4">
        <div class="content-card h-100">
            <div class="card-header"><i class="fa-solid fa-user-injured me-2 text-primary"></i>Patient</div>
            <div class="card-body p-4 text-center">
                <div class="user-avatar mx-auto mb-3"
                     style="width:72px;height:72px;font-size:1.8rem;border-radius:50%;border:3px solid #e8f0fe;">
                    {{ strtoupper(substr($appointment->patient?->user?->name ?? '?', 0, 1)) }}
                </div>
                <h5 class="fw-bold mb-0">{{ $appointment->patient?->user?->name ?? 'Inconnu' }}</h5>
                <p class="text-muted small mb-3">{{ $appointment->patient?->user?->email ?? 'N/A' }}</p>

                <div class="text-start border-top pt-3">
                    <div class="row g-2">
                        <div class="col-6 small">
                            <span class="text-muted d-block" style="font-size:.73rem;">TÉLÉPHONE</span>
                            <span class="fw-semibold">{{ $appointment->patient->phone ?? '—' }}</span>
                        </div>
                        <div class="col-6 small">
                            <span class="text-muted d-block" style="font-size:.73rem;">ÂGE</span>
                            <span class="fw-semibold">
                                {{ $appointment->patient->age ? $appointment->patient->age . ' ans' : '—' }}
                            </span>
                        </div>
                        <div class="col-12 small mt-1">
                            <span class="text-muted d-block" style="font-size:.73rem;">ADRESSE</span>
                            <span class="fw-semibold">{{ $appointment->patient->address ?? '—' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <a href="{{ route('admin.patients.show', $appointment->patient) }}"
                   class="btn btn-outline-primary btn-sm w-100">
                    <i class="fa-solid fa-eye me-1"></i>Voir le dossier complet
                </a>
            </div>
        </div>
    </div>

    {{-- Right column --}}
    <div class="col-lg-8 d-flex flex-column gap-4">

        {{-- Appointment details --}}
        <div class="content-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fa-solid fa-calendar-check me-2 text-primary"></i>Détails du rendez-vous</span>
                <span class="badge status-badge bg-{{ $appointment->getStatusBadgeClass() }} fs-6" style="font-size:.82rem!important;">
                    @if($appointment->status === 'pending') <i class="fa-solid fa-hourglass-half me-1"></i>En attente
                    @elseif($appointment->status === 'confirmed') <i class="fa-solid fa-circle-check me-1"></i>Confirmé
                    @else <i class="fa-solid fa-circle-xmark me-1"></i>Annulé @endif
                </span>
            </div>
            <div class="card-body p-4">
                <div class="row g-4 mb-4">
                    <div class="col-sm-4 text-center">
                        <div class="stat-icon mx-auto mb-2" style="background:#e8f0fe;">
                            <i class="fa-solid fa-calendar-day" style="color:#4d8af0;font-size:1.3rem;"></i>
                        </div>
                        <div class="text-muted small">Date</div>
                        <div class="fw-bold">{{ $appointment->date->format('d/m/Y') }}</div>
                        <div class="text-muted" style="font-size:.78rem;">{{ $appointment->date->isoFormat('dddd') }}</div>
                    </div>
                    <div class="col-sm-4 text-center">
                        <div class="stat-icon mx-auto mb-2" style="background:#d1e7dd;">
                            <i class="fa-solid fa-clock" style="color:#198754;font-size:1.3rem;"></i>
                        </div>
                        <div class="text-muted small">Heure</div>
                        <div class="fw-bold">{{ \Carbon\Carbon::parse($appointment->time)->format('H\hi') }}</div>
                    </div>
                    <div class="col-sm-4 text-center">
                        <div class="stat-icon mx-auto mb-2" style="background:#fff3cd;">
                            <i class="fa-solid fa-hourglass-half" style="color:#fd7e14;font-size:1.3rem;"></i>
                        </div>
                        <div class="text-muted small">Temps restant</div>
                        @if($appointment->timeRemaining)
                            <div class="fw-bold text-{{ $appointment->timeRemainingClass }}">
                                {{ $appointment->timeRemaining }}
                            </div>
                        @else
                            <div class="text-muted fw-bold small">Passé</div>
                        @endif
                    </div>
                </div>

                <div class="border rounded-3 p-3 bg-light">
                    <div class="text-muted small mb-1"><i class="fa-solid fa-stethoscope me-1"></i>Motif de la visite</div>
                    <p class="mb-0 fw-semibold">{{ $appointment->reason }}</p>
                </div>

                {{-- Actions --}}
                @if($appointment->status === 'pending')
                <div class="d-flex gap-2 mt-4 flex-wrap">
                    <form method="POST" action="{{ route('admin.appointments.confirm', $appointment) }}">
                        @csrf @method('PATCH')
                        <button class="btn btn-success">
                            <i class="fa-solid fa-check me-1"></i>Confirmer
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.appointments.cancel', $appointment) }}">
                        @csrf @method('PATCH')
                        <button class="btn btn-warning">
                            <i class="fa-solid fa-xmark me-1"></i>Annuler
                        </button>
                    </form>
                    <a href="{{ route('admin.appointments.edit', $appointment) }}" class="btn btn-outline-secondary">
                        <i class="fa-solid fa-pen me-1"></i>Modifier
                    </a>
                </div>
                @elseif($appointment->status === 'confirmed')
                <div class="d-flex gap-2 mt-4 flex-wrap">
                    <form method="POST" action="{{ route('admin.appointments.cancel', $appointment) }}">
                        @csrf @method('PATCH')
                        <button class="btn btn-outline-warning">
                            <i class="fa-solid fa-xmark me-1"></i>Annuler le RDV
                        </button>
                    </form>
                    <a href="{{ route('admin.appointments.edit', $appointment) }}" class="btn btn-outline-secondary">
                        <i class="fa-solid fa-pen me-1"></i>Modifier
                    </a>
                </div>
                @endif
            </div>
        </div>

        {{-- Dentist notes for this patient --}}
        <div class="content-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fa-solid fa-file-medical me-2 text-primary"></i>Notes médicales du patient</span>
                <a href="{{ route('admin.notes.create', $appointment->patient) }}" class="btn btn-sm btn-outline-primary">
                    <i class="fa-solid fa-plus me-1"></i>Ajouter
                </a>
            </div>
            <div class="card-body">
                @forelse($appointment->patient->notes as $note)
                    <div class="border rounded-3 p-3 mb-2 bg-light">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="fw-semibold small text-primary">
                                <i class="fa-solid fa-user-doctor me-1"></i>Dr. {{ $note->dentist?->name ?? 'Inconnu' }}
                            </span>
                            <span class="text-muted" style="font-size:.73rem;">
                                {{ $note->created_at->format('d/m/Y à H:i') }}
                            </span>
                        </div>
                        <p class="mb-0 small">{{ $note->note }}</p>
                    </div>
                @empty
                    <div class="empty-state py-3">
                        <i class="fa-solid fa-file-circle-xmark fa-2x text-muted"></i>
                        <p class="mb-0 mt-2 small text-muted">Aucune note médicale pour ce patient.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection
