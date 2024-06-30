<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Restaurant Dashboard') }} : {{ $restaurant->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <h1 class="p-6 text-gray-900">
                    {{ __('Hello, '. Auth::user()->name) }}
                </h1>

                @if(!empty($sale))
                <div class="p-6 text-gray-900">
                    Sale Today : {{ number_format($sale->today_amount, 2) }}
                </div>

                @else
                <div class="p-6 text-gray-900">
                    Sale Today : 0
                </div>
                @endif

                @if(!empty($sale))
                <div class="p-6 text-gray-900">
                    Sale This Week : {{ number_format($sale->week_amount, 2) }}
                </div>
                @else
                <div class="p-6 text-gray-900">
                    Sale This Week : 0
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- sales metrics --}}
    <div class="my-1">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">

                {{-- orders table --}}
                <table class="w-full table-auto">
                    <tr>
                        <th class="w-1/5">Order ID</th>
                        <th class="w-1/5">Customer</th>
                        <th class="w-1/5">Total</th>
                        <th class="w-1/5">Status</th>
                        <th class="w-1/5">Action</th>
                    </tr>
                    @foreach ($orders as $order)
                        <tr>
                            <td class="w-1/5">{{ $order->id }}</td>
                            <td class="w-1/5">{{ $order->customer->name }}</td>
                        <td class="w-1/5">{{ number_format($order->total_amount, 2) }}</td>
                            <td class="w-1/5">{{ $order->status }}</td>
                            <td class="w-1/5">
                                <a href="{{ route('restaurant.order.show', ['id' => $order->id]) }}">View</a>
                                @if($order->status !== 'rejected')
                                <a href="{{ route('restaurant.order.reject', ['id' => $order->id]) }}">Reject</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>


            </div>
        </div>
    </div>

    {{-- manage menu --}}


    {{-- manage order --}}



</x-app-layout>
