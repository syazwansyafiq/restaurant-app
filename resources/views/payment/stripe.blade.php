

<form class="mt-10" action="{{ route('payment.stripe.charge') }}" method="post" id="payment-form">
    @csrf
    <input type="hidden" name="order_id" value="{{ $order_id }}">
    <input type="hidden" name="amount" value="{{ $amount }}">
    <input type="hidden" name="description" value="{{ $description }}">
    <input type="hidden" name="payment_id" value="{{ $payment_id }}">
    <input type="hidden" name="user_id" value="{{ $user_id }}">
    <input type="hidden" name="restaurant_id" value="{{ $restaurant_id }}">

    <div class="mt-10 form-row">
        <label for="card-element">
            Credit or debit card
        </label>
        <div id="card-element" class="form-control">
            <!-- A Stripe Element will be inserted here. -->
        </div>

        <!-- Used to display form errors. -->
        <div id="card-errors" role="alert"></div>
    </div>
    <button type="submit" class="mt-10 btn btn-primary w-100">Submit Payment</button>
</form>

@section('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
      var stripe = Stripe('{{ config('services.stripe.key') }}');
        var elements = stripe.elements();

        var style = {
            base: {
                color: '#32325d',
                lineHeight: '18px',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        var card = elements.create('card', {style: style});
        card.mount('#card-element');

        card.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            form.submit();
        }
    </script>
@endsection
