<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>

        {{-- Manage restaurant --}}
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900">
                    Manage Restaurant
                </div>

                <div class="p-6 text-gray-900">
                    <table class="w-full table-auto">
                        <tr>
                            <th class="w-1/5">Name</th>
                            <th class="w-1/5">Email</th>
                            <th class="w-1/5">Phone</th>
                            <th class="w-1/5">Action</th>
                        </tr>
                        @foreach ($restaurants as $restaurant)
                            <tr>
                                <td class="w-1/5">{{ $restaurant->name }}</td>
                                <td class="w-1/5">{{ $restaurant->email }}</td>
                                <td class="w-1/5">{{ $restaurant->phone }}</td>
                                <td class="w-1/5">
                                    @if($restaurant->status !== 'active')
                                    <a href="{{ route('admin.restaurants.approve', ['restaurant' => $restaurant->id]) }}">Approve</a>
                                    @endif

                                    @if($restaurant->status !== 'banned' && $restaurant->status !== 'inactive')
                                    <a href="{{ route('admin.restaurants.ban', ['restaurant' => $restaurant->id]) }}">Ban</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
