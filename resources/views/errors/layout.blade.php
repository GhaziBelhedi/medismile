<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediSmile — @yield('title', 'Erreur')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #f4f6fb 0%, #e8f0fe 100%);
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            font-family: 'Segoe UI', sans-serif;
            padding: 2rem;
        }
        .error-card {
            background: #fff;
            border-radius: 20px;
            padding: 3rem 2.5rem;
            max-width: 520px;
            width: 100%;
            text-align: center;
            box-shadow: 0 8px 40px rgba(0,0,0,.08);
        }
        .error-logo { margin-bottom: 2rem; }
        .error-logo img { height: 70px; width: auto; border-radius: 14px; }
        .error-code {
            font-size: 5rem;
            font-weight: 900;
            color: #e8ecf4;
            line-height: 1;
            margin-bottom: .5rem;
            position: relative;
        }
        .error-code span {
            position: absolute;
            inset: 0;
            display: flex; align-items: center; justify-content: center;
            font-size: 5rem;
            background: linear-gradient(135deg, #4d8af0, #5b6de8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .error-title { font-size: 1.4rem; font-weight: 800; color: #1a2236; margin-bottom: .5rem; }
        .error-msg { color: #8896b0; font-size: .95rem; margin-bottom: 2rem; }
        .divider { border-top: 1px solid #f0f2f8; margin: 1.5rem 0; }
        .btn-home {
            background: linear-gradient(135deg, #4d8af0, #6b6be6);
            border: none; border-radius: 10px; padding: .7rem 1.5rem;
            font-weight: 700; color: #fff;
        }
        .btn-home:hover { opacity: .9; color: #fff; }
        footer { margin-top: 2rem; color: #adb5bd; font-size: .8rem; }
    </style>
</head>
<body>
    <div class="error-card">
        <!-- Logo -->
        <div class="error-logo">
            <img src="{{ asset('logo.jpg') }}" alt="MediSmile">
        </div>

        <!-- Error code -->
        <div class="error-code" style="height:80px; position:relative; margin-bottom:1.5rem;">
            @yield('code', '???')
        </div>

        <!-- Message -->
        <h2 class="error-title">@yield('title', 'Une erreur est survenue')</h2>
        <p class="error-msg">@yield('message', 'Nous sommes désolés pour ce désagrément.')</p>

        <div class="divider"></div>

        <div class="d-flex gap-2 justify-content-center">
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Retour
            </a>
            <a href="{{ route('login') }}" class="btn btn-home btn-sm">
                <i class="bi bi-house me-1"></i>Accueil
            </a>
        </div>
    </div>

    <footer>MediSmile &copy; {{ date('Y') }} — Clinique Dentaire</footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
