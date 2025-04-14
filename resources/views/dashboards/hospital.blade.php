<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Hospital Dashboard
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('blood-donations.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Record Donation
                </a>
                <a href="{{ route('blood-requests.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    New Request
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Blood Inventory Overview -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Blood Stock Overview</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($inventory as $type => $quantity)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-lg font-semibold text-center mb-2">{{ $type }}</h4>
                            <p class="text-2xl text-center text-gray-700">{{ $quantity }} ml</p>
                            <p class="text-sm text-center text-gray-500 mt-1">
                                @if($quantity < 1000)
                                    <span class="text-red-600">Low Stock</span>
                                @elseif($quantity < 2000)
                                    <span class="text-yellow-600">Moderate</span>
                                @else
                                    <span class="text-green-600">Sufficient</span>
                                @endif
                            </p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Registered Donors -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Registered Donors</h3>
                            <a href="{{ route('donors.index') }}" class="text-blue-600 hover:text-blue-900">View All</a>
                        </div>
                        @if($donors->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Blood Type</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Last Donation</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($donors as $donor)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">{{ $donor->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $donor->email }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $donor->blood_type }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $donor->lastDonation ? $donor->lastDonation->created_at->diffForHumans() : 'Never' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $donor->is_eligible ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $donor->is_eligible ? 'Eligible' : 'Not Eligible' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-4">No registered donors found.</p>
                        @endif
                    </div>
                </div>

                <!-- Blood Requests -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Blood Requests</h3>
                            <a href="{{ route('blood-requests.index') }}" class="text-blue-600 hover:text-blue-900">View All</a>
                        </div>
                        @if($pendingRequests->count() > 0)
                            <div class="space-y-4">
                                @foreach($pendingRequests as $request)
                                    <div class="border-b pb-4">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="font-semibold">{{ $request->requester->name }}</p>
                                                <p class="text-sm text-gray-600">Blood Type: {{ $request->blood_type }}</p>
                                                <p class="text-sm text-gray-600">Quantity: {{ $request->quantity_ml }}ml</p>
                                                <p class="text-sm text-gray-500">{{ $request->created_at->diffForHumans() }}</p>
                                            </div>
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                {{ $request->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                                   ($request->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                   'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($request->status) }}
                                            </span>
                                        </div>
                                        @if($request->status === 'pending')
                                            <div class="mt-2 flex space-x-2">
                                                <form action="{{ route('blood-requests.approve', $request) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                                                        Approve
                                                    </button>
                                                </form>
                                                <form action="{{ route('blood-requests.reject', $request) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-semibold">
                                                        Reject
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-4">No pending blood requests.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Donation Drives -->
            @if($donationDrives->count() > 0)
                <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Upcoming Donation Drives</h3>
                            <a href="{{ route('donation-drives.create') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Schedule Drive
                            </a>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($donationDrives as $drive)
                                <div class="border rounded-lg p-4">
                                    <h4 class="font-semibold">{{ $drive->title }}</h4>
                                    <p class="text-sm text-gray-600">{{ $drive->location }}</p>
                                    <p class="text-sm text-gray-600">{{ $drive->date->format('M d, Y') }}</p>
                                    <p class="text-sm text-gray-600">{{ $drive->start_time }} - {{ $drive->end_time }}</p>
                                    <div class="mt-2">
                                        <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">
                                            {{ $drive->registrations_count }} Registered Donors
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
