<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediSmile — Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { margin: 0; font-family: 'Segoe UI', sans-serif; min-height: 100vh; display: flex; }

        /* ── Left panel (dark) ── */
        .left-panel {
            width: 45%;
            background: linear-gradient(135deg, #1a2236 0%, #2d4270 100%);
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            padding: 3rem; color: #fff; position: relative; overflow: hidden;
        }
        .left-panel::before {
            content: '';
            position: absolute; inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .brand-logo { position: relative; z-index: 1; text-align: center; }
        .brand-logo .logo-wrap {
            display: inline-block;
            background: rgba(255,255,255,.12);
            border-radius: 20px;
            padding: 10px 18px;
            backdrop-filter: blur(8px);
        }
        .brand-logo img { width: 140px; height: auto; border-radius: 12px; }
        .brand-logo p { color: rgba(255,255,255,.65); margin-top: .75rem; font-size: .95rem; }
        .features { position: relative; z-index: 1; margin-top: 2.5rem; width: 100%; max-width: 340px; }
        .feature-item { display: flex; align-items: center; gap: .75rem; margin-bottom: 1rem; }
        .feature-item .fi-icon {
            width: 36px; height: 36px; background: rgba(77,138,240,.25);
            border-radius: 10px; display: flex; align-items: center;
            justify-content: center; font-size: 1rem; flex-shrink: 0;
        }
        .feature-item .fi-text { font-size: .88rem; color: rgba(255,255,255,.75); }

        /* ── Right panel (light) ── */
        .right-panel {
            flex: 1; display: flex; align-items: center;
            justify-content: center; background: #f4f6fb; padding: 2rem;
        }
        .login-card {
            background: #fff; border-radius: 20px;
            padding: 2.5rem; width: 100%; max-width: 420px;
            box-shadow: 0 8px 40px rgba(0,0,0,.08);
        }

        /* Mobile logo (shown when left panel is hidden) */
        .mobile-logo-bar {
            display: none;
            text-align: center;
            padding-bottom: 1.5rem;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid #f0f2f8;
        }
        .mobile-logo-bar img { height: 60px; width: auto; border-radius: 12px; }

        .login-card h2 { font-size: 1.6rem; font-weight: 800; color: #1a2236; }
        .login-card p { color: #8896b0; font-size: .9rem; }
        .form-label { font-size: .85rem; font-weight: 600; color: #4a5568; }
        .form-control {
            border-radius: 10px; border: 1.5px solid #e2e8f4;
            padding: .65rem 1rem; font-size: .9rem;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-control:focus { border-color: #4d8af0; box-shadow: 0 0 0 3px rgba(77,138,240,.15); }
        .btn-login {
            background: linear-gradient(135deg, #4d8af0, #6b6be6);
            border: none; border-radius: 10px; padding: .75rem;
            font-weight: 700; font-size: .95rem; color: #fff;
            transition: opacity .2s, transform .1s;
        }
        .btn-login:hover { opacity: .92; transform: translateY(-1px); color: #fff; }

        @media (max-width: 767.98px) {
            .left-panel { display: none; }
            .mobile-logo-bar { display: block; }
        }
    </style>
</head>
<body>

    <!-- Panneau gauche — dark background → white logo -->
    <div class="left-panel">
        <div class="brand-logo">
            <div class="logo-wrap">
                <img src="{{ asset('logo.jpg') }}" alt="MediSmile Logo">
            </div>
            <p>Système de gestion de clinique dentaire</p>
        </div>
        <div class="features">
            <div class="feature-item">
                <div class="fi-icon"><i class="bi bi-calendar-check text-primary"></i></div>
                <div class="fi-text">Planification et gestion des rendez-vous</div>
            </div>
            <div class="feature-item">
                <div class="fi-icon"><i class="bi bi-people text-primary"></i></div>
                <div class="fi-text">Dossiers patients complets et historique</div>
            </div>
            <div class="feature-item">
                <div class="fi-icon"><i class="bi bi-shield-check text-primary"></i></div>
                <div class="fi-text">Contrôle d'accès sécurisé par rôle</div>
            </div>
            <div class="feature-item">
                <div class="fi-icon"><i class="bi bi-graph-up text-primary"></i></div>
                <div class="fi-text">Tableau de bord et statistiques en temps réel</div>
            </div>
        </div>
    </div>

    <!-- Panneau droit — light background → dark logo -->
    <div class="right-panel">
        <div class="login-card">

            <!-- Logo visible uniquement sur mobile -->
            <div class="mobile-logo-bar">
                <img src="{{ asset('logo.jpg') }}" alt="MediSmile">
            </div>

            <h2>Bon retour !</h2>
            <p class="mb-4">Connectez-vous à votre compte pour continuer</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Adresse e-mail</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="vous@exemple.com" autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="••••••••">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check mb-0">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label small text-muted" for="remember">Se souvenir de moi</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-login w-100">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                </button>
            </form>

            <p class="text-center mt-4 mb-0 text-muted small">
                Nouveau patient ?
                <a href="{{ route('register') }}" class="text-decoration-none fw-semibold" style="color:#4d8af0;">Créer un compte</a>
            </p>

            <hr class="my-4">
            <p class="text-center text-muted" style="font-size:.78rem;">
                <strong>Comptes de démonstration</strong><br>
                Dentiste : admin@mediSmile.com &nbsp;|&nbsp; Secrétaire : secretary@mediSmile.com<br>
                Patient : john@example.com &nbsp;·&nbsp; mot de passe : <code>password</code>
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
