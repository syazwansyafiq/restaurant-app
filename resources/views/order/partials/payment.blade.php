
<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Payment Details') }}
        </h2>
    </header>

    @foreach ($order->payments as $payment)
    <div class="p-4 bg-white shadow sm:p-8 sm:rounded-lg">
        <div class="max-w-xl">
            <table class="w-full table-auto">
                <tr>
                    <th class="w-1/5">Payment ID</th>
                    <td class="w-4/5">{{ $order->payment->id }}</td>
                </tr>
                <tr>
                    <th class="w-1/5">Payment Amount</th>
                    <td class="w-4/5">{{ number_format($order->payment->amount, 2) }}</td>
                </tr>
                <tr>
                    <th class="w-1/5">Payment Status</th>
                    <td class="w-4/5">{{ $order->payment->status }}</td>
                </tr>
                <tr>
                    <th class="w-1/5">Payment Method</th>
                    <td class="w-4/5">{{ $order->payment->payment_method }}</td>
                </tr>
                <tr>
                    <th class="w-1/5">Payment Date</th>
                    <td class="w-4/5">{{ $order->payment->created_at }}</td>
                </tr>
                <tr>
                    <th class="w-1/5">Payment Status</th>
                    <td class="w-4/5">{{ $order->payment->status }}</td>
                </tr>
            </table>
        </div>
    </div>
    @endforeach
</section>
