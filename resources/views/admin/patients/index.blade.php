@extends('layouts.dashboard')
@section('title', 'Patients')

@section('content')
<div class="d-flex gap-2 mb-4">
    <form method="GET" class="d-flex gap-2 flex-grow-1">
        <input type="text" name="search" value="{{ request('search') }}"
               class="form-control form-control-sm" placeholder="Rechercher par nom, email ou téléphone…">
        <button class="btn btn-sm btn-outline-primary"><i class="bi bi-search"></i> Rechercher</button>
        @if(request('search'))
            <a href="{{ route('admin.patients.index') }}" class="btn btn-sm btn-outline-secondary">Effacer</a>
        @endif
    </form>
</div>

<div class="content-card">
    <div class="card-header">
        <i class="bi bi-people me-2 text-primary"></i>Tous les patients
        <span class="badge bg-light text-dark ms-1">{{ $patients->total() }}</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Patient</th>
                        <th>Téléphone</th>
                        <th>Adresse</th>
                        <th>Rendez-vous</th>
                        <th>Inscrit le</th>
                        <th class="pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $patient)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="user-avatar" style="width:36px;height:36px;font-size:.85rem;">
                                        {{ strtoupper(substr($patient->user?->name ?? '?', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold small">{{ $patient->user?->name ?? 'Inconnu' }}</div>
                                        <div class="text-muted" style="font-size:.75rem;">{{ $patient->user?->email ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="small">{{ $patient->phone ?? '—' }}</td>
                            <td class="small">{{ Str::limit($patient->address, 30) ?? '—' }}</td>
                            <td>
                                <span class="badge bg-light text-dark">
                                    {{ $patient->appointments()->count() }}
                                </span>
                            </td>
                            <td class="small text-muted">{{ $patient->created_at->format('d/m/Y') }}</td>
                            <td class="pe-4">
                                <a href="{{ route('admin.patients.show', $patient) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> Voir
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <i class="bi bi-people fs-2 d-block mb-2"></i>
                                Aucun patient trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($patients->hasPages())
        <div class="card-footer bg-transparent border-0 p-3">
            {{ $patients->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection
