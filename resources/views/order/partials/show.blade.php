<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Order Details') }}
        </h2>

        <button class="text-sm text-gray-600 underline">
            <a href="{{ route('manager.dashboard') }}">Back</a>
        </button>
    </header>

    <div class="p-4 bg-white shadow sm:p-8 sm:rounded-lg">
        <div class="max-w-xl">
            <table class="w-full table-auto">
                <tr>
                    <th class="w-1/5">Order ID</th>
                    <td class="w-4/5">{{ $order->id }}</td>
                </tr>
                <tr>
                    <th class="w-1/5">Customer</th>
                    <td class="w-4/5">{{ $order->customer->name }}</td>
                </tr>
                <tr>
                    <th class="w-1/5">Total Amount</th>
                    <td class="w-4/5">{{ number_format($order->total_amount, 2) }}</td>
                </tr>
                <tr>
                    <th class="w-1/5">Status</th>
                    <td class="w-4/5">{{ $order->status }}</td>
                </tr>
                <tr>
                    <th class="w-1/5">Created At</th>
                    <td class="w-4/5">{{ $order->created_at }}</td>
                </tr>
            </table>
        </div>
    </div>
</section>



