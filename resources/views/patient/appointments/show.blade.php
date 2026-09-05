@extends('layouts.dashboard')
@section('title', 'Mon rendez-vous')

@section('content')
<div class="mb-3 d-flex align-items-center gap-2">
    <a href="{{ route('patient.appointments.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <span class="text-muted small">Rendez-vous #{{ $appointment->id }}</span>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="content-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fa-solid fa-calendar-check me-2 text-primary"></i>Détails du rendez-vous</span>
                <span class="badge status-badge bg-{{ $appointment->getStatusBadgeClass() }}" style="font-size:.82rem!important;">
                    @if($appointment->status === 'pending') <i class="fa-solid fa-hourglass-half me-1"></i>En attente
                    @elseif($appointment->status === 'confirmed') <i class="fa-solid fa-circle-check me-1"></i>Confirmé
                    @else <i class="fa-solid fa-circle-xmark me-1"></i>Annulé @endif
                </span>
            </div>
            <div class="card-body p-4">

                {{-- Time remaining banner (upcoming only) --}}
                @if($appointment->timeRemaining && $appointment->status !== 'cancelled')
                    <div class="alert border-0 mb-4 d-flex align-items-center gap-3"
                         style="background:#eff6ff; border-left: 4px solid #4d8af0 !important; border-left-style: solid !important;">
                        <i class="fa-solid fa-clock fa-xl" style="color:#4d8af0;"></i>
                        <div>
                            <div class="fw-bold" style="color:#1d4ed8;">Votre rendez-vous est {{ $appointment->timeRemaining }}</div>
                            <div class="text-muted small">Le {{ $appointment->date->isoFormat('dddd D MMMM YYYY') }} à {{ \Carbon\Carbon::parse($appointment->time)->format('H\hi') }}</div>
                        </div>
                    </div>
                @endif

                {{-- Info grid --}}
                <div class="row g-3 mb-4">
                    <div class="col-sm-6">
                        <div class="border rounded-3 p-3 h-100">
                            <div class="text-muted small mb-1"><i class="fa-solid fa-calendar me-1"></i>Date</div>
                            <div class="fw-bold">{{ $appointment->date->format('d/m/Y') }}</div>
                            <div class="text-muted small">{{ ucfirst($appointment->date->isoFormat('dddd')) }}</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="border rounded-3 p-3 h-100">
                            <div class="text-muted small mb-1"><i class="fa-solid fa-clock me-1"></i>Heure</div>
                            <div class="fw-bold fs-5">{{ \Carbon\Carbon::parse($appointment->time)->format('H\hi') }}</div>
                        </div>
                    </div>
                </div>

                <div class="border rounded-3 p-3 bg-light mb-4">
                    <div class="text-muted small mb-1"><i class="fa-solid fa-stethoscope me-1"></i>Motif de la visite</div>
                    <p class="mb-0 fw-semibold">{{ $appointment->reason }}</p>
                </div>

                {{-- Status timeline --}}
                <div class="border rounded-3 p-3 mb-4">
                    <div class="text-muted small mb-2"><i class="fa-solid fa-timeline me-1"></i>Statut actuel</div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge status-badge bg-{{ $appointment->getStatusBadgeClass() }} px-3 py-2" style="font-size:.82rem;">
                            @if($appointment->status === 'pending')
                                Votre demande est en attente de confirmation
                            @elseif($appointment->status === 'confirmed')
                                Votre rendez-vous est confirmé ✓
                            @else
                                Ce rendez-vous a été annulé
                            @endif
                        </span>
                    </div>
                    <div class="text-muted small mt-2">
                        Demandé le {{ $appointment->created_at->format('d/m/Y à H:i') }}
                    </div>
                </div>

                {{-- Actions --}}
                @if($appointment->status === 'pending')
                    <div class="border-top pt-4">
                        <form method="POST"
                              action="{{ route('patient.appointments.cancel', $appointment) }}"
                              onsubmit="return confirm('Annuler ce rendez-vous ?')">
                            @csrf @method('PATCH')
                            <button class="btn btn-outline-danger">
                                <i class="fa-solid fa-circle-xmark me-1"></i>Annuler ce rendez-vous
                            </button>
                        </form>
                        <p class="text-muted small mt-2 mb-0">
                            <i class="fa-solid fa-circle-info me-1"></i>
                            Seuls les rendez-vous <strong>en attente</strong> peuvent être annulés.
                            Pour modifier un rendez-vous confirmé, contactez la clinique.
                        </p>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
