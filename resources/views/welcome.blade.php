<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediSmile - Votre Clinique Dentaire Numérique</title>
    <!-- Modern Typography -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Plus+Jakarta+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --primary-light: #3b82f6;
            --secondary: #0ea5e9;
            --accent: #06b6d4;
            --dark: #0f172a;
            --text-main: #334155;
            --text-light: #64748b;
            --bg-color: #f8fafc;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            line-height: 1.6;
            overflow-x: hidden;
        }

        h1, h2, h3, h4 {
            font-family: 'Outfit', sans-serif;
            color: var(--dark);
        }

        /* Navbar */
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 1.5rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.85);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 1.6rem;
            color: var(--dark);
            text-decoration: none;
        }
        
        .logo span {
            color: var(--primary);
        }

        .logo img {
            height: 42px;
            border-radius: 10px;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-main);
            font-weight: 600;
            font-size: 0.95rem;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .btn {
            padding: 0.85rem 1.8rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-outline {
            border: 2px solid var(--primary);
            color: var(--primary);
            background: transparent;
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white !important;
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.15);
            transform: translateY(-2px);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white !important;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.25);
        }

        .btn-primary:hover {
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.35);
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 8rem 5% 4rem;
            position: relative;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            top: -20%;
            right: -10%;
            width: 70%;
            height: 120%;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.08), rgba(6, 182, 212, 0.08));
            border-radius: 50%;
            filter: blur(80px);
            z-index: -1;
        }

        .hero-content {
            flex: 1;
            max-width: 600px;
            animation: slideUp 0.8s ease-out forwards;
        }

        .hero-title {
            font-size: 3.8rem;
            font-weight: 800;
            line-height: 1.15;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-desc {
            font-size: 1.15rem;
            color: var(--text-light);
            margin-bottom: 2.5rem;
            line-height: 1.7;
        }

        .hero-actions {
            display: flex;
            gap: 1rem;
        }

        .hero-image {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            animation: fadeIn 1s ease-out forwards;
        }

        .hero-image-placeholder {
            width: 100%;
            max-width: 520px;
            height: 520px;
            background: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(255,255,255,0.8);
            border-radius: 32px;
            backdrop-filter: blur(20px);
            box-shadow: 0 25px 50px rgba(0,0,0,0.06);
            position: relative;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            padding: 1rem;
        }

        /* Abstract UI shapes inside hero image */
        .mock-header { height: 60px; border-bottom: 1px solid rgba(0,0,0,0.05); display: flex; align-items: center; padding: 0 15px; gap: 10px; }
        .mock-dot { width: 12px; height: 12px; border-radius: 50%; background: #e2e8f0; }
        .mock-dot.red { background: #ef4444; } .mock-dot.yellow { background: #f59e0b; } .mock-dot.green { background: #10b981; }
        .mock-body { padding: 20px; display: flex; gap: 20px; height: calc(100% - 60px); }
        .mock-sidebar { width: 25%; background: var(--bg-color); border-radius: 16px; padding: 15px; display: flex; flex-direction: column; gap: 12px; }
        .mock-line { height: 10px; background: #e2e8f0; border-radius: 6px; }
        .mock-content { flex: 1; display: flex; flex-direction: column; gap: 15px; }
        .mock-card { background: white; border-radius: 16px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); flex: 1; display: flex; flex-direction: column; }
        .mock-chart { flex: 1; background: linear-gradient(180deg, rgba(37,99,235,0.05) 0%, rgba(37,99,235,0) 100%); border-radius: 8px; border-bottom: 2px solid var(--primary); margin-top: 15px; }

        .floating-card {
            position: absolute;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 1.25rem 1.5rem;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            gap: 15px;
            animation: float 6s ease-in-out infinite;
            border: 1px solid rgba(255,255,255,0.5);
        }

        .fc-1 { bottom: 12%; left: -5%; animation-delay: 0s; }
        .fc-2 { top: 25%; right: -8%; animation-delay: 2s; }

        .icon-circle {
            width: 45px; height: 45px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
        }

        /* Features Section */
        .features {
            padding: 6rem 5%;
            background: var(--white);
            position: relative;
        }

        .section-header {
            text-align: center;
            max-width: 650px;
            margin: 0 auto 4rem;
        }

        .section-subtitle {
            color: var(--primary);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-size: 0.85rem;
            margin-bottom: 0.75rem;
            display: inline-block;
            background: rgba(37, 99, 235, 0.1);
            padding: 5px 15px;
            border-radius: 50px;
        }

        .section-title {
            font-size: 2.5rem;
            margin-bottom: 1.2rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: var(--bg-color);
            padding: 2.5rem 2rem;
            border-radius: 24px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            border: 1px solid transparent;
        }

        .feature-card:hover {
            background: var(--white);
            border-color: rgba(37, 99, 235, 0.15);
            box-shadow: 0 25px 50px rgba(0,0,0,0.05);
            transform: translateY(-8px);
        }

        .icon-box {
            width: 65px;
            height: 65px;
            border-radius: 18px;
            background: white;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 1.8rem;
            transition: all 0.4s ease;
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.1);
        }

        .feature-card:hover .icon-box {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            transform: scale(1.05) rotate(-5deg);
        }

        .feature-title {
            font-size: 1.3rem;
            margin-bottom: 1rem;
        }

        .feature-desc {
            color: var(--text-light);
            font-size: 0.95rem;
            line-height: 1.7;
        }

        /* CTA Section */
        .cta {
            padding: 5rem 5%;
            margin: 4rem 5%;
            background: linear-gradient(135deg, var(--dark), #1e293b);
            border-radius: 30px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
        }

        .cta-bg {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            z-index: 1;
        }

        .cta-content {
            position: relative;
            z-index: 2;
            max-width: 600px;
            margin: 0 auto;
        }

        .cta-title { color: white; margin-bottom: 1rem; font-size: 2.2rem; }
        .cta-desc { color: #cbd5e1; margin-bottom: 2.5rem; font-size: 1.1rem; }

        /* Footer */
        footer {
            background: var(--bg-color);
            padding: 4rem 5% 2rem;
            text-align: center;
        }

        .footer-logo {
            font-family: 'Outfit', sans-serif;
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 1.2rem;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .footer-logo span {
            color: var(--primary);
        }

        .footer-desc {
            color: var(--text-light);
            max-width: 450px;
            margin: 0 auto 2.5rem;
            font-size: 0.95rem;
        }

        .footer-bottom {
            border-top: 1px solid rgba(0,0,0,0.05);
            padding-top: 2rem;
            color: #94a3b8;
            font-size: 0.9rem;
        }

        /* Animations */
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
            100% { transform: translateY(0px); }
        }

        @media (max-width: 992px) {
            .hero-title { font-size: 3.2rem; }
            .hero-image-placeholder { max-width: 450px; height: 450px; }
        }

        @media (max-width: 768px) {
            .hero {
                flex-direction: column;
                padding-top: 8rem;
                text-align: center;
            }
            .hero-title { font-size: 2.8rem; }
            .hero-content { margin-bottom: 4rem; }
            .hero-actions { justify-content: center; flex-direction: column; }
            .nav-links { display: none; }
            .floating-card { display: none; }
            .cta { margin: 2rem 5%; padding: 4rem 2rem; }
        }
    </style>
</head>
<body>

    <nav>
        <a href="/" class="logo">
            <img src="{{ asset('logo.jpg') }}" alt="MediSmile Logo" onerror="this.style.display='none'">
            Medi<span>Smile</span>
        </a>
        <div class="nav-links">
            <a href="#features">Fonctionnalités</a>
            <a href="{{ route('login') }}" class="btn btn-outline" style="padding: 0.6rem 1.5rem;">Connexion</a>
            <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 0.6rem 1.5rem;">S'inscrire</a>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-bg"></div>
        <div class="hero-content">
            <h1 class="hero-title">La Gestion de votre Clinique, Simplifiée.</h1>
            <p class="hero-desc">Découvrez la plateforme de nouvelle génération pour la gestion des cabinets dentaires. Prenez des rendez-vous, accédez aux dossiers médicaux et communiquez en toute sécurité.</p>
            <div class="hero-actions">
                <a href="{{ route('register') }}" class="btn btn-primary">
                    Créer un compte <i class="bi bi-arrow-right"></i>
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline">
                    Accès Patient
                </a>
            </div>
        </div>
        
        <div class="hero-image">
            <div class="hero-image-placeholder">
                <div class="mock-header">
                    <div class="mock-dot red"></div><div class="mock-dot yellow"></div><div class="mock-dot green"></div>
                </div>
                <div class="mock-body">
                    <div class="mock-sidebar">
                        <div class="mock-line" style="width: 80%; height: 8px;"></div>
                        <div class="mock-line" style="width: 60%; margin-top: 15px; height: 8px;"></div>
                        <div class="mock-line" style="width: 70%; margin-top: 10px; height: 8px;"></div>
                        <div class="mock-line" style="width: 50%; margin-top: 10px; height: 8px;"></div>
                    </div>
                    <div class="mock-content">
                        <div style="display: flex; gap: 15px;">
                            <div class="mock-card">
                                <div class="mock-line" style="width: 40%; margin-bottom: 15px;"></div>
                                <div class="mock-line" style="width: 90%; height: 25px; border-radius: 8px;"></div>
                            </div>
                            <div class="mock-card">
                                <div class="mock-line" style="width: 50%; margin-bottom: 15px;"></div>
                                <div class="mock-line" style="width: 70%; height: 25px; border-radius: 8px;"></div>
                            </div>
                        </div>
                        <div class="mock-card">
                            <div class="mock-line" style="width: 30%;"></div>
                            <div class="mock-chart"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Floating Micro-interactions -->
            <div class="floating-card fc-1">
                <div class="icon-circle" style="background: #e0f2fe; color: var(--primary);">
                    <i class="bi bi-calendar-check fs-5"></i>
                </div>
                <div>
                    <div style="font-weight: 700; font-size: 0.95rem; color: var(--dark);">RDV Confirmé</div>
                    <div style="color: var(--text-light); font-size: 0.8rem;">Dr. Martin - Demain 10h</div>
                </div>
            </div>

            <div class="floating-card fc-2">
                <div class="icon-circle" style="background: #dcfce7; color: #10b981;">
                    <i class="bi bi-shield-check fs-5"></i>
                </div>
                <div>
                    <div style="font-weight: 700; font-size: 0.95rem; color: var(--dark);">Dossier Sécurisé</div>
                    <div style="color: var(--text-light); font-size: 0.8rem;">Chiffrement de bout en bout</div>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="features">
        <div class="section-header">
            <div class="section-subtitle">L'Excellence Dentaire</div>
            <h2 class="section-title">Une plateforme conçue pour votre sourire</h2>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="icon-box">
                    <i class="bi bi-calendar2-week"></i>
                </div>
                <h3 class="feature-title">Prise de RDV 24/7</h3>
                <p class="feature-desc">Fini les attentes téléphoniques. Consultez les disponibilités en temps réel et réservez votre consultation en quelques clics.</p>
            </div>

            <div class="feature-card">
                <div class="icon-box">
                    <i class="bi bi-journal-medical"></i>
                </div>
                <h3 class="feature-title">Dossier Numérique</h3>
                <p class="feature-desc">Retrouvez votre historique de soins, vos ordonnances et vos radiographies depuis votre espace personnel ultra-sécurisé.</p>
            </div>

            <div class="feature-card">
                <div class="icon-box">
                    <i class="bi bi-bell"></i>
                </div>
                <h3 class="feature-title">Rappels Intelligents</h3>
                <p class="feature-desc">Ne manquez plus aucun rendez-vous important grâce à nos notifications automatiques par e-mail et SMS.</p>
            </div>

            <div class="feature-card">
                <div class="icon-box">
                    <i class="bi bi-shield-lock"></i>
                </div>
                <h3 class="feature-title">Sécurité Maximale</h3>
                <p class="feature-desc">Vos données de santé sont hautement protégées, cryptées et hébergées sur des serveurs agréés.</p>
            </div>
        </div>
    </section>

    <section class="cta">
        <div class="cta-bg"></div>
        <div class="cta-content">
            <h2 class="cta-title">Prêt à moderniser votre parcours de soins ?</h2>
            <p class="cta-desc">Rejoignez des milliers de patients qui font déjà confiance à MediSmile pour la gestion de leur santé dentaire.</p>
            <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 1rem 2.5rem; font-size: 1.1rem; box-shadow: 0 10px 25px rgba(0,0,0,0.3);">
                Créer mon espace patient
            </a>
        </div>
    </section>

    <footer>
        <div class="footer-logo">
            <img src="{{ asset('logo.jpg') }}" alt="" onerror="this.style.display='none'" style="height: 30px; border-radius: 6px;">
            Medi<span>Smile</span>
        </div>
        <p class="footer-desc">L'innovation au service de votre santé dentaire. Une gestion fluide, transparente et sécurisée de votre parcours de soins.</p>
        <div class="footer-bottom">
            &copy; {{ date('Y') }} MediSmile. Tous droits réservés.
        </div>
    </footer>

</body>
</html>
