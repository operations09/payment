<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Range Markets - Crypto Deposit</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            /* CLEAN CRYPTO GRADIENT - NO ANIMATIONS */
            background: linear-gradient(135deg, #0c0c1a 0%, #1a0d2e 30%, #0f172a 70%, #000000 100%);
            color: #e2e8f0;
            min-height: 100vh;
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
        }
        .tagline { 
            font-size: 1.15rem; 
            color: #94a3b8;
            font-weight: 500;
        }
        
        .container {
            max-width: 520px;
            margin: 0 auto;
            padding: 0 1.5rem 3rem;
        }
        
        .trust-badges {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin: 2rem 0 3rem;
            flex-wrap: wrap;
        }
        .badge {
            background: rgba(15,23,42,0.7);
            backdrop-filter: blur(20px);
            padding: 1.2rem 1.5rem;
            border-radius: 16px;
            border: 1px solid rgba(59,130,246,0.4);
            text-align: center;
            transition: all 0.3s ease;
            min-width: 120px;
        }
        .badge:hover {
            transform: translateY(-3px);
            border-color: #00d4ff;
            box-shadow: 0 10px 25px rgba(0,212,255,0.2);
        }
        .badge i { 
            font-size: 1.8rem; 
            background: linear-gradient(135deg, #00d4ff, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.5rem;
            display: block;
        }
        .badge div { color: #cbd5e1; font-weight: 500; font-size: 0.85rem; }
        
        .card {
            background: rgba(17,24,39,0.85);
            backdrop-filter: blur(25px);
            border-radius: 24px;
            padding: 3rem 2.5rem;
            border: 1px solid rgba(59,130,246,0.3);
            box-shadow: 0 25px 50px rgba(0,0,0,0.6);
            margin-bottom: 2rem;
        }
        
        h2 { 
            text-align: center; 
            margin-bottom: 2rem; 
            font-size: 1.9rem;
            background: linear-gradient(135deg, #00d4ff, #a855f7);
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
        }
        select, input {
            width: 100%;
            padding: 1.2rem 1.2rem 1.2rem 4rem;
            background: rgba(30,41,59,0.9);
            border: 2px solid rgba(51,65,85,0.8);
            border-radius: 16px;
            color: #f8fafc;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        select:focus, input:focus {
            outline: none;
            border-color: #00d4ff;
            background: rgba(30,41,59,1);
            box-shadow: 0 0 0 4px rgba(0,212,255,0.15);
        }
        select option { background: #1e293b; color: #f1f5f9; }
        
        .icon-input {
            position: absolute;
            left: 1.3rem;
            top: 3.4rem;
            color: #64748b;
            font-size: 1.1rem;
            z-index: 2;
        }
        input:focus + .icon-input, select:focus + .icon-input { 
            color: #00d4ff; 
        }
        
        #qr-section {
            text-align: center;
            padding: 2.5rem;
            background: rgba(30,41,59,0.8);
            border-radius: 20px;
            margin: 2rem 0;
            border: 2px dashed rgba(0,212,255,0.4);
        }
        #qr-image {
            max-width: 250px;
            height: 250px;
            margin: 0 auto 1rem;
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
        }
        #qr-address {
            font-family: 'Courier New', monospace;
            font-size: 0.88rem;
            color: #00d4ff;
            word-break: break-all;
            padding: 1rem 1.2rem;
            background: rgba(0,212,255,0.08);
            border-radius: 10px;
            border-left: 4px solid #00d4ff;
        }
        
        .btn {
            width: 100%;
            padding: 1.3rem;
            background: linear-gradient(135deg, #00d4ff 0%, #a855f7 100%);
            color: #000;
            border: none;
            border-radius: 16px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(0,212,255,0.4);
        }
        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .status {
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin: 1rem 0;
            text-align: center;
            font-weight: 600;
            font-size: 0.95rem;
        }
        .success { 
            background: rgba(34,197,94,0.2); 
            border: 1px solid rgba(34,197,94,0.4); 
            color: #86efac;
        }
        .info { 
            background: rgba(59,130,246,0.2); 
            border: 1px solid rgba(59,130,246,0.3); 
            color: #93c5fd;
        }
        .hidden { display: none; }
        
        .footer {
            text-align: center;
            padding: 2rem 1rem;
            color: #64748b;
            font-size: 0.9rem;
            border-top: 1px solid rgba(255,255,255,0.08);
            margin-top: 2rem;
        }
        
        @media (max-width: 480px) {
            .container { padding: 1rem; }
            .card { padding: 2.5rem 2rem; }
            #qr-image { max-width: 220px; height: 220px; }
            .trust-badges { gap: 1rem; }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">Range Markets</div>
        <div class="tagline">Trusted Broker • Secure Crypto Deposits</div>
    </div>

    <div class="container">
        <div class="trust-badges">
            <div class="badge">
                <i class="fas fa-shield-alt"></i>
                <div>Regulated</div>
            </div>
            <div class="badge">
                <i class="fas fa-lock"></i>
                <div>Encrypted</div>
            </div>
            <div class="badge">
                <i class="fas fa-bolt"></i>
                <div>Lightning</div>
            </div>
        </div>

        <div class="card">
            <h2><i class="fas fa-coins" style="margin-right: 0.5rem;"></i> Crypto Deposit</h2>
            
            <div class="form-group">
                <label>Select Network</label>
                <i class="fas fa-network-wired icon-input"></i>
                <select id="payment-method" onchange="generateQR()">
                    <option value="">Choose Network...</option>
                    <option value="TRC20">TRC20 (TRON) </option>
                    <option value="ERC20">ERC20 (ETH/USDT)</option>
                </select>
            </div>

            <div id="qr-section" class="hidden">
                <img id="qr-image" src="" alt="Deposit QR">
                <div style="margin: 1rem 0; font-weight: 600; color: #e2e8f0;">Scan QR Code to Deposit</div>
                <div id="qr-address"></div>
            </div>

            <div class="form-group">
                <label>Full Name</label>
                <i class="fas fa-user icon-input"></i>
                <input type="text" id="name" placeholder="Enter your full name">
            </div>
            
            <div class="form-group">
                <label>Transaction Hash</label>
                <i class="fas fa-hashtag icon-input"></i>
                <input type="text" id="transaction-hash" placeholder="Paste transaction hash">
            </div>
            
            <div id="status" class="status info hidden">
                <i class="fas fa-info-circle" style="margin-right: 0.5rem;"></i>
                Select network to generate deposit address
            </div>
            
            <button id="submit-btn" class="btn" onclick="submitDeposit()" disabled>
                <i class="fas fa-paper-plane" style="margin-right: 0.5rem;"></i>
                Submit Deposit
            </button>
        </div>

        <div class="footer">
            <p>Range Markets © 2026 | Deposits processed 24/7 | Average approval: 3-5 minutes</p>
        </div>
    </div>

    <script>
        // YOUR REAL WALLET ADDRESSES HERE
        const wallets = {
            TRC20: "TYourTRC20AddressHere123456789",
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
                status.textContent = 'Select deposit network first';
                status.className = 'status info';
                status.classList.remove('hidden');
                return;
            }

            const address = wallets[method];
            qrImage.src = `https://api.qrserver.com/v1/create-qr-code/?size=280x280&data=${encodeURIComponent(address)}&colorDark=00d4ff&colorLight=1e293b`;
            qrAddress.innerHTML = `<strong>${method}:</strong> ${address}`;
            qrSection.classList.remove('hidden');
            submitBtn.disabled = false;
            status.innerHTML = '<i class="fas fa-check-circle" style="color:#10b981;margin-right:0.5rem;"></i> Ready! Scan QR and send crypto';
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
                status.innerHTML = '<i class="fas fa-exclamation-triangle" style="color:#f59e0b;margin-right:0.5rem;"></i> Complete all fields';
                status.className = 'status info';
                return;
            }

            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-right:0.5rem;"></i> Submitting...';
            submitBtn.disabled = true;

            fetch('submit.php', {
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
                    status.innerHTML = '<i class="fas fa-check-circle" style="color:#10b981;margin-right:0.5rem;"></i> Deposit submitted! We will verify shortly.';
                    status.className = 'status success';
                    // Reset form
                    document.getElementById('name').value = '';
                    document.getElementById('transaction-hash').value = '';
                    document.getElementById('payment-method').value = '';
                    qrSection.classList.add('hidden');
                    submitBtn.disabled = true;
                } else {
                    status.innerHTML = '<i class="fas fa-exclamation-triangle" style="color:#f59e0b;margin-right:0.5rem;"></i> ' + (data.error || 'Error occurred');
                    status.className = 'status info';
                }
            })
            .catch(error => {
                status.innerHTML = '<i class="fas fa-wifi-slash" style="color:#ef4444;margin-right:0.5rem;"></i> Network error - try again';
                status.className = 'status info';
            })
            .finally(() => {
                submitBtn.innerHTML = '<i class="fas fa-paper-plane" style="margin-right:0.5rem;"></i> Submit Deposit';
                submitBtn.disabled = false;
            });
        }
    </script>
</body>
</html>
