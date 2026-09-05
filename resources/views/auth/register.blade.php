<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediSmile — Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a2236 0%, #2d4270 60%, #1a2236 100%);
            font-family: 'Segoe UI', sans-serif; min-height: 100vh;
            display: flex; align-items: center; justify-content: center; padding: 2rem;
        }
        .register-card {
            background: #fff; border-radius: 20px;
            padding: 2.5rem; width: 100%; max-width: 540px;
            box-shadow: 0 20px 60px rgba(0,0,0,.3);
        }
        .logo-area { text-align: center; margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid #f0f2f8; }
        .logo-area img { height: 70px; width: auto; border-radius: 12px; }
        h2 { font-size: 1.45rem; font-weight: 800; color: #1a2236; }
        .form-label { font-size: .83rem; font-weight: 600; color: #4a5568; }
        .form-control, .form-select {
            border-radius: 10px; border: 1.5px solid #e2e8f4;
            padding: .65rem 1rem; font-size: .9rem;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-control:focus, .form-select:focus { border-color: #4d8af0; box-shadow: 0 0 0 3px rgba(77,138,240,.15); }
        .btn-register {
            background: linear-gradient(135deg, #4d8af0, #5b6de8);
            border: none; border-radius: 10px; padding: .75rem;
            font-weight: 700; font-size: .95rem; color: #fff;
            box-shadow: 0 4px 12px rgba(77,138,240,.3);
        }
        .btn-register:hover { opacity: .9; color: #fff; transform: translateY(-1px); }
        .section-title {
            font-size: .72rem; text-transform: uppercase; letter-spacing: .8px;
            font-weight: 700; color: #9aa5b4; margin: 1rem 0 .75rem;
        }
    </style>
</head>
<body>
<div class="register-card">
    <div class="logo-area">
        <img src="{{ asset('logo.jpg') }}" alt="MediSmile">
    </div>
    <h2 class="text-center">Créer un compte</h2>
    <p class="text-center text-muted small mb-3">Rejoignez MediSmile en tant que patient</p>

    @if($errors->any())
        <div class="alert alert-danger border-0 small">
            <i class="fa-solid fa-triangle-exclamation me-2"></i>
            <ul class="mb-0 mt-1 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="section-title"><i class="fa-solid fa-user me-1"></i>Informations de connexion</div>
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label">Nom complet *</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="form-control @error('name') is-invalid @enderror"
                       placeholder="Jean Dupont" autofocus>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
                <label class="form-label">Adresse e-mail *</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="form-control @error('email') is-invalid @enderror"
                       placeholder="jean@exemple.com">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Mot de passe *</label>
                <input type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Min. 6 caractères">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Confirmer *</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Répéter">
            </div>
        </div>

        <div class="section-title mt-3"><i class="fa-solid fa-address-card me-1"></i>Informations personnelles</div>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Date de naissance</label>
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                       class="form-control @error('date_of_birth') is-invalid @enderror"
                       max="{{ date('Y-m-d', strtotime('-1 year')) }}">
                @error('date_of_birth')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Téléphone</label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                       class="form-control @error('phone') is-invalid @enderror"
                       placeholder="06 XX XX XX XX">
                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
                <label class="form-label">Adresse</label>
                <textarea name="address" rows="2"
                          class="form-control @error('address') is-invalid @enderror"
                          placeholder="Votre adresse postale">{{ old('address') }}</textarea>
                @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12 mt-1">
                <button type="submit" class="btn btn-register w-100">
                    <i class="fa-solid fa-user-plus me-2"></i>Créer mon compte
                </button>
            </div>
        </div>
    </form>

    <p class="text-center mt-3 mb-0 text-muted small">
        Déjà un compte ?
        <a href="{{ route('login') }}" class="text-decoration-none fw-semibold" style="color:#4d8af0;">Se connecter</a>
    </p>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
