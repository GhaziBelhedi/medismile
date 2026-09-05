@extends('layouts.dashboard')
@section('title', 'Nouveau rendez-vous')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="content-card">
            <div class="card-header d-flex align-items-center gap-2">
                <a href="{{ route('secretary.appointments.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <span><i class="bi bi-plus-circle me-2 text-primary"></i>Nouveau rendez-vous</span>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('secretary.appointments.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Patient *</label>
                        <select name="patient_id" class="form-select @error('patient_id') is-invalid @enderror" required>
                            <option value="">— Sélectionner un patient —</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->user?->name ?? 'Inconnu' }} ({{ $patient->phone ?? $patient->user?->email ?? 'N/A' }})
                                </option>
                            @endforeach
                        </select>
                        @error('patient_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Date *</label>
                            <input type="date" name="date" value="{{ old('date') }}"
                                   min="{{ date('Y-m-d') }}"
                                   class="form-control @error('date') is-invalid @enderror" required>
                            @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Heure *</label>
                            <input type="time" name="time" value="{{ old('time') }}"
                                   class="form-control @error('time') is-invalid @enderror" required>
                            @error('time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Motif *</label>
                        <textarea name="reason" rows="3"
                                  class="form-control @error('reason') is-invalid @enderror"
                                  placeholder="Décrivez le motif…" required>{{ old('reason') }}</textarea>
                        @error('reason')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>Créer le rendez-vous
                        </button>
                        <a href="{{ route('secretary.appointments.index') }}" class="btn btn-outline-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
