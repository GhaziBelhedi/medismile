@extends('layouts.dashboard')
@section('title', 'Mes rendez-vous')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0 small">Tout votre historique de rendez-vous.</p>
    <a href="{{ route('patient.appointments.create') }}" class="btn btn-primary btn-sm">
        <i class="fa-solid fa-plus me-1"></i>Nouveau RDV
    </a>
</div>

<div class="content-card">
    <div class="card-header">
        <i class="fa-solid fa-calendar-check me-2 text-primary"></i>Mes rendez-vous
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
                        <th>Statut</th>
                        <th class="pe-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appt)
                        <tr onclick="window.location='{{ route('patient.appointments.show', $appt) }}'"
                            title="Voir les détails">
                            <td class="ps-4 small fw-semibold">{{ $appt->date->format('d/m/Y') }}</td>
                            <td class="small">{{ \Carbon\Carbon::parse($appt->time)->format('H\hi') }}</td>
                            <td class="small">{{ Str::limit($appt->reason, 35) }}</td>
                            <td>
                                @if($appt->timeRemaining && $appt->status !== 'cancelled')
                                    <span class="badge time-badge bg-{{ $appt->timeRemainingClass }} bg-opacity-15
                                                 text-{{ $appt->timeRemainingClass }}">
                                        <i class="fa-regular fa-clock me-1"></i>{{ $appt->timeRemaining }}
                                    </span>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge status-badge bg-{{ $appt->getStatusBadgeClass() }}">
                                    @if($appt->status === 'pending') En attente
                                    @elseif($appt->status === 'confirmed') Confirmé
                                    @else Annulé @endif
                                </span>
                            </td>
                            <td class="pe-4" onclick="event.stopPropagation()">
                                @if($appt->status === 'pending')
                                    <form method="POST"
                                          action="{{ route('patient.appointments.cancel', $appt) }}"
                                          onsubmit="return confirm('Annuler ce rendez-vous ?')">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="fa-solid fa-circle-xmark me-1"></i>Annuler
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="96" height="96" viewBox="0 0 24 24" fill="none">
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
                                    <p>Prenez votre premier rendez-vous en quelques secondes.</p>
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
    @if(method_exists($appointments, 'hasPages') && $appointments->hasPages())
        <div class="card-footer bg-transparent border-0 p-3">
            {{ $appointments->links() }}
        </div>
    @endif
</div>
@endsection
