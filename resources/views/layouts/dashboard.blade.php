<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediSmile — @yield('title', 'Tableau de bord')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Font Awesome 6 Free --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #1a2236;
            --sidebar-width: 265px;
            --sidebar-hover: rgba(255,255,255,.07);
            --sidebar-active-bg: rgba(77,138,240,.18);
            --accent: #4d8af0;
            --accent2: #5b6de8;
            --surface: #f4f6fb;
            --card-shadow: 0 2px 16px rgba(0,0,0,.07);
            --card-hover-shadow: 0 8px 24px rgba(0,0,0,.12);
        }

        * { box-sizing: border-box; }
        body { background: var(--surface); font-family: 'Segoe UI', sans-serif; margin: 0; }

        /* ──────────────── SIDEBAR ──────────────── */
        #sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed; top: 0; left: 0;
            z-index: 1000;
            display: flex; flex-direction: column;
            transition: transform .3s cubic-bezier(.4,0,.2,1);
            box-shadow: 4px 0 20px rgba(0,0,0,.15);
        }

        /* Brand */
        #sidebar .sidebar-brand {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        #sidebar .sidebar-brand a { text-decoration: none; display: flex; align-items: center; }
        #sidebar .logo-pill {
            background: #fff; border-radius: 12px; padding: 6px 12px;
            display: inline-flex; align-items: center;
            transition: transform .2s;
        }
        #sidebar .logo-pill:hover { transform: scale(1.03); }
        #sidebar .logo-pill img { height: 40px; width: auto; }

        /* User card */
        #sidebar .sidebar-user {
            padding: 1rem 1.25rem;
            display: flex; align-items: center; gap: .75rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        .user-avatar {
            width: 40px; height: 40px;
            background: var(--accent);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; color: #fff; font-size: .95rem;
            flex-shrink: 0;
            border: 2px solid rgba(255,255,255,.2);
        }
        .user-info .user-name { color: #fff; font-size: .87rem; font-weight: 600; line-height: 1.2; }
        .user-info .user-role {
            font-size: .7rem; text-transform: uppercase; letter-spacing: .9px;
            color: var(--accent); font-weight: 600;
        }

        /* Nav section label */
        #sidebar .nav-section-label {
            padding: .9rem 1.25rem .3rem;
            font-size: .66rem; text-transform: uppercase; letter-spacing: 1.1px;
            color: rgba(255,255,255,.28); font-weight: 700;
        }

        /* Nav link */
        #sidebar .nav-link {
            color: rgba(255,255,255,.6);
            padding: .55rem 1.25rem;
            display: flex; align-items: center; gap: .7rem;
            font-size: .87rem; font-weight: 500;
            transition: all .2s ease;
            border: none; border-radius: 0;
            position: relative;
            margin: 1px 0;
        }
        #sidebar .nav-link i,
        #sidebar .nav-link svg { font-size: .95rem; flex-shrink: 0; width: 18px; text-align: center; }

        /* Hover */
        #sidebar .nav-link:hover {
            color: #fff;
            background: var(--sidebar-hover);
            padding-left: 1.5rem;
        }

        /* Active */
        #sidebar .nav-link.active {
            color: #fff;
            background: var(--sidebar-active-bg);
            font-weight: 600;
        }
        #sidebar .nav-link.active::before {
            content: '';
            position: absolute; left: 0; top: 0; bottom: 0;
            width: 3px;
            background: var(--accent);
            border-radius: 0 3px 3px 0;
            animation: slideIn .2s ease;
        }
        @keyframes slideIn { from { transform: scaleY(0); } to { transform: scaleY(1); } }

        /* Sidebar footer */
        #sidebar .sidebar-footer {
            margin-top: auto;
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255,255,255,.08);
        }
        .btn-logout {
            background: rgba(255,255,255,.07); color: rgba(255,255,255,.6);
            border: 1px solid rgba(255,255,255,.1); border-radius: 10px;
            padding: .55rem .85rem; width: 100%;
            display: flex; align-items: center; gap: .6rem;
            font-size: .87rem; font-weight: 500;
            transition: all .2s;
        }
        .btn-logout:hover { background: rgba(255,255,255,.13); color: #fff; border-color: rgba(255,255,255,.2); }

        /* ──────────────── TOPBAR ──────────────── */
        #main-content { margin-left: var(--sidebar-width); min-height: 100vh; display: flex; flex-direction: column; }

        #topbar {
            background: #fff;
            border-bottom: 1px solid #e8ecf4;
            padding: .7rem 1.5rem;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 100;
            box-shadow: 0 1px 8px rgba(0,0,0,.05);
        }
        #topbar .page-title { font-size: 1.05rem; font-weight: 700; color: #1a2236; margin: 0; }
        .hamburger-btn { display: none; border: none; background: #f4f6fb; border-radius: 8px; padding: .4rem .6rem; cursor: pointer; color: #4a5568; transition: background .2s; }
        .hamburger-btn:hover { background: #e8ecf4; }
        .topbar-logo { display: none; }
        .topbar-logo img { height: 40px; width: auto; border-radius: 8px; }

        /* ──────────────── CARDS ──────────────── */
        .stat-card {
            border: none; border-radius: 16px;
            padding: 1.4rem; background: #fff;
            box-shadow: var(--card-shadow);
            transition: transform .25s ease, box-shadow .25s ease;
        }
        .stat-card:hover { transform: translateY(-3px); box-shadow: var(--card-hover-shadow); }
        .stat-icon {
            width: 52px; height: 52px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
        }

        .content-card {
            background: #fff; border: none;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }
        .content-card .card-header {
            background: transparent;
            border-bottom: 1px solid #f0f2f8;
            padding: 1rem 1.25rem;
            font-weight: 700; font-size: .93rem;
            display: flex; align-items: center;
        }

        /* ──────────────── TABLES ──────────────── */
        .table { margin: 0; }
        .table th {
            font-size: .73rem; text-transform: uppercase; letter-spacing: .7px;
            color: #9aa5b4; font-weight: 700; border-top: none;
            background: #fafbfd; padding: .75rem 1rem;
        }
        .table td { vertical-align: middle; font-size: .875rem; padding: .75rem 1rem; }
        .table-hover tbody tr { transition: background .15s; cursor: pointer; }
        .table-hover tbody tr:hover { background: #f5f8ff; }

        /* ──────────────── BADGES ──────────────── */
        .status-badge { font-size: .73rem; font-weight: 700; padding: .3em .8em; border-radius: 50px; letter-spacing: .3px; }

        /* ──────────────── BUTTONS ──────────────── */
        .btn-primary {
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border: none;
            box-shadow: 0 4px 12px rgba(77,138,240,.3);
            transition: all .2s ease;
        }
        .btn-primary:hover { box-shadow: 0 6px 18px rgba(77,138,240,.4); transform: translateY(-1px); }
        .btn { border-radius: 8px !important; font-weight: 500; }
        .btn-sm { border-radius: 7px !important; }

        /* ──────────────── EMPTY STATE ──────────────── */
        .empty-state { padding: 3rem 1.5rem; text-align: center; }
        .empty-state svg { opacity: .55; }
        .empty-state h5 { font-weight: 700; color: #3d4a5c; margin-top: 1.2rem; margin-bottom: .4rem; }
        .empty-state p { color: #9aa5b4; font-size: .88rem; margin-bottom: 1.25rem; }

        /* ──────────────── TIME BADGE ──────────────── */
        .time-badge { font-size: .7rem; font-weight: 600; padding: .2em .6em; border-radius: 50px; white-space: nowrap; }

        /* ──────────────── RESPONSIVE ──────────────── */
        @media (max-width: 991.98px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.open { transform: translateX(0); }
            #main-content { margin-left: 0; }
            .hamburger-btn { display: flex; align-items: center; justify-content: center; }
            .topbar-logo { display: block; }
            #sidebar-overlay {
                display: none; position: fixed; inset: 0;
                background: rgba(0,0,0,.5); z-index: 999;
            }
            #sidebar-overlay.show { display: block; }
        }
        @media (max-width: 575.98px) {
            #topbar { padding: .6rem 1rem; }
            .p-4 { padding: 1rem !important; }
        }
    </style>
    @yield('styles')
</head>
<body>

<div id="sidebar-overlay"></div>

<!-- ── Sidebar ──────────────────────────────────────────── -->
<div id="sidebar">
    <div class="sidebar-brand">
        <a href="#">
            <div class="logo-pill">
                <img src="{{ asset('logo.jpg') }}" alt="MediSmile">
            </div>
        </a>
    </div>

    <div class="sidebar-user">
        <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
        <div class="user-info">
            <div class="user-name">{{ auth()->user()->name }}</div>
            <div class="user-role">
                @if(auth()->user()->role === 'admin') Dentiste
                @elseif(auth()->user()->role === 'secretary') Secrétaire
                @else Patient @endif
            </div>
        </div>
    </div>

    <nav class="mt-1 flex-grow-1 overflow-auto">
        @if(auth()->user()->role === 'admin')
            <div class="nav-section-label">Menu</div>
            <a href="{{ route('admin.dashboard') }}"
               class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-grid-2"></i> Tableau de bord
            </a>
            <a href="{{ route('admin.appointments.index') }}"
               class="nav-link {{ request()->routeIs('admin.appointments*') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-check"></i> Rendez-vous
            </a>
            <a href="{{ route('admin.patients.index') }}"
               class="nav-link {{ request()->routeIs('admin.patients*') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i> Patients
            </a>
            <div class="nav-section-label">Administration</div>
            <a href="{{ route('admin.users.index') }}"
               class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                <i class="fa-solid fa-id-badge"></i> Utilisateurs
            </a>

        @elseif(auth()->user()->role === 'secretary')
            <div class="nav-section-label">Menu</div>
            <a href="{{ route('secretary.dashboard') }}"
               class="nav-link {{ request()->routeIs('secretary.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-grid-2"></i> Tableau de bord
            </a>
            <a href="{{ route('secretary.appointments.index') }}"
               class="nav-link {{ request()->routeIs('secretary.appointments*') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-check"></i> Rendez-vous
            </a>
            <a href="{{ route('secretary.patients.index') }}"
               class="nav-link {{ request()->routeIs('secretary.patients*') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i> Patients
            </a>

        @else
            <div class="nav-section-label">Menu</div>
            <a href="{{ route('patient.dashboard') }}"
               class="nav-link {{ request()->routeIs('patient.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-grid-2"></i> Tableau de bord
            </a>
            <a href="{{ route('patient.appointments.index') }}"
               class="nav-link {{ request()->routeIs('patient.appointments.index') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-check"></i> Mes rendez-vous
            </a>
            <a href="{{ route('patient.appointments.create') }}"
               class="nav-link {{ request()->routeIs('patient.appointments.create') ? 'active' : '' }}">
                <i class="fa-solid fa-circle-plus"></i> Prendre un RDV
            </a>
            <a href="{{ route('patient.profile.edit') }}"
               class="nav-link {{ request()->routeIs('patient.profile*') ? 'active' : '' }}">
                <i class="fa-solid fa-circle-user"></i> Mon profil
            </a>
        @endif
    </nav>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="fa-solid fa-right-from-bracket"></i> Déconnexion
            </button>
        </form>
    </div>
</div>

<!-- ── Main Content ─────────────────────────────────────── -->
<div id="main-content">
    <div id="topbar">
        <div class="d-flex align-items-center gap-2">
            <button class="hamburger-btn" id="sidebarToggle">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div class="topbar-logo">
                <img src="{{ asset('logo.jpg') }}" alt="MediSmile">
            </div>
            <h6 class="page-title d-none d-lg-block">@yield('title', 'Tableau de bord')</h6>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="text-muted small d-none d-md-inline">
                <i class="fa-regular fa-calendar me-1"></i>{{ now()->format('d/m/Y') }}
            </span>
            <div class="vr d-none d-md-inline"></div>
            <span class="badge rounded-pill"
                  style="background:linear-gradient(135deg,var(--accent),var(--accent2)); font-size:.73rem; padding:.35em .75em;">
                @if(auth()->user()->role === 'admin') <i class="fa-solid fa-user-doctor me-1"></i>Dentiste
                @elseif(auth()->user()->role === 'secretary') <i class="fa-solid fa-user-tie me-1"></i>Secrétaire
                @else <i class="fa-solid fa-user me-1"></i>Patient @endif
            </span>
        </div>
    </div>

    <!-- Flash messages -->
    <div class="px-4 pt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm d-flex align-items-center gap-2" role="alert">
                <i class="fa-solid fa-circle-check fs-5"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm d-flex align-items-center gap-2" role="alert">
                <i class="fa-solid fa-circle-exclamation fs-5"></i>
                <span>{{ session('error') }}</span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="fa-solid fa-triangle-exclamation me-2"></i>
                <strong>Veuillez corriger les erreurs suivantes :</strong>
                <ul class="mb-0 mt-1 ps-3">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <div class="p-4 flex-grow-1">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const toggle  = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    toggle?.addEventListener('click', () => {
        sidebar.classList.toggle('open');
        overlay.classList.toggle('show');
    });
    overlay.addEventListener('click', () => {
        sidebar.classList.remove('open');
        overlay.classList.remove('show');
    });
</script>
@yield('scripts')
</body>
</html>
