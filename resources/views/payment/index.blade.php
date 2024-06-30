@extends('payment.layout')


@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="text-white card-header bg-primary">
                <h4 class="mb-0">Payment Information</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="order-information">
                            <h2>Order Information</h2>
                            <ul>
                              <li><strong>ID:</strong> {{ $order_id }}</li>
                              <li><strong>Date:</strong> {{ $order_date }}</li>
                              <li><strong>Time:</strong> {{ $order_time }}</li>
                              <li><strong>Restaurant:</strong> {{ $restaurant_name }}</li>
                            </ul>
                            <div class="cart-items">
                                <h2>Order Items</h2>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cart_items as $item)
                                            <tr>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ $currency }} {{ number_format($item->price, 2) }}</td>
                                                <td>{{ $currency }} {{ number_format($item->total, 2) }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="3">Total</td>
                                            <td>{{ $currency }} {{ number_format($amount, 2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                          </div>
                    </div>
                    <div class="mt-10 col-md-12">
                        <h2>Stripe Payment</h2>
                        @include('payment.stripe')
                    </div>

                    <div class="mt-10 col-md-12">
                        <h2>MobyPay</h2>
                        @include('payment.moby')
                    </div>


            </div>
        </div>
    </div>
</div>



@endsection
