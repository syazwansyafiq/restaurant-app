

<form class="mt-10" action="{{ route('payment.moby.hosted') }}" method="post" id="payment-form">
    @csrf
    <input type="hidden" name="order_id" value="{{ $order_id }}">
    <input type="hidden" name="amount" value="{{ $amount }}">
    <input type="hidden" name="description" value="{{ $description }}">
    <input type="hidden" name="reference" value="{{ $order_reference }}">
    <input type="hidden" name="payment_id" value="{{ $payment_id }}">
    <input type="hidden" name="user_id" value="{{ $user_id }}">
    <input type="hidden" name="restaurant_id" value="{{ $restaurant_id }}">
    <input type="hidden" name="currency" value="{{ $currency ?? 'MYR' }}">
    <input type="hidden" name="user_name" value="{{ $user_name }}">
    <input type="hidden" name="user_email" value="{{ $user_email }}">
    <input type="hidden" name="user_phone" value="{{ $user_phone }}">

    {{-- <div class="form-group col-md-6">
        <label for="user_name">
            Customer Name
        </label>
        <input type="text" class="form-control" id="user_name" name="user_name"
        required>
    </div>

    <div class="form-group col-md-6">
        <label for="user_email">
            Customer Email
        </label>
        <input type="email" class="form-control" id="user_email" name="user_email" required>
    </div>

    <div class="form-group col-md-6">
        <label for="user_phone">
            Customer Phone
        </label>
        <input type="text" class="form-control" id="user_phone" name="user_phone" required>
    </div> --}}

    <button type="submit" class="mt-10 btn btn-primary w-100">Pay {{ $currency }} {{ number_format($amount, 2) }}</button>
</form>
