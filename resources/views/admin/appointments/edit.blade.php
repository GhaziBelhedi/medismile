@extends('layouts.dashboard')
@section('title', 'Modifier le rendez-vous')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="content-card">
            <div class="card-header d-flex align-items-center gap-2">
                <a href="{{ route('admin.appointments.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <span><i class="bi bi-pencil me-2 text-primary"></i>Modifier le rendez-vous #{{ $appointment->id }}</span>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.appointments.update', $appointment) }}">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Patient *</label>
                        <select name="patient_id" class="form-select @error('patient_id') is-invalid @enderror" required>
                            <option value="">— Sélectionner un patient —</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}"
                                    {{ (old('patient_id', $appointment->patient_id) == $patient->id) ? 'selected' : '' }}>
                                    {{ $patient->user?->name ?? 'Inconnu' }} ({{ $patient->user?->email ?? 'N/A' }})
                                </option>
                            @endforeach
                        </select>
                        @error('patient_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Date *</label>
                            <input type="date" name="date"
                                   value="{{ old('date', $appointment->date->format('Y-m-d')) }}"
                                   class="form-control @error('date') is-invalid @enderror" required>
                            @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Heure *</label>
                            <input type="time" name="time"
                                   value="{{ old('time', $appointment->time) }}"
                                   class="form-control @error('time') is-invalid @enderror" required>
                            @error('time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Motif *</label>
                        <textarea name="reason" rows="3"
                                  class="form-control @error('reason') is-invalid @enderror" required>{{ old('reason', $appointment->reason) }}</textarea>
                        @error('reason')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Statut *</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="pending"   {{ old('status', $appointment->status) === 'pending'   ? 'selected' : '' }}>En attente</option>
                            <option value="confirmed" {{ old('status', $appointment->status) === 'confirmed' ? 'selected' : '' }}>Confirmé</option>
                            <option value="cancelled" {{ old('status', $appointment->status) === 'cancelled' ? 'selected' : '' }}>Annulé</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>Enregistrer
                        </button>
                        <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
