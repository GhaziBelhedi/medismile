@extends('layouts.dashboard')
@section('title', 'Ajouter un patient')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="content-card">
            <div class="card-header d-flex align-items-center gap-2">
                <a href="{{ route('secretary.patients.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <span><i class="bi bi-person-plus me-2 text-primary"></i>Ajouter un nouveau patient</span>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('secretary.patients.store') }}">
                    @csrf

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Nom complet *</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="Nom complet du patient" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Adresse e-mail *</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="patient@exemple.com" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Mot de passe temporaire *</label>
                            <input type="text" name="password" value="{{ old('password') }}"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Le patient pourra le modifier" required>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="form-text text-muted">Le patient utilisera ce mot de passe pour se connecter.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Téléphone</label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   placeholder="06 XX XX XX XX">
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Adresse</label>
                            <input type="text" name="address" value="{{ old('address') }}"
                                   class="form-control @error('address') is-invalid @enderror"
                                   placeholder="Adresse du patient">
                            @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12 mt-2">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-person-plus me-1"></i>Ajouter le patient
                                </button>
                                <a href="{{ route('secretary.patients.index') }}" class="btn btn-outline-secondary">Annuler</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
