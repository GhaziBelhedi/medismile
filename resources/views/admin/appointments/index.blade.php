@extends('layouts.dashboard')
@section('title', 'Rendez-vous')

@section('content')
<div class="d-flex flex-wrap gap-2 align-items-center mb-4">
    <form method="GET" class="d-flex flex-wrap gap-2 flex-grow-1">
        <input type="text" name="search" value="{{ request('search') }}"
               class="form-control form-control-sm" style="max-width:200px;"
               placeholder="Rechercher un patient…">
        <input type="date" name="date" value="{{ request('date') }}"
               class="form-control form-control-sm" style="width:auto;">
        <select name="status" class="form-select form-select-sm" style="width:auto;">
            <option value="">Tous les statuts</option>
            <option value="pending"   {{ request('status') === 'pending'   ? 'selected' : '' }}>En attente</option>
            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmé</option>
            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Annulé</option>
        </select>
        <button class="btn btn-sm btn-outline-primary">
            <i class="fa-solid fa-filter me-1"></i>Filtrer
        </button>
        @if(request()->hasAny(['date','status','search']))
            <a href="{{ route('admin.appointments.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fa-solid fa-xmark me-1"></i>Effacer
            </a>
        @endif
    </form>
    <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary btn-sm">
        <i class="fa-solid fa-plus me-1"></i>Nouveau rendez-vous
    </a>
</div>

<div class="content-card">
    <div class="card-header">
        <i class="fa-solid fa-calendar-check me-2 text-primary"></i>Tous les rendez-vous
        <span class="badge bg-light text-dark ms-1">{{ $appointments->total() }}</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Patient</th>
                        <th>Date</th>
                        <th>Heure</th>
                        <th>Motif</th>
                        <th>Statut</th>
                        <th>Temps restant</th>
                        <th class="pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appointment)
                        <tr onclick="window.location='{{ route('admin.appointments.show', $appointment) }}'"
                            title="Voir les détails">
                            <td class="ps-4 text-muted small">{{ $appointment->id }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="user-avatar flex-shrink-0" style="width:32px;height:32px;font-size:.78rem;">
                                        {{ strtoupper(substr($appointment->patient?->user?->name ?? '?', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold small">{{ $appointment->patient?->user?->name ?? 'Inconnu' }}</div>
                                        <div class="text-muted" style="font-size:.72rem;">{{ $appointment->patient?->phone ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="small fw-semibold">{{ $appointment->date->format('d/m/Y') }}</td>
                            <td class="small">{{ \Carbon\Carbon::parse($appointment->time)->format('H\hi') }}</td>
                            <td class="small">{{ Str::limit($appointment->reason, 30) }}</td>
                            <td>
                                <span class="badge status-badge bg-{{ $appointment->getStatusBadgeClass() }}">
                                    @if($appointment->status === 'pending') En attente
                                    @elseif($appointment->status === 'confirmed') Confirmé
                                    @else Annulé @endif
                                </span>
                            </td>
                            <td>
                                @if($appointment->timeRemaining)
                                    <span class="badge time-badge bg-{{ $appointment->timeRemainingClass }} bg-opacity-15 text-{{ $appointment->timeRemainingClass }}"
                                          style="background-color: var(--bs-{{ $appointment->timeRemainingClass }}-bg-subtle) !important;
                                                 color: var(--bs-{{ $appointment->timeRemainingClass }}-text-emphasis) !important;">
                                        <i class="fa-regular fa-clock me-1"></i>{{ $appointment->timeRemaining }}
                                    </span>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td class="pe-4" onclick="event.stopPropagation()">
                                <div class="d-flex gap-1">
                                    @if($appointment->status === 'pending')
                                        <form method="POST" action="{{ route('admin.appointments.confirm', $appointment) }}">
                                            @csrf @method('PATCH')
                                            <button class="btn btn-sm btn-success" title="Confirmer">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.appointments.cancel', $appointment) }}">
                                            @csrf @method('PATCH')
                                            <button class="btn btn-sm btn-warning" title="Annuler">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('admin.appointments.edit', $appointment) }}"
                                       class="btn btn-sm btn-outline-secondary" title="Modifier">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.appointments.destroy', $appointment) }}"
                                          onsubmit="return confirm('Supprimer ce rendez-vous ?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Supprimer">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="96" height="96" viewBox="0 0 24 24" fill="none">
                                        <rect x="3" y="4" width="18" height="17" rx="2" fill="#f0f4ff" stroke="#c7d4f0" stroke-width="1.5"/>
                                        <rect x="3" y="4" width="18" height="6" rx="2" fill="#dce8ff"/>
                                        <line x1="3" y1="10" x2="21" y2="10" stroke="#c7d4f0" stroke-width="1.5"/>
                                        <line x1="8" y1="2" x2="8" y2="6" stroke="#4d8af0" stroke-width="1.5" stroke-linecap="round"/>
                                        <line x1="16" y1="2" x2="16" y2="6" stroke="#4d8af0" stroke-width="1.5" stroke-linecap="round"/>
                                        <circle cx="12" cy="16" r="4" fill="#fee2e2"/>
                                        <line x1="10.5" y1="14.5" x2="13.5" y2="17.5" stroke="#ef4444" stroke-width="1.5" stroke-linecap="round"/>
                                        <line x1="13.5" y1="14.5" x2="10.5" y2="17.5" stroke="#ef4444" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                    <h5>Aucun rendez-vous disponible</h5>
                                    <p>Aucun rendez-vous ne correspond à vos critères de recherche.</p>
                                    <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary btn-sm">
                                        <i class="fa-solid fa-plus me-1"></i>Créer un rendez-vous
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($appointments->hasPages())
        <div class="card-footer bg-transparent border-0 p-3">
            {{ $appointments->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection
