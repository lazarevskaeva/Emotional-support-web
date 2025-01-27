<?php
// Make sure the user has successfully paid (using a payment verification system like PayPal IPN)
$isPaymentSuccessful = true; // You would need to verify this based on PayPal IPN (Instant Payment Notification)

// Only provide the download link if the payment is successful
if ($isPaymentSuccessful) {
    $downloadLink = "https://www.yoursite.com/ebook.pdf";  // Direct link to the ebook
    echo "<h1>Thank you for your purchase!</h1>";
    echo "<p>Your payment was successful. You can download your ebook below:</p>";
    echo "<a href='$downloadLink' download>Click here to download your ebook</a>";
} else {
    echo "<h1>Payment failed</h1>";
    echo "<p>There was an issue with your payment. Please try again.</p>";
}
?>
