@extends('layouts.dashboard')
@section('title', 'Utilisateurs')

@section('content')

{{-- Stat cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div class="stat-icon" style="background:#e8f0fe;">
                    <i class="bi bi-people-fill" style="color:#4d8af0;"></i>
                </div>
                <span class="text-muted small">Total</span>
            </div>
            <h4 class="fw-bold mb-0">{{ $counts['total'] }}</h4>
            <p class="text-muted small mb-0">Tous les utilisateurs</p>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div class="stat-icon" style="background:#d1e7dd;">
                    <i class="bi bi-person-badge-fill" style="color:#198754;"></i>
                </div>
                <span class="text-muted small">Rôle</span>
            </div>
            <h4 class="fw-bold mb-0">{{ $counts['admin'] }}</h4>
            <p class="text-muted small mb-0">Dentiste(s)</p>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div class="stat-icon" style="background:#fff3cd;">
                    <i class="bi bi-person-workspace" style="color:#fd7e14;"></i>
                </div>
                <span class="text-muted small">Rôle</span>
            </div>
            <h4 class="fw-bold mb-0">{{ $counts['secretary'] }}</h4>
            <p class="text-muted small mb-0">Secrétaire(s)</p>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div class="stat-icon" style="background:#f8d7da;">
                    <i class="bi bi-person-heart" style="color:#dc3545;"></i>
                </div>
                <span class="text-muted small">Rôle</span>
            </div>
            <h4 class="fw-bold mb-0">{{ $counts['patient'] }}</h4>
            <p class="text-muted small mb-0">Patient(s)</p>
        </div>
    </div>
</div>

{{-- Filters + Create button --}}
<div class="d-flex flex-wrap gap-2 align-items-center mb-4">
    <form method="GET" class="d-flex flex-wrap gap-2 flex-grow-1">
        <input type="text" name="search" value="{{ request('search') }}"
               class="form-control form-control-sm" style="max-width:240px;"
               placeholder="Rechercher par nom ou e-mail…">
        <select name="role" class="form-select form-select-sm" style="width:auto;">
            <option value="">Tous les rôles</option>
            <option value="admin"     {{ request('role') === 'admin'     ? 'selected' : '' }}>Dentiste</option>
            <option value="secretary" {{ request('role') === 'secretary' ? 'selected' : '' }}>Secrétaire</option>
            <option value="patient"   {{ request('role') === 'patient'   ? 'selected' : '' }}>Patient</option>
        </select>
        <button class="btn btn-sm btn-outline-primary"><i class="bi bi-search"></i> Rechercher</button>
        @if(request()->hasAny(['search','role']))
            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">Effacer</a>
        @endif
    </form>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-person-plus me-1"></i>Ajouter un utilisateur
    </a>
</div>

{{-- Users table --}}
<div class="content-card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span><i class="bi bi-person-badge me-2 text-primary"></i>Tous les utilisateurs</span>
        <span class="badge bg-light text-dark">{{ $users->total() }}</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Utilisateur</th>
                        <th>Rôle</th>
                        <th>Inscrit le</th>
                        <th class="pe-4 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td class="ps-4 text-muted small">{{ $user->id }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    {{-- Avatar initial --}}
                                    <div class="user-avatar flex-shrink-0"
                                         style="width:38px;height:38px;font-size:.88rem;
                                                background:{{ $user->role === 'admin' ? '#198754' : ($user->role === 'secretary' ? '#fd7e14' : '#4d8af0') }};">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold small">
                                            {{ $user->name }}
                                            @if($user->id === auth()->id())
                                                <span class="badge bg-light text-muted ms-1" style="font-size:.65rem;">Vous</span>
                                            @endif
                                        </div>
                                        <div class="text-muted" style="font-size:.75rem;">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($user->role === 'admin')
                                    <span class="badge status-badge bg-success">Dentiste</span>
                                @elseif($user->role === 'secretary')
                                    <span class="badge status-badge bg-warning text-dark">Secrétaire</span>
                                @else
                                    <span class="badge status-badge bg-primary">Patient</span>
                                @endif
                            </td>
                            <td class="small text-muted">{{ $user->created_at->format('d/m/Y') }}</td>
                            <td class="pe-4 text-end">
                                @if($user->id !== auth()->id())
                                    <form method="POST"
                                          action="{{ route('admin.users.destroy', $user) }}"
                                          onsubmit="return confirm('Supprimer « {{ addslashes($user->name) }} » ? Cette action est irréversible.')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">
                                <i class="bi bi-people fs-2 d-block mb-2"></i>
                                Aucun utilisateur trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($users->hasPages())
        <div class="card-footer bg-transparent border-0 p-3">
            {{ $users->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection
