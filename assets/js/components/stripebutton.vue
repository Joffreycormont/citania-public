<template>
  <div class="productContainer">

    <div class="product_card">
        <strong>25 diamants</strong>
        <img src="../../../public/assets/Images/25diams.png" alt="image diamant (25)">
        <button class="payementButton" @click="purchase"
            role="link"
            data-product="sku_GiAdKdOg1HAGsa"
            data-productlive="sku_GiOW4OcxkAxt1C"
            data-productnumber="25"
            >
            Acheter pour <span>2,99 €</span>
        </button>
    </div>

    <div class="product_card">
        <strong>50 diamants</strong>
        <img src="../../../public/assets/Images/50diams.png" alt="image diamant (50)">
        <button class="payementButton" @click="purchase"
            role="link"
            data-product="sku_GiQET7uad9CPTt"
            data-productlive="sku_GiOXSlLrGz3Tea"
            data-productnumber="50"
            >
            Acheter pour <span>4,99 €</span>
        </button>
    </div>

    <div class="product_card">
        <strong>100 diamants</strong>
        <img src="../../../public/assets/Images/100diams.png" alt="image diamant (100)">
        <button class="payementButton" @click="purchase"
            role="link"
            data-product="sku_GiQFSxaeasPndh"
            data-productlive="sku_GiOXSLg7b9ohVL"
            data-productnumber="100"
            >
            Acheter pour <span>9,99 €</span>
        </button>
    </div>

    <div class="product_card">
        <strong>150 diamants</strong>
        <img src="../../../public/assets/Images/150diams.png" alt="image diamant (150)">
        <button class="payementButton" @click="purchase"
            role="link"
            data-product="sku_GiQFm5rC031c6v"
            data-productlive="sku_GiOZAnK0AvtSgn"
            data-productnumber="150"
            >
            Acheter pour <span>15,99 €</span>
        </button>
    </div>

    <div class="product_card">
        <strong>180 diamants</strong>
        <img src="../../../public/assets/Images/180diams.png" alt="image diamant (180)">
        <button class="payementButton" @click="purchase"
            role="link"
            data-product="sku_GiQGZeuWIFYppf"
            data-productlive="sku_GiOaTeLwtk8Xa8"
            data-productnumber="180"
            >
            Acheter pour <span>19,99 €</span>
        </button>
    </div>

    <div class="product_card">
        <strong>260 diamants</strong>
        <img src="../../../public/assets/Images/260diams.png" alt="image diamant (260)">
        <button class="payementButton" @click="purchase"
            role="link"
            data-product="sku_GiQH3yPxtDtZ5e"
            data-productlive="sku_GiOaarE8P8Veb1"
            data-productnumber="260"
            >
            Acheter pour <span>29,99 €</span>
        </button>
    </div>

    <div class="product_card">
        <strong>520 diamants</strong>
        <img src="../../../public/assets/Images/520diams.png" alt="image diamant (520)">
        <button class="payementButton" @click="purchase"
            role="link"
            data-product="sku_GiQHGSpFvxNObD"
            data-productlive="sku_GiOaOnamWITeXr"
            data-productnumber="520"
            >
            Acheter pour <span>49,99 €</span>
        </button>
    </div>

    <div class="product_card">
        <strong>1500 diamants</strong>
        <img src="../../../public/assets/Images/1500diams.png" alt="image diamant (1500)">
        <button class="payementButton" @click="purchase"
            role="link"
            data-product="sku_GiQIg6lS4FVfOH"
            data-productlive="sku_GiObl4qaoYyDqg"
            data-productnumber="1500"
            >
            Acheter pour <span>99,99 €</span>
        </button>
    </div>


    <div id="error-message"></div>
  </div>
</template>

<script type="application/javascript">
export default {
    data () {
        return{
        }
    },
    methods: {
        purchase (evt){

            let sku = $(evt.currentTarget).data('productlive')
            // 
            var stripe = Stripe('STRIPE_KEY');
                // When the customer clicks on the button, redirect
                // them to Checkout.

            const productNumber = $(evt.currentTarget).data('productnumber');
            stripe.redirectToCheckout({
            items: [{sku: sku, quantity: 1}],

            // Do not rely on the redirect to the successUrl for fulfilling
            // purchases, customers may not always reach the success_url after
            // a successful payment.
            // Instead use one of the strategies described in
            // https://stripe.com/docs/payments/checkout/fulfillment
            successUrl: 'http://127.0.0.1:8000/jeu/premium/valid?product='+productNumber+'&session_id={CHECKOUT_SESSION_ID}',
            cancelUrl: 'http://127.0.0.1:8000/jeu/premium/cancel',
            })
            .then(function (result) {
            if (result.error) {
                // If `redirectToCheckout` fails due to a browser or network
                // error, display the localized error message to your customer.
                var displayError = document.getElementById('error-message');
                displayError.textContent = result.error.message;
            }
            });
        }        
    }
}
</script>