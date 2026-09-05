@extends('layouts.dashboard')
@section('title', 'Mon profil')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        {{-- Profile header card --}}
        <div class="content-card mb-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-4 flex-wrap">
                    <div class="user-avatar flex-shrink-0"
                         style="width:72px;height:72px;font-size:1.9rem;border-radius:50%;border:3px solid #e8f0fe;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0">{{ $user->name }}</h4>
                        <p class="text-muted small mb-1">{{ $user->email }}</p>
                        <div class="d-flex gap-2 flex-wrap">
                            <span class="badge" style="background:#e8f0fe;color:#4d8af0;">
                                <i class="fa-solid fa-user me-1"></i>Patient
                            </span>
                            @if($patient?->age)
                                <span class="badge bg-light text-dark">
                                    <i class="fa-solid fa-cake-candles me-1"></i>{{ $patient->age }} ans
                                </span>
                            @endif
                            @if($patient?->phone)
                                <span class="badge bg-light text-dark">
                                    <i class="fa-solid fa-phone me-1"></i>{{ $patient->phone }}
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Mini stats --}}
                    <div class="ms-auto d-flex gap-3 flex-wrap">
                        @php $apptCount = $patient?->appointments()->count() ?? 0; @endphp
                        <div class="text-center">
                            <div class="fw-bold fs-5">{{ $apptCount }}</div>
                            <div class="text-muted" style="font-size:.75rem;">Rendez-vous</div>
                        </div>
                        <div class="text-center">
                            <div class="fw-bold fs-5">
                                {{ $patient?->appointments()->where('status','confirmed')->count() ?? 0 }}
                            </div>
                            <div class="text-muted" style="font-size:.75rem;">Confirmés</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Edit form --}}
        <div class="content-card">
            <div class="card-header">
                <i class="fa-solid fa-pen me-2 text-primary"></i>Modifier mes informations
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('patient.profile.update') }}">
                    @csrf @method('PUT')

                    {{-- Personal info --}}
                    <p class="text-muted fw-semibold small text-uppercase letter-spacing mb-3">
                        <i class="fa-solid fa-address-card me-1"></i>Informations personnelles
                    </p>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nom complet *</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                   class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Adresse e-mail *</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                   class="form-control @error('email') is-invalid @enderror" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Date de naissance</label>
                            <input type="date" name="date_of_birth"
                                   value="{{ old('date_of_birth', $patient?->date_of_birth?->format('Y-m-d')) }}"
                                   class="form-control @error('date_of_birth') is-invalid @enderror"
                                   max="{{ date('Y-m-d', strtotime('-1 year')) }}">
                            @error('date_of_birth')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Téléphone</label>
                            <input type="text" name="phone" value="{{ old('phone', $patient?->phone) }}"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   placeholder="06 XX XX XX XX">
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Adresse</label>
                            <textarea name="address" rows="2"
                                      class="form-control @error('address') is-invalid @enderror"
                                      placeholder="Votre adresse postale">{{ old('address', $patient?->address) }}</textarea>
                            @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- Password --}}
                    <p class="text-muted fw-semibold small text-uppercase mb-3">
                        <i class="fa-solid fa-lock me-1"></i>Changer le mot de passe
                        <span class="text-muted fw-normal" style="font-size:.75rem;">(laisser vide pour ne pas modifier)</span>
                    </p>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nouveau mot de passe</label>
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Min. 6 caractères">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Confirmer</label>
                            <input type="password" name="password_confirmation"
                                   class="form-control" placeholder="Répéter le nouveau mot de passe">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-check me-1"></i>Enregistrer les modifications
                    </button>
                </form>
            </div>
        </div>

        {{-- Appointment history --}}
        @if($patient?->appointments()->count())
        <div class="content-card mt-4">
            <div class="card-header">
                <i class="fa-solid fa-clock-rotate-left me-2 text-primary"></i>Historique des rendez-vous
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Date</th>
                                <th>Heure</th>
                                <th>Motif</th>
                                <th class="pe-4">Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($patient->appointments()->latest()->take(10)->get() as $appt)
                                <tr onclick="window.location='{{ route('patient.appointments.show', $appt) }}'" style="cursor:pointer;">
                                    <td class="ps-4 small fw-semibold">{{ $appt->date->format('d/m/Y') }}</td>
                                    <td class="small">{{ \Carbon\Carbon::parse($appt->time)->format('H\hi') }}</td>
                                    <td class="small">{{ Str::limit($appt->reason, 35) }}</td>
                                    <td class="pe-4">
                                        <span class="badge status-badge bg-{{ $appt->getStatusBadgeClass() }}">
                                            @if($appt->status === 'pending') En attente
                                            @elseif($appt->status === 'confirmed') Confirmé
                                            @else Annulé @endif
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
