<?php
// PayPal IPN Listener

// Read the IPN message sent by PayPal
$raw_post_data = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$ipn_data = array();

foreach ($raw_post_array as $keyval) {
    $keyval = explode('=', $keyval);
    if (count($keyval) == 2) {
        $ipn_data[$keyval[0]] = urldecode($keyval[1]);
    }
}

// Verify the IPN message
$paypal_url = "https://www.paypal.com/cgi-bin/webscr";
$req = 'cmd=_notify-validate';
foreach ($ipn_data as $key => $value) {
    $value = urlencode(stripslashes($value));
    $req .= "&$key=$value";
}

$ch = curl_init($paypal_url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);

if (strcmp($response, "VERIFIED") == 0) {
    // Check that the payment was successful and the amount is correct
    if ($ipn_data['payment_status'] == "Completed" && $ipn_data['mc_gross'] == 10.00) {  // Ensure the correct price
        // Grant access to the ebook (e.g., by sending an email with the download link)
        // Alternatively, you can redirect to the thank-you page with the download link.
        header("Location: thank-you.php");  // Redirect user to the thank-you page
        exit;
    }
} else {
    // Invalid IPN message, log the error or send an alert
    // You can also redirect to a failure page if the IPN message was invalid
    echo "Payment Verification Failed!";
}
?>
