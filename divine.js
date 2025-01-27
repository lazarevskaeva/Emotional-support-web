document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menu-toggle');
    const mobileNav = document.getElementById('mobile-nav');

    menuToggle.addEventListener('click', function() {
        mobileNav.classList.toggle('show');
    });

    // Close the mobile menu when a link is clicked
    document.querySelectorAll('#mobile-nav a').forEach(link => {
        link.addEventListener('click', function() {
            mobileNav.classList.remove('show');
        });
    });
});

// PayPal Integration (keep this section)
paypal.Buttons({
    createOrder: function(data, actions) {
      return actions.order.create({
        purchase_units: [{
          amount: {
            value: '8.00'
          }
        }]
      });
    },
    onApprove: function(data, actions) {
      return actions.order.capture().then(function(details) {
        alert('Payment Successful: ' + details.payer.name.given_name);
      });
    }
  }).render('#paypal-button');
  
  // Toggle between PayPal and Visa payment methods
function togglePaymentMethod(method) {
    if (method === 'paypal') {
        document.getElementById('paypal-button-container').style.display = 'block';
        document.getElementById('visa-payment-form').style.display = 'none';
    } else if (method === 'visa') {
        document.getElementById('paypal-button-container').style.display = 'none';
        document.getElementById('visa-payment-form').style.display = 'block';
    }
}
  
  