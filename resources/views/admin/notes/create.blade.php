@extends('layouts.dashboard')
@section('title', 'Ajouter une note')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="content-card">
            <div class="card-header d-flex align-items-center gap-2">
                <a href="{{ route('admin.patients.show', $patient) }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <span><i class="bi bi-journal-plus me-2 text-primary"></i>Note pour {{ $patient->user?->name ?? 'Inconnu' }}</span>
            </div>
            <div class="card-body p-4">
                <!-- Résumé patient -->
                <div class="d-flex align-items-center gap-3 mb-4 p-3 bg-light rounded-3">
                    <div class="user-avatar" style="width:44px;height:44px;">
                        {{ strtoupper(substr($patient->user?->name ?? '?', 0, 1)) }}
                    </div>
                    <div>
                        <div class="fw-semibold">{{ $patient->user?->name ?? 'Inconnu' }}</div>
                        <div class="text-muted small">{{ $patient->user?->email ?? 'N/A' }}</div>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.notes.store', $patient) }}">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Note clinique *</label>
                        <textarea name="note" rows="6"
                                  class="form-control @error('note') is-invalid @enderror"
                                  placeholder="Saisissez vos observations cliniques, notes de traitement ou recommandations…">{{ old('note') }}</textarea>
                        @error('note')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text text-muted">Cette note n'est visible que par l'équipe dentaire.</div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>Enregistrer la note
                        </button>
                        <a href="{{ route('admin.patients.show', $patient) }}" class="btn btn-outline-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
