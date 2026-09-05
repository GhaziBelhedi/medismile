@extends('layouts.dashboard')
@section('title', $patient->user?->name ?? 'Patient Inconnu')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.patients.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Retour
    </a>
</div>

<div class="row g-4">
    <!-- Fiche patient -->
    <div class="col-lg-4">
        <div class="content-card">
            <div class="card-body text-center p-4">
                <div class="user-avatar mx-auto mb-3" style="width:70px;height:70px;font-size:1.8rem;border-radius:50%;">
                    {{ strtoupper(substr($patient->user?->name ?? '?', 0, 1)) }}
                </div>
                <h5 class="fw-bold mb-1">{{ $patient->user?->name ?? 'Inconnu' }}</h5>
                <p class="text-muted small mb-3">{{ $patient->user?->email ?? 'N/A' }}</p>
                <hr>
                <div class="text-start">
                    <div class="mb-2">
                        <small class="text-muted d-block">Téléphone</small>
                        <span class="fw-semibold small">{{ $patient->phone ?? '—' }}</span>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted d-block">Adresse</small>
                        <span class="fw-semibold small">{{ $patient->address ?? '—' }}</span>
                    </div>
                    <div>
                        <small class="text-muted d-block">Inscrit le</small>
                        <span class="fw-semibold small">{{ $patient->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent text-center">
                <a href="{{ route('admin.notes.create', $patient) }}" class="btn btn-primary btn-sm w-100">
                    <i class="bi bi-journal-plus me-1"></i>Ajouter une note
                </a>
            </div>
        </div>
    </div>

    <!-- Colonne droite -->
    <div class="col-lg-8">
        <!-- Rendez-vous -->
        <div class="content-card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-calendar-check me-2 text-primary"></i>Historique des rendez-vous</span>
                <span class="badge bg-light text-dark">{{ $patient->appointments->count() }}</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Date</th>
                                <th>Heure</th>
                                <th>Motif</th>
                                <th class="pe-4">Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($patient->appointments as $appt)
                                <tr>
                                    <td class="ps-4 small">{{ $appt->date->format('d/m/Y') }}</td>
                                    <td class="small">{{ \Carbon\Carbon::parse($appt->time)->format('H\hi') }}</td>
                                    <td class="small">{{ Str::limit($appt->reason, 35) }}</td>
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
                                    <td colspan="4" class="text-center text-muted py-3 small">Aucun rendez-vous.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Notes du dentiste -->
        <div class="content-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-journal-text me-2 text-primary"></i>Notes du dentiste</span>
                <a href="{{ route('admin.notes.create', $patient) }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-plus-lg"></i> Ajouter
                </a>
            </div>
            <div class="card-body">
                @forelse($patient->notes as $note)
                    <div class="border rounded-3 p-3 mb-3 bg-light">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="fw-semibold small text-primary">Dr. {{ $note->dentist?->name ?? 'Inconnu' }}</span>
                            <span class="text-muted" style="font-size:.75rem;">{{ $note->created_at->format('d/m/Y à H:i') }}</span>
                        </div>
                        <p class="mb-0 small">{{ $note->note }}</p>
                    </div>
                @empty
                    <p class="text-muted text-center small py-3">Aucune note pour ce patient.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
