@extends('layouts.dashboard')
@section('title', 'Ajouter un utilisateur')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="content-card">
            <div class="card-header d-flex align-items-center gap-2">
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <span><i class="bi bi-person-plus me-2 text-primary"></i>Ajouter un utilisateur</span>
            </div>
            <div class="card-body p-4">

                {{-- Info box --}}
                <div class="alert alert-info border-0 small mb-4">
                    <i class="bi bi-info-circle me-2"></i>
                    Vous pouvez ajouter un <strong>dentiste</strong> ou une <strong>secrétaire</strong>.
                    Les patients s'inscrivent eux-mêmes via la page d'inscription.
                </div>

                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf

                    {{-- Role selector shown first --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Rôle *</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="role"
                                       id="role_secretary" value="secretary"
                                       {{ old('role', 'secretary') === 'secretary' ? 'checked' : '' }}>
                                <label class="btn btn-outline-warning w-100 py-3" for="role_secretary">
                                    <i class="bi bi-person-workspace fs-4 d-block mb-1"></i>
                                    Secrétaire
                                </label>
                            </div>
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="role"
                                       id="role_admin" value="admin"
                                       {{ old('role') === 'admin' ? 'checked' : '' }}>
                                <label class="btn btn-outline-success w-100 py-3" for="role_admin">
                                    <i class="bi bi-person-badge fs-4 d-block mb-1"></i>
                                    Dentiste / Admin
                                </label>
                            </div>
                        </div>
                        @error('role')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nom complet *</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="Ex : Dr. Sophie Martin" autofocus required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Adresse e-mail *</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="utilisateur@mediSmile.com" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Mot de passe *</label>
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Min. 6 caractères" required>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Confirmer *</label>
                            <input type="password" name="password_confirmation"
                                   class="form-control" placeholder="Répéter le mot de passe" required>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-person-check me-1"></i>Créer l'utilisateur
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
