<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Range Forex Payment Gateway</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
            margin: 0; 
            padding: 20px;
        }
        .container { 
            background: #fff; 
            padding: 2.5rem; 
            border-radius: 12px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.2); 
            width: 100%; 
            max-width: 500px; 
            text-align: center; 
        }
        h1 { 
            color: #333; 
            font-size: 1.8rem; 
            margin-bottom: 30px; 
            font-weight: bold;
        }
        .form-group { 
            margin-bottom: 20px; 
            text-align: left; 
        }
        label { 
            display: block; 
            margin-bottom: 8px; 
            font-weight: 600; 
            color: #555;
        }
        select, input { 
            width: 100%; 
            padding: 12px; 
            border: 2px solid #e1e5e9; 
            border-radius: 8px; 
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        select:focus, input:focus {
            outline: none;
            border-color: #667eea;
        }
        #qr-section {
            margin: 25px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 12px;
            border: 2px dashed #dee2e6;
        }
        #qr-image { 
            max-width: 220px; 
            height: auto; 
            margin-bottom: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        #qr-address {
            font-family: monospace;
            font-size: 14px;
            color: #666;
            word-break: break-all;
            padding: 10px;
            background: #fff;
            border-radius: 6px;
            margin-top: 10px;
        }
        button { 
            width: 100%; 
            padding: 15px; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: #fff; 
            border: none; 
            border-radius: 8px; 
            cursor: pointer; 
            font-size: 18px; 
            font-weight: 600;
            transition: transform 0.2s;
        }
        button:hover { 
            transform: translateY(-2px);
        }
        button:active {
            transform: translateY(0);
        }
        .hidden { display: none; }
    </style>
</head>
<body>

<div class="container">
    <h1>Range Forex Payment Gateway</h1>
    
    <div class="form-group">
        <label for="payment-method">Select Payment Method:</label>
        <select id="payment-method" onchange="generateQR()">
            <option value="">Choose method...</option>
            <option value="TRC20">TRC20 (Tron)</option>
            <option value="ERC20">ERC20 (Ethereum)</option>
        </select>
    </div>

    <div id="qr-section" class="hidden">
        <img id="qr-image" src="" alt="Payment QR Code" />
        <p style="margin: 10px 0; font-weight: 600; color: #333;">Scan QR code to complete payment</p>
        <div id="qr-address"></div>
    </div>

    <div class="form-group">
        <label for="name">Your Full Name:</label>
        <input type="text" id="name" placeholder="Enter your full name" required>
    </div>
    
    <div class="form-group">
        <label for="transaction-hash">Transaction Hash:</label>
        <input type="text" id="transaction-hash" placeholder="Paste transaction hash here" required>
    </div>
    
    <button id="submit-btn" onclick="submitPayment()" disabled>Submit Payment</button>
</div>

<script>
    // Your wallet addresses - REPLACE WITH REAL ADDRESSES
    const walletAddresses = {
        TRC20: "TYourTRC20AddressHere123456789",  // Replace with actual TRC20 address
        ERC20: "0x742d35Cc6634C0532925a3b8D982d8bE9e7E5D5a"  // Sample ERC20 (update yours)
    };

    function generateQR() {
        const method = document.getElementById('payment-method').value;
        const qrSection = document.getElementById('qr-section');
        const qrImage = document.getElementById('qr-image');
        const qrAddress = document.getElementById('qr-address');
        const submitBtn = document.getElementById('submit-btn');

        if (!method) {
            qrSection.classList.add('hidden');
            submitBtn.disabled = true;
            return;
        }

        const address = walletAddresses[method];
        qrImage.src = `https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=${encodeURIComponent(address)}&colorDark=000000&colorLight=FFFFFF`;
        qrAddress.textContent = `${method} Address: ${address}`;
        qrSection.classList.remove('hidden');
        submitBtn.disabled = false;
    }

    function submitPayment() {
        const name = document.getElementById('name').value.trim();
        const txHash = document.getElementById('transaction-hash').value.trim();
        const method = document.getElementById('payment-method').value;

        if (!name || !txHash || !method) {
            alert("Please complete all fields and select payment method.");
            return;
        }

        // Send to your PHP backend
        fetch('submit.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
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
                alert('✅ Payment submitted! We will verify and approve shortly.');
                // Optional: Reset form or redirect
            } else {
                alert('❌ Error: ' + (data.error || 'Submission failed'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ Network error. Please try again.');
        });
    }

    // Auto-generate QR on page load if needed
    window.onload = function() {
        generateQR();
    };
</script>

</body>
</html>
