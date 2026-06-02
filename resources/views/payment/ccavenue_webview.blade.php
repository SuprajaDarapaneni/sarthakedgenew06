<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processing Payment...</title>
    <style>
        body { font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background-color: #f8f9fa; }
        .loader { border: 4px solid #f3f3f3; border-top: 4px solid #3498db; border-radius: 50%; width: 40px; height: 40px; animation: spin 1s linear infinite; margin: 0 auto 20px auto; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        .message { text-align: center; color: #333; }
    </style>
</head>
<body onload="document.getElementById('ccavenue_form').submit();">
    <div class="message">
        <div class="loader" id="loader"></div>
        <h2 id="status_text">Please wait...</h2>
        <p id="status_desc">Redirecting to secure payment gateway.</p>
    </div>
    <form id="ccavenue_form" method="POST" action="{{ $url }}" style="text-align: center; margin-top: 20px;">
        <input type="hidden" name="encRequest" value="{{ $encRequest }}">
        <input type="hidden" name="access_code" value="{{ $access_code }}">
        
        <noscript>
            <button type="submit" style="padding: 12px 24px; background-color: #B58955; color: white; border: none; border-radius: 5px; font-size: 16px; font-weight: bold; cursor: pointer;">Click here to Continue</button>
        </noscript>
        
        <div id="fallbackBtn">
             <button type="submit" style="padding: 12px 24px; background-color: #B58955; color: white; border: none; border-radius: 5px; font-size: 16px; font-weight: bold; cursor: pointer;">Click here to Continue</button>
        </div>
    </form>
    <script>
        // Hide the fallback button if JavaScript is active and try to submit automatically
        document.getElementById('fallbackBtn').style.display = 'none';
        setTimeout(function() {
            // If it's still here after 2 seconds, show the button
            document.getElementById('fallbackBtn').style.display = 'block';
            document.getElementById('loader').style.display = 'none';
            document.getElementById('status_text').innerText = 'Action Required';
            document.getElementById('status_desc').innerText = 'Please click the button below to proceed to payment.';
        }, 2000);
        document.getElementById('ccavenue_form').submit();
    </script>
</body>
</html>
