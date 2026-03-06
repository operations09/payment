<?php
// ========================================
// Range Markets - Crypto Deposit Page
// SINGLE FILE - Frontend + Backend
// ========================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input || empty(trim($input['name'])) || empty(trim($input['transaction_hash'])) || empty($input['method'])) {
        echo json_encode(["status" => "error", "error" => "Please fill all fields"]);
        exit;
    }
    
    $name = htmlspecialchars(trim($input['name']));
    $txHash = htmlspecialchars(trim($input['transaction_hash']));
    $method = strtoupper(htmlspecialchars($input['method']));
    
    // YOUR EMAIL ADDRESS - CHANGE THIS!
    $adminEmail = "operations@rangeforex.com";
    
    $subject = "🔔 Range Markets - New $method Deposit";
    $message = "New Crypto Deposit Received:\n\n";
    $message .= "👤 Client: $name\n";
    $message .= "💰 Network: $method\n";
    $message .= "🔗 TX Hash: $txHash\n";
    $message .= "⏰ Time: " . date('Y-m-d H:i:s T') . "\n";
    $message .= "🌐 IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'Unknown') . "\n\n";
    $message .= "Action Required: Verify TX on blockchain explorer";
    
    $headers = "From: operations@rangeforex.com\r\n";
    $headers .= "Reply-To: $name <operations@rangeforex.com>\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    
    $emailSent = mail($adminEmail, $subject, $message, $headers);
    
    echo json_encode([
        "status" => "success",
        "message" => "Deposit submitted successfully!",
        "email_sent" => $emailSent,
        "data" => ["name" => $name, "tx" => $txHash, "method" => $method]
    ]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Range Markets - Secure Crypto Deposit</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #0c0c1a 0%, #1a0d2e 30%, #0f172a 70%, #000000 100%);
            color: #e2e8f0;
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        .header {
            text-align: center;
            padding: 3rem 1rem 2rem;
            position: relative;
        }
        .logo { 
            font-size: 2.8rem; 
            font-weight: 800; 
            background: linear-gradient(135deg, #00d4ff, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.5rem;
            text-shadow: 0 0 30px rgba(0,212,255,0.3);
        }
        .tagline { 
            font-size: 1.15rem; 
            color: #94a3b8;
            font-weight: 500;
            max-width: 500px;
            margin: 0 auto;
        }
        
        .container {
            max-width: 520px;
            margin: 0 auto;
            padding: 0 1.5rem 3rem;
            position: relative;
            z-index: 1;
        }
        
        .trust-badges {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin: 2rem 0 3rem;
            flex-wrap: wrap;
        }
        .badge {
            background: rgba(15,23,42,0.8);
            backdrop-filter: blur(20px);
            padding: 1.2rem 1.5rem;
            border-radius: 16px;
            border: 1px solid rgba(59,130,246,0.4);
            text-align: center;
            transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
            min-width: 120px;
            cursor: default;
        }
        .badge:hover {
            transform: translateY(-5px);
            border-color: #00d4ff;
            box-shadow: 0 20px 40px rgba(0,212,255,0.15);
        }
        .badge i { 
            font-size: 1.8rem; 
            background: linear-gradient(135deg, #00d4ff, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.5rem;
            display: block;
        }
        .badge div { 
            color: #cbd5e1; 
            font-weight: 500; 
            font-size: 0.85rem; 
        }
        
        .card {
            background: rgba(17,24,39,0.9);
            backdrop-filter: blur(30px);
            border-radius: 24px;
            padding: 3rem 2.5rem;
            border: 1px solid rgba(59,130,246,0.3);
            box-shadow: 
                0 25px 50px rgba(0,0,0,0.6),
                inset 0 1px 0 rgba(255,255,255,0.05);
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(0,212,255,0.6), transparent);
        }
        
        h2 { 
            text-align: center; 
            margin-bottom: 2rem; 
            font-size: 1.95rem;
            background: linear-gradient(135deg, #00d4ff 0%, #a855f7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
        }
        
        .form-group {
            margin-bottom: 1.8rem;
            position: relative;
        }
        label {
            display: block;
            margin-bottom: 0.8rem;
            font-weight: 600;
            color: #e2e8f0;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        select, input {
            width: 100%;
            padding: 1.2rem 1.2rem 1.2rem 4rem !important;
            background: rgba(30,41,59,0.9);
            border: 2px solid rgba(51,65,85,0.8);
            border-radius: 16px;
            color: #f8fafc;
            font-size: 1rem;
            transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
            font-family: inherit;
        }
        select:focus, input:focus {
            outline: none;
            border-color: #00d4ff;
            background: rgba(30,41,59,1);
            box-shadow: 
                0 0 0 4px rgba(0,212,255,0.15),
                0 10px 25px rgba(0,212,255,0.1);
        }
        select option { background: #1e293b; color: #f1f5f9; }
        input::placeholder { color: #64748b; }
        
        .icon-input {
            position: absolute;
            left: 1.3rem;
            top: 3.6rem;
            color: #64748b;
            font-size: 1.1rem;
            z-index: 2;
            transition: color 0.3s ease;
        }
        input:focus + .icon-input, select:focus + .icon-input { color: #00d4ff; }
        
        #qr-section {
            text-align: center;
            padding: 2.5rem 2rem;
            background: rgba(30,41,59,0.8);
            border-radius: 20px;
            margin: 2rem 0;
            border: 2px dashed rgba(0,212,255,0.4);
            backdrop-filter: blur(15px);
            transition: all 0.3s ease;
        }
        #qr-section.show { border-color: #10b981; box-shadow: 0 0 30px rgba(16,185,129,0.2); }
        #qr-image {
            max-width: 260px;
            height: 260px;
            margin: 0 auto 1.2rem;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.5);
            border: 3px solid rgba(0,212,255,0.3);
        }
        #qr-address {
            font-family: 'JetBrains Mono', 'Courier New', monospace;
            font-size: 0.9rem;
            color: #00d4ff;
            word-break: break-all;
            padding: 1.2rem;
            background: rgba(0,212,255,0.08);
            border-radius: 12px;
            border-left: 4px solid #00d4ff;
            text-align: left;
        }
        
        .btn {
            width: 100%;
            padding: 1.4rem;
            background: linear-gradient(135deg, #00d4ff 0%, #a855f7 50%, #00d4ff 100%);
            color: #000;
            border: none;
            border-radius: 16px;
            font-size: 1.15rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4,0,0.2,1);
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
        }
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: left 0.6s;
        }
        .btn:hover::before { left: 100%; }
        .btn:hover:not(:disabled) {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 20px 45px rgba(0,212,255,0.3);
        }
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        .btn.loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin-left: -10px;
            margin-top: -10px;
            border: 2px solid transparent;
            border-top: 2px solid #000;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        
        .status {
            padding: 1.2rem 1.5rem;
            border-radius: 16px;
            margin: 1.5rem 0;
            text-align: center;
            font-weight: 600;
            font-size: 1rem;
            backdrop-filter: blur(15px);
            transition: all 0.3s ease;
        }
        .success { 
            background: rgba(16,185,129,0.2); 
            border: 1px solid rgba(16,185,129,0.5); 
            color: #86efac;
        }
        .error { 
            background: rgba(239,68,68,0.2); 
            border: 1px solid rgba(239,68,68,0.5); 
            color: #fca5a5;
        }
        .info { 
            background: rgba(59,130,246,0.2); 
            border: 1px solid rgba(59,130,246,0.4); 
            color: #93c5fd;
        }
        .hidden { display: none; }
        
        .footer {
            text-align: center;
            padding: 3rem 1rem;
            color: #64748b;
            font-size: 0.9rem;
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        
        @media (max-width: 480px) {
            .container { padding: 1rem; }
            .card { padding: 2.5rem 2rem; }
            #qr-image { max-width: 220px; height: 220px; }
            .trust-badges { gap: 1rem; flex-direction: column; align-items: center; }
            .logo { font-size: 2.2rem; }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">Range Markets</div>
        <div class="tagline">Trusted Global Broker • Lightning Fast Crypto Deposits</div>
    </div>

    <div class="container">
        <!-- Trust Badges -->
        <div class="trust-badges">
            <div class="badge">
                <i class="fas fa-shield-alt"></i>
                <div>Regulated</div>
            </div>
            <div class="badge">
                <i class="fas fa-lock"></i>
                <div>SSL Secured</div>
            </div>
            <div class="badge">
                <i class="fas fa-bolt"></i>
                <div>Instant</div>
            </div>
            <div class="badge">
                <i class="fas fa-clock"></i>
                <div>24/7</div>
            </div>
        </div>

        <!-- Main Card -->
        <div class="card">
            <h2><i class="fas fa-coins" style="margin-right: 0.5rem;"></i> Crypto Deposit</h2>
            
            <div class="form-group">
                <label>Select Network</label>
                <i class="fas fa-network-wired icon-input"></i>
                <select id="payment-method" onchange="generateQR()">
                    <option value="">Choose Network...</option>
                    <option value="TRC20">TRC20 (TRON) • 3s • $0.01 fee</option>
                    <option value="ERC20">ERC20 (ETH/USDT) • 15s • $1.50 fee</option>
                </select>
            </div>

            <div id="qr-section" class="hidden">
                <img id="qr-image" src="" alt="Deposit QR Code">
                <div style="margin: 1.5rem 0; font-weight: 700; font-size: 1.1rem; color: #e2e8f0;">
                    Scan QR Code to Deposit
                </div>
                <div id="qr-address"></div>
            </div>

            <div class="form-group">
                <label>Full Name <span style="color: #ef4444;">*</span></label>
                <i class="fas fa-user icon-input"></i>
                <input type="text" id="name" placeholder="Enter your full name for verification">
            </div>
            
            <div class="form-group">
                <label>Transaction Hash <span style="color: #ef4444;">*</span></label>
                <i class="fas fa-hashtag icon-input"></i>
                <input type="text" id="transaction-hash" placeholder="Paste TX hash from your wallet (e.g. 0x123...)">
            </div>
            
            <div id="status" class="status info hidden">
                <i class="fas fa-info-circle" style="margin-right: 0.5rem;"></i>
                Select network to generate your deposit address
            </div>
            
            <button id="submit-btn" class="btn" onclick="submitDeposit()" disabled>
                <i class="fas fa-paper-plane" style="margin-right: 0.5rem;"></i>
                Submit Deposit Proof
            </button>
        </div>

        <div class="footer">
            <p>
                <i class="fas fa-check-circle" style="color: #10b981;"></i> 
                Deposits processed 24/7 | Average verification: 3-5 minutes | 
                <i class="fas fa-shield-alt" style="color: #00d4ff;"></i> 
                100% Secure
            </p>
            <p style="margin-top: 0.5rem; opacity: 0.7;">Range Markets © 2026 | Trusted Since 2018</p>
        </div>
    </div>

    <script>
        // YOUR WALLET ADDRESSES - UPDATE THESE IMMEDIATELY!
        const wallets = {
            TRC20: "TYourRealTRC20AddressHere123456789",
            ERC20: "0x742d35Cc6634C0532925a3b8D982d8bE9e7E5D5a"
        };

        function generateQR() {
            const method = document.getElementById('payment-method').value;
            const qrSection = document.getElementById('qr-section');
            const qrImage = document.getElementById('qr-image');
            const qrAddress = document.getElementById('qr-address');
            const submitBtn = document.getElementById('submit-btn');
            const status = document.getElementById('status');

            if (!method) {
                qrSection.classList.add('hidden');
                submitBtn.disabled = true;
                status.innerHTML = '<i class="fas fa-info-circle" style="margin-right: 0.5rem;"></i>Select network first';
                status.className = 'status info';
                status.classList.remove('hidden');
                return;
            }

            const address = wallets[method];
            qrImage.src = `https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=${encodeURIComponent(address)}&colorDark=00d4ff&colorLight=1e293b&qzone=2`;
            qrAddress.innerHTML = `
                <strong style="color: #00d4ff;">${method} Network:</strong><br>
                <code style="font-size: 0.85rem;">${address}</code>
            `;
            qrSection.classList.remove('hidden');
            qrSection.classList.add('show');
            submitBtn.disabled = false;
            status.innerHTML = '<i class="fas fa-circle-check" style="color:#10b981;margin-right:0.5rem;"></i>Ready! Scan QR → Send crypto → Submit TX proof';
            status.className = 'status success';
            status.classList.remove('hidden');
        }

        function submitDeposit() {
            const name = document.getElementById('name').value.trim();
            const txHash = document.getElementById('transaction-hash').value.trim();
            const method = document.getElementById('payment-method').value;
            const status = document.getElementById('status');
            const submitBtn = document.getElementById('submit-btn');

            if (!name || !txHash || !method) {
                status.innerHTML = '<i class="fas fa-exclamation-triangle" style="color:#f59e0b;margin-right:0.5rem;"></i>Complete all fields marked with *';
                status.className = 'status error';
                status.classList.remove('hidden');
                return;
            }

            // Show loading
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-right:0.5rem;"></i>Processing...';

            fetch('', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({
                    name: name,
                    transaction_hash: txHash,
                    method: method,
                    timestamp: new Date().toISOString()
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    status.innerHTML = '<i class="fas fa-check-circle" style="color:#10b981;margin-right:0.5rem;"></i>✅ Deposit submitted successfully! We will verify within 5 minutes.';
                    status.className = 'status success';
                    
                    // Reset form
                    document.getElementById('name').value = '';
                    document.getElementById('transaction-hash').value = '';
                    document.getElementById('payment-method').value = '';
                    document.getElementById('qr-section').classList.add('hidden');
                    document.getElementById('qr-section').classList.remove('show');
                    submitBtn.disabled = true;
                } else {
                    status.innerHTML = '<i class="fas fa-exclamation-triangle" style="color:#f59e0b;margin-right:0.5rem;"></i>Error: ' + (data.error || 'Unknown error');
                    status.className = 'status error';
                }
            })
            .catch(error => {
                status.innerHTML = '<i class="fas fa-wifi-slash" style="color:#ef4444;margin-right:0.5rem;"></i>Network error. Please try again.';
                status.className = 'status error';
            })
            .finally(() => {
                submitBtn.classList.remove('loading');
                submitBtn.innerHTML = '<i class="fas fa-paper-plane" style="margin-right:0.5rem;"></i>Submit Deposit Proof';
                setTimeout(() => { submitBtn.disabled = false; }, 1000);
            });
        }

        // Auto-focus name field
        window.onload = function() {
            document.getElementById('name').focus();
        }
    </script>
</body>
</html>
