/*document.addEventListener('DOMContentLoaded', async () => {
 const stripe = Stripe('pk_test_51LJhyAHXmZTJVQtNPKSC8g3m1XkPQVmwmTgs5cH83tJ23Fzc2QPstNGfPPAELLG25iSQggztCmYzqPDoBRZFfpEh00pumktcrU');
 
 const paymentRequest = stripe.paymentRequest({
 country: 'AE',
 currency: 'aed',
 requestPayerName: true,
 requestPayerEmail: true,
 total:{
 label: 'Demo total',
 amount: 1999
 }
 });
 
 const elements = stripe.elements();
 const prButton = elements.create('paymentRequestButton', {
 paymentRequest: paymentRequest,
 });
 
 paymentRequest.canMakePayment().then((result) => {
 console.log(result);
 if(result) {
 prButton.mount('payment-request-button');
 } else {
 document.getElementById('payment-request-button').style.display = 'none';
 }
 });
 
 paymentRequest.on('paymentmethod', async(e) => {
 console.log(e);
 })
 })*/

// var stripe = Stripe('pk_test_51LHnTRCDNhKBnSZLBfv9zqI4jiFWtJtuj4VkaYzE5RGvOQCP1Kkz7dWGygoBq0S2A6aDzjCxRVaRKMM8xJXAbD0E005lJcVe1k', {
var stripe = Stripe('pk_test_51KrzE2BwNF8aAhcXNMoFjTtRn2nyHynf61jKNUDmzmSQYNXQAQGPLFol3iNsKmB5VTnrZL1wvxQoXzhAqO5ygqGs00wJghjunP', {
    apiVersion: "2020-08-27",
});
var paymentRequest = stripe.paymentRequest({
    country: 'CA',
    currency: 'cad',
    total: {
        label: 'Demo total',
        amount: 1099,
    },
    requestPayerName: true,
    requestPayerEmail: true,
});
var elements = stripe.elements();
var prButton = elements.create('paymentRequestButton', {
    paymentRequest: paymentRequest,
    style: {
        paymentRequestButton: {
          type: 'donate',
      // One of 'default', 'book', 'buy', or 'donate'
      // Defaults to 'default'

      theme: 'dark',
      // One of 'dark', 'light', or 'light-outline'
      // Defaults to 'dark'

      height: '40px'
      // Defaults to '40px'. The width is always '100%'.
  },
},
});

// Check the availability of the Payment Request API first.
paymentRequest.canMakePayment().then(function (result) {
    console.log(result);
    if (result) {
        prButton.mount('#payment-request-button');
    } else {
        document.getElementById('payment-request-button').style.display = 'none';
    }
});

paymentRequest.on('paymentmethod', function (ev) {
    // Confirm the PaymentIntent without handling potential next actions (yet).
    stripe.confirmCardPayment(
            clientSecret,
            {payment_method: ev.paymentMethod.id},
            {handleActions: false}
    ).then(function (confirmResult) {
        if (confirmResult.error) {
            // Report to the browser that the payment failed, prompting it to
            // re-show the payment interface, or show an error message and close
            // the payment interface.
            ev.complete('fail');
        } else {
            // Report to the browser that the confirmation was successful, prompting
            // it to close the browser payment method collection interface.
            ev.complete('success');
            // Check if the PaymentIntent requires any actions and if so let Stripe.js
            // handle the flow. If using an API version older than "2019-02-11"
            // instead check for: `paymentIntent.status === "requires_source_action"`.
            if (confirmResult.paymentIntent.status === "requires_action") {
                // Let Stripe.js handle the rest of the payment flow.
                stripe.confirmCardPayment(clientSecret).then(function (result) {
                    if (result.error) {
                        // The payment failed -- ask your customer for a new payment method.
                    } else {
                        // The payment has succeeded.
                    }
                });
            } else {
                // The payment has succeeded.
            }
        }
    });
});