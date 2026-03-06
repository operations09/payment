<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "POST only"]); exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (!$input || empty($input['name']) || empty($input['transaction_hash']) || empty($input['method'])) {
    echo json_encode(["error" => "Missing required fields"]); exit;
}

$name      = htmlspecialchars(trim($input['name']));
$email     = htmlspecialchars(trim($input['email'] ?? ''));
$txHash    = htmlspecialchars(trim($input['transaction_hash']));
$method    = htmlspecialchars(strtoupper(trim($input['method'])));
$ip        = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
$refId     = 'RMK' . substr(time(), -6) . rand(10, 99);
$dateNice  = date('d M Y, h:i A');

// ══════════════════════════════════════════════════════════════
// ⚙️  CHANGE THESE 3 VALUES ONLY
// ══════════════════════════════════════════════════════════════
$SMTP_USER   = 'operations@rangeforex.com';    // Your Gmail address
$SMTP_PASS   = 'qtnd wvwe fteq jhkg';     // Gmail App Password (16 chars, no spaces)
$ADMIN_EMAIL = 'operations@rangeforex.com'; // Who receives the notification
// ══════════════════════════════════════════════════════════════

$SMTP_HOST      = 'smtp.gmail.com';
$SMTP_PORT      = 587;
$SMTP_FROM      = $SMTP_USER;
$SMTP_FROM_NAME = 'Range Markets Deposits';

// HTML email body
$htmlBody = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head>
<body style="margin:0;padding:0;background:#0f172a;font-family:Arial,sans-serif">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#0f172a;padding:40px 20px">
<tr><td align="center"><table width="560" cellpadding="0" cellspacing="0" style="max-width:560px;width:100%">

<tr><td style="background:linear-gradient(135deg,#0c1a3a,#1a0d3e);border-radius:16px 16px 0 0;
  padding:28px 32px;text-align:center;border-bottom:3px solid #00d4ff">
  <div style="font-size:26px;font-weight:900;color:#00d4ff;letter-spacing:2px">RANGE MARKETS</div>
  <div style="font-size:10px;color:#64748b;letter-spacing:3px;text-transform:uppercase;margin-top:4px">Deposit Notification</div>
</td></tr>

<tr><td style="background:#0d1829;padding:28px 32px;border-left:1px solid rgba(0,212,255,.15);border-right:1px solid rgba(0,212,255,.15)">
  <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:10px;background:rgba(0,212,255,.08);border:1px solid rgba(0,212,255,.2);border-radius:10px">
  <tr><td style="padding:14px 18px">
    <span style="font-size:16px">💰</span>
    <span style="font-size:14px;font-weight:700;color:#00d4ff;margin-left:8px">New Crypto Deposit Submitted</span>
  </td></tr></table>

  <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:separate;border-spacing:0 8px">
  <tr>
    <td style="padding:11px 14px;background:rgba(0,212,255,.05);width:30%;font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:#64748b;border-radius:8px 0 0 8px;border:1px solid rgba(255,255,255,.06)">👤 Name</td>
    <td style="padding:11px 14px;background:rgba(255,255,255,.03);font-size:14px;font-weight:700;color:#f0f6ff;border-radius:0 8px 8px 0;border:1px solid rgba(255,255,255,.06);border-left:none">'. $name .'</td>
  </tr>
  <tr>
    <td style="padding:11px 14px;background:rgba(0,212,255,.05);font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:#64748b;border-radius:8px 0 0 8px;border:1px solid rgba(255,255,255,.06)">📧 Email</td>
    <td style="padding:11px 14px;background:rgba(255,255,255,.03);font-size:13px;color:#60a5fa;border-radius:0 8px 8px 0;border:1px solid rgba(255,255,255,.06);border-left:none">'. $email .'</td>
  </tr>
  <tr>
    <td style="padding:11px 14px;background:rgba(0,212,255,.05);font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:#64748b;border-radius:8px 0 0 8px;border:1px solid rgba(255,255,255,.06)">🔗 Network</td>
    <td style="padding:11px 14px;background:rgba(255,255,255,.03);border-radius:0 8px 8px 0;border:1px solid rgba(255,255,255,.06);border-left:none">
      <span style="background:rgba(0,212,255,.15);color:#00d4ff;border:1px solid rgba(0,212,255,.3);border-radius:5px;padding:3px 12px;font-size:12px;font-weight:700">'. $method .'</span>
    </td>
  </tr>
  <tr>
    <td style="padding:11px 14px;background:rgba(0,212,255,.05);font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:#64748b;border-radius:8px 0 0 8px;border:1px solid rgba(255,255,255,.06);vertical-align:top"># TX Hash</td>
    <td style="padding:11px 14px;background:rgba(255,255,255,.03);font-family:Courier New,monospace;font-size:11px;color:#00d4ff;word-break:break-all;line-height:1.6;border-radius:0 8px 8px 0;border:1px solid rgba(255,255,255,.06);border-left:none">'. $txHash .'</td>
  </tr>
  <tr>
    <td style="padding:11px 14px;background:rgba(0,212,255,.05);font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:#64748b;border-radius:8px 0 0 8px;border:1px solid rgba(255,255,255,.06)">🕐 Time</td>
    <td style="padding:11px 14px;background:rgba(255,255,255,.03);font-size:13px;color:#94a3b8;border-radius:0 8px 8px 0;border:1px solid rgba(255,255,255,.06);border-left:none">'. $dateNice .' &nbsp;·&nbsp; <span style="color:#e8b84b;font-weight:700">'. $refId .'</span></td>
  </tr>
  </table>

  <table width="100%" cellpadding="0" cellspacing="0" style="margin-top:18px">
  <tr><td style="background:rgba(16,185,129,.07);border:1px solid rgba(16,185,129,.2);border-radius:10px;padding:16px 18px">
    <div style="font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#10b981;margin-bottom:7px">✅ Action Required</div>
    <div style="font-size:12px;color:#94a3b8;line-height:1.8">
      1. Verify TX hash on blockchain explorer<br>
      2. Confirm deposit amount<br>
      3. Approve and credit client account<br>
      4. Notify client of approval
    </div>
  </td></tr></table>
</td></tr>

<tr><td style="background:#080f1e;border-radius:0 0 16px 16px;padding:18px 32px;text-align:center;
  border:1px solid rgba(0,212,255,.12);border-top:none">
  <div style="font-size:12px;font-weight:700;color:#00d4ff">RANGE MARKETS</div>
  <div style="font-size:10px;color:#334155;margin-top:4px">Automated notification · Do not reply · &copy; '. date('Y') .' Range Markets</div>
</td></tr>

</table></td></tr></table></body></html>';

$plainText = "RANGE MARKETS - NEW DEPOSIT\n" . str_repeat("=",40) . "\n"
    . "Ref    : $refId\nName   : $name\nEmail  : $email\n"
    . "Network: $method\nTX     : $txHash\nTime   : $dateNice\nIP     : $ip\n";

// SMTP Send function (TLS, no extra libraries needed)
function smtpSend($host, $port, $user, $pass, $from, $fromName, $to, $subj, $html, $plain) {
    $b = md5(uniqid());
    $nl = "\r\n";
    $msg  = "Date: " . date('r') . $nl;
    $msg .= "From: =?UTF-8?B?" . base64_encode($fromName) . "?= <$from>$nl";
    $msg .= "To: $to$nl";
    $msg .= "Subject: =?UTF-8?B?" . base64_encode($subj) . "?=$nl";
    $msg .= "MIME-Version: 1.0$nl";
    $msg .= "Content-Type: multipart/alternative; boundary=\"$b\"$nl";
    $msg .= "X-Priority: 1$nl$nl";
    $msg .= "--$b${nl}Content-Type: text/plain; charset=UTF-8${nl}Content-Transfer-Encoding: base64$nl$nl";
    $msg .= chunk_split(base64_encode($plain)) . $nl;
    $msg .= "--$b${nl}Content-Type: text/html; charset=UTF-8${nl}Content-Transfer-Encoding: base64$nl$nl";
    $msg .= chunk_split(base64_encode($html)) . $nl;
    $msg .= "--$b--$nl";

    $ctx = stream_context_create(['ssl' => [
        'verify_peer' => false, 'verify_peer_name' => false
    ]]);
    $s = stream_socket_client("tcp://$host:$port", $en, $es, 30, STREAM_CLIENT_CONNECT, $ctx);
    if (!$s) return ["ok"=>false,"error"=>"Connect failed: $es"];

    $r = function() use ($s) { $o=''; while($l=fgets($s,515)){$o.=$l;if($l[3]==' ')break;} return $o; };
    $w = function($c) use ($s) { fputs($s,"$c\r\n"); };

    $r(); // greeting
    $w("EHLO rangeforex.com"); $r();

    // STARTTLS
    $w("STARTTLS"); $r();
    stream_socket_enable_crypto($s, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);

    $w("EHLO rangeforex.com"); $r();
    $w("AUTH LOGIN"); $r();
    $w(base64_encode($user)); $r();
    $w(base64_encode($pass)); $auth = $r();
    if (strpos($auth,'235')===false) { fclose($s); return ["ok"=>false,"error"=>"Auth failed: $auth"]; }

    $w("MAIL FROM:<$from>"); $r();
    $w("RCPT TO:<$to>"); $r();
    $w("DATA"); $r();
    $w($msg."."); $sent = $r();
    $w("QUIT"); fclose($s);

    return ["ok"=>strpos($sent,'250')!==false, "resp"=>$sent];
}

$result = smtpSend(
    $SMTP_HOST, $SMTP_PORT, $SMTP_USER, $SMTP_PASS,
    $SMTP_FROM, $SMTP_FROM_NAME, $ADMIN_EMAIL,
    "New Deposit - $method | $name | $refId",
    $htmlBody, $plainText
);

// Log backup regardless
$status  = $result['ok'] ? 'SENT' : 'FAILED';
file_put_contents(__DIR__.'/deposits_log.txt',
    date('Y-m-d H:i:s')." | $status | $refId | $name | $email | $method | ".substr($txHash,0,20)."... | IP:$ip\n",
    FILE_APPEND|LOCK_EX);

if (!$result['ok']) error_log("Range SMTP Error: ".json_encode($result));

echo json_encode([
    "status"    => "success",
    "message"   => "Deposit submitted!",
    "reference" => $refId
]);
?>
