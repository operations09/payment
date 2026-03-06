const nodemailer = require('nodemailer');

exports.handler = async (event) => {
  // CORS headers
  const headers = {
    'Access-Control-Allow-Origin': '*',
    'Access-Control-Allow-Headers': 'Content-Type',
    'Access-Control-Allow-Methods': 'POST, OPTIONS',
    'Content-Type': 'application/json'
  };

  // Handle preflight
  if (event.httpMethod === 'OPTIONS') {
    return { statusCode: 200, headers, body: '' };
  }
  if (event.httpMethod !== 'POST') {
    return { statusCode: 405, headers, body: JSON.stringify({ error: 'POST only' }) };
  }

  // Parse body
  let data;
  try {
    data = JSON.parse(event.body);
  } catch {
    return { statusCode: 400, headers, body: JSON.stringify({ error: 'Invalid JSON' }) };
  }

  const { name, email, transaction_hash, method } = data;
  if (!name || !transaction_hash || !method) {
    return { statusCode: 400, headers, body: JSON.stringify({ error: 'Missing fields' }) };
  }

  // ══════════════════════════════════════════════════════
  // ⚙️ SET IN NETLIFY → Site Settings → Environment Variables
  // ══════════════════════════════════════════════════════
  const SMTP_USER   = process.env.SMTP_USER;   // your_gmail@gmail.com
  const SMTP_PASS   = process.env.SMTP_PASS;   // Gmail App Password
  const ADMIN_EMAIL = process.env.ADMIN_EMAIL || 'operations@rangeforex.com';
  // ══════════════════════════════════════════════════════

  const refId    = 'RMK' + Date.now().toString().slice(-6) + Math.floor(Math.random()*90+10);
  const dateNice = new Date().toLocaleString('en-IN', {
    day:'2-digit', month:'short', year:'numeric',
    hour:'2-digit', minute:'2-digit', hour12:true, timeZone:'Asia/Kolkata'
  });

  // ── HTML Email ──────────────────────────────────────
  const htmlBody = `<!DOCTYPE html>
<html><head><meta charset="UTF-8"></head>
<body style="margin:0;padding:0;background:#0f172a;font-family:Arial,sans-serif">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#0f172a;padding:40px 20px">
<tr><td align="center"><table width="560" cellpadding="0" cellspacing="0" style="max-width:560px;width:100%">

<tr><td style="background:linear-gradient(135deg,#0c1a3a,#1a0d3e);border-radius:16px 16px 0 0;
  padding:28px 32px;text-align:center;border-bottom:3px solid #00d4ff">
  <div style="font-size:26px;font-weight:900;color:#00d4ff;letter-spacing:2px">RANGE MARKETS</div>
  <div style="font-size:10px;color:#64748b;letter-spacing:3px;text-transform:uppercase;margin-top:4px">Deposit Notification</div>
</td></tr>

<tr><td style="background:#0d1829;padding:28px 32px;border-left:1px solid rgba(0,212,255,.15);border-right:1px solid rgba(0,212,255,.15)">

  <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:16px;background:rgba(0,212,255,.08);border:1px solid rgba(0,212,255,.2);border-radius:10px">
  <tr><td style="padding:14px 18px">
    <span style="font-size:16px">💰</span>
    <span style="font-size:14px;font-weight:700;color:#00d4ff;margin-left:8px">New Crypto Deposit Submitted</span>
    <div style="font-size:12px;color:#64748b;margin-top:4px;margin-left:28px">Action required — verify and approve</div>
  </td></tr></table>

  <!-- Details Table -->
  <table width="100%" cellpadding="0" cellspacing="0">
  ${[
    ['👤 Name',    name,         '#f0f6ff', 'bold'],
    ['📧 Email',   email || '—', '#60a5fa', 'normal'],
    ['🔗 Network', `<span style="background:rgba(0,212,255,.15);color:#00d4ff;border:1px solid rgba(0,212,255,.3);border-radius:5px;padding:3px 12px;font-size:12px;font-weight:700">${method}</span>`, '#f0f6ff', 'normal'],
    ['# TX Hash',  `<span style="font-family:Courier New,monospace;font-size:11px;color:#00d4ff;word-break:break-all">${transaction_hash}</span>`, '#f0f6ff', 'normal'],
    ['🕐 Time',    `${dateNice} &nbsp;·&nbsp; <span style="color:#e8b84b;font-weight:700">${refId}</span>`, '#94a3b8', 'normal'],
  ].map(([label, value]) => `
  <tr>
    <td style="padding:10px 14px;background:rgba(0,212,255,.05);width:28%;font-size:11px;font-weight:700;
      letter-spacing:1px;text-transform:uppercase;color:#64748b;border-radius:8px 0 0 8px;
      border:1px solid rgba(255,255,255,.06)">${label}</td>
    <td style="padding:10px 14px;background:rgba(255,255,255,.03);font-size:13px;color:#f0f6ff;
      border-radius:0 8px 8px 0;border:1px solid rgba(255,255,255,.06);border-left:none">${value}</td>
  </tr>
  <tr><td colspan="2" style="height:6px"></td></tr>
  `).join('')}
  </table>

  <table width="100%" cellpadding="0" cellspacing="0" style="margin-top:16px">
  <tr><td style="background:rgba(16,185,129,.07);border:1px solid rgba(16,185,129,.2);border-radius:10px;padding:16px 18px">
    <div style="font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#10b981;margin-bottom:7px">✅ Action Required</div>
    <div style="font-size:12px;color:#94a3b8;line-height:1.8">
      1. Verify TX hash on blockchain explorer<br>
      2. Confirm deposit amount matches client<br>
      3. Approve and credit the client account<br>
      4. Notify client of successful approval
    </div>
  </td></tr></table>

</td></tr>

<tr><td style="background:#080f1e;border-radius:0 0 16px 16px;padding:16px 32px;text-align:center;
  border:1px solid rgba(0,212,255,.12);border-top:none">
  <div style="font-size:12px;font-weight:700;color:#00d4ff">RANGE MARKETS</div>
  <div style="font-size:10px;color:#334155;margin-top:3px">Automated notification · Do not reply · © ${new Date().getFullYear()} Range Markets</div>
</td></tr>

</table></td></tr></table></body></html>`;

  const plainText = `RANGE MARKETS - NEW DEPOSIT\n${'='.repeat(40)}\nRef    : ${refId}\nName   : ${name}\nEmail  : ${email || '-'}\nNetwork: ${method}\nTX     : ${transaction_hash}\nTime   : ${dateNice}\n`;

  // ── Send Email ────────────────────────────────────────
  try {
    const transporter = nodemailer.createTransporter({
      host: 'smtp.gmail.com',
      port: 587,
      secure: false,
      auth: { user: SMTP_USER, pass: SMTP_PASS },
      tls: { rejectUnauthorized: false }
    });

    await transporter.sendMail({
      from: `"Range Markets Deposits" <${SMTP_USER}>`,
      to: ADMIN_EMAIL,
      subject: `💰 New Deposit — ${method} | ${name} | ${refId}`,
      text: plainText,
      html: htmlBody,
      priority: 'high'
    });

    console.log(`✅ Email sent — ${refId} — ${name}`);
    return {
      statusCode: 200,
      headers,
      body: JSON.stringify({ status: 'success', message: 'Deposit submitted!', reference: refId })
    };

  } catch (err) {
    console.error('Email error:', err.message);
    // Still return success to user — don't block them
    return {
      statusCode: 200,
      headers,
      body: JSON.stringify({ status: 'success', message: 'Deposit recorded!', reference: refId })
    };
  }
};
