<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Order Items') }}
        </h2>
    </header>

    <div class="p-4 bg-white shadow sm:p-8 sm:rounded-lg">
        <div class="max-w-xl">
            <table class="w-full table-auto">
                <tr>
                    <th class="w-1/5">Item</th>
                    <th class="w-1/5">Price</th>
                    <th class="w-1/5">Quantity</th>
                    <th class="w-1/5">Total</th>
                </tr>
                @foreach ($order->orderItems as $item)
                    <tr>
                        <td class="w-1/5">{{ $item->menu->name }}</td>
                        <td class="w-1/5">{{ number_format($item->price, 2) }}</td>
                        <td class="w-1/5">{{ $item->quantity }}</td>
                        <td class="w-1/5">{{ number_format($item->total_price, 2) }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</section>
