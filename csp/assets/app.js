
// start:localAjax
function localAjax() {
    fetch('ajax.php')
    .then(function(response) {
        return response.json();
    })
    .then(function(d) {
        var el = document.querySelector('#ajax-local');
        el.textContent = d.msg;
    })
    .catch(function(err) {
        var el = document.querySelector('#ajax-local');
        el.textContent = err;
    });
}
// end:localAjax

// start:stripeExample
function stripeExample()
{
    var handler = StripeCheckout.configure({
        key: 'pk_KBCS2K6UgQc8K9VZCtNMOK4AEl5aU',
        image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
        locale: 'auto',
        token: function(token) {
          // You can access the token ID with `token.id`.
          // Get the token ID to your server-side code for use.
        }
    });
      
    document.getElementById('stripe-button').addEventListener('click', function(e) {
        // Open Checkout with further options:
        handler.open({
          name: 'Demo Site',
          description: '2 widgets',
          amount: 10,
        });
        e.preventDefault();
    });
      
    window.addEventListener('popstate', function() {
        handler.close();
    });
}
// end:stripeExample

// start:evalExample
function evalExample() {
    new Function(`document.getElementById('eval-2').textContent='[!] Ran external using new Function()'`)();
}
// end:evalExample

document.addEventListener('DOMContentLoaded', function() {
    localAjax();
    try {
        stripeExample();
    } catch (e) {}
    evalExample();
});