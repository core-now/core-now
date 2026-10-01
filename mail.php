<?php
// mail.php – CORENOW Kontaktformular (SMTP über SSL)

define('SMTP_HOST',      'mailhost01.ekinci.it');
define('SMTP_PORT',      465);
define('SMTP_USER',      'bot@kornau.dev');
define('SMTP_PASS',      '&,eCToWN,47');
define('SMTP_FROM',      'bot@kornau.dev');
define('SMTP_FROM_NAME', 'CORENOW Kontakt');
define('MAIL_TO',        'patrick@kornau.dev');

header('Content-Type: text/plain; charset=utf-8');

$subjects = [
  'de' => 'Neue Kontaktanfrage über core-now.com',
  'en' => 'New contact request via core-now.com',
  'es' => 'Nueva solicitud de contacto vía core-now.com',
  'nl' => 'Nieuw contactverzoek via core-now.com',
  'fr' => 'Nouvelle demande de contact via core-now.com',
];

$vorname   = trim(strip_tags($_POST['vorname']   ?? ''));
$nachname  = trim(strip_tags($_POST['nachname']  ?? ''));
$email     = trim(strip_tags($_POST['email']     ?? ''));
$leistung  = trim(strip_tags($_POST['leistung']  ?? ''));
$nachricht = trim(strip_tags($_POST['nachricht'] ?? ''));
$lang      = trim(strip_tags($_POST['lang']      ?? 'de'));

$ts = intval($_POST['timestamp'] ?? 0);
if (time() - $ts < 5) {
    http_response_code(400); echo 'error'; exit;
}

if (!empty($_POST['website'])) {
    http_response_code(200);
    echo 'ok';
    exit;
}

if (empty($vorname) || empty($nachname) || empty($email) || empty($nachricht)) {
    http_response_code(400);
    echo 'Bitte alle Pflichtfelder ausfüllen.';
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo 'Ungültige E-Mail-Adresse.';
    exit;
}

$subject = $subjects[$lang] ?? $subjects['de'];
$body    = "Name:      $vorname $nachname\n"
         . "E-Mail:    $email\n"
         . "Leistung:  $leistung\n"
         . "Sprache:   $lang\n"
         . str_repeat('-', 40) . "\n\n"
         . $nachricht . "\n";

if (smtp_send(MAIL_TO, $subject, $body, $email)) {
    http_response_code(200);
    echo 'ok';
} else {
    http_response_code(500);
    echo 'Fehler beim Senden. Bitte direkt per E-Mail kontaktieren.';
}

// ---------------------------------------------------------------------------

function smtp_send(string $to, string $subject, string $body, string $replyTo = ''): bool
{
    $sock = @stream_socket_client('ssl://' . SMTP_HOST . ':' . SMTP_PORT, $errno, $errstr, 15);
    if (!$sock) return false;

    $read = function () use ($sock): string {
        $out = '';
        while ($line = fgets($sock, 512)) {
            $out .= $line;
            if (isset($line[3]) && $line[3] === ' ') break;
        }
        return $out;
    };

    $cmd = function (string $c) use ($sock, $read): string {
        fwrite($sock, $c . "\r\n");
        return $read();
    };

    $read(); // server greeting
    $cmd('EHLO corenow.com');
    $cmd('AUTH LOGIN');
    $cmd(base64_encode(SMTP_USER));
    $resp = $cmd(base64_encode(SMTP_PASS));
    if (strpos($resp, '235') === false) {
        fclose($sock);
        return false;
    }

    $cmd('MAIL FROM:<' . SMTP_FROM . '>');
    $cmd('RCPT TO:<' . $to . '>');
    $cmd('DATA');

    $encodedSubject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
    $encodedBody    = chunk_split(base64_encode($body));

    $msg  = 'Date: '       . date('r')                                   . "\r\n";
    $msg .= 'Message-ID: <' . uniqid('cn', true) . '@corenow.com>'       . "\r\n";
    $msg .= 'From: '       . SMTP_FROM_NAME . ' <' . SMTP_FROM . '>'    . "\r\n";
    $msg .= 'To: <'        . $to . '>'                                   . "\r\n";
    if ($replyTo) {
        $msg .= 'Reply-To: <' . $replyTo . '>'                           . "\r\n";
    }
    $msg .= 'Subject: '    . $encodedSubject                             . "\r\n";
    $msg .= "MIME-Version: 1.0\r\n";
    $msg .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $msg .= "Content-Transfer-Encoding: base64\r\n";
    $msg .= "\r\n" . $encodedBody;

    fwrite($sock, $msg . "\r\n.\r\n");
    $resp = $read();
    $cmd('QUIT');
    fclose($sock);

    return strpos($resp, '250') !== false;
}
