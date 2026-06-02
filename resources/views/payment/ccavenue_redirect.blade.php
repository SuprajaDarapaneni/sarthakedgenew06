<!DOCTYPE html>
<html>
<head>
    <title>CCAvenue Payment Redirect</title>
</head>
<body onload="document.ccavenue_form.submit();">
    <div style="text-align: center; margin-top: 50px;">
        <h2>Redirecting to CCAvenue...</h2>
        <p>Please do not refresh the page or click back button.</p>
    </div>
    <form method="post" name="ccavenue_form" action="{{ $url }}">
        <input type="hidden" name="encRequest" value="{{ $encRequest }}">
        <input type="hidden" name="access_code" value="{{ $access_code }}">
    </form>
</body>
</html>
