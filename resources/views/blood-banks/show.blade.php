<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $bloodBank->name }}
            </h2>
            <a href="{{ route('blood-banks.index') }}" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Blood Bank Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Blood Bank Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Name</p>
                            <p class="font-medium">{{ $bloodBank->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">License Number</p>
                            <p class="font-medium">{{ $bloodBank->license_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Contact</p>
                            <p class="font-medium">{{ $bloodBank->phone }}</p>
                            <p class="text-sm text-gray-500">{{ $bloodBank->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Location</p>
                            <p class="font-medium">{{ $bloodBank->address }}</p>
                            <p class="text-sm text-gray-500">{{ $bloodBank->city }}, {{ $bloodBank->state }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status</p>
                            <p class="inline-flex px-2 py-1 text-sm font-semibold rounded-full 
                                {{ $bloodBank->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $bloodBank->is_active ? 'Active' : 'Inactive' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Blood Inventory -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Blood Inventory</h3>
                        @if(auth()->user()->role === 'admin')
                        <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Update Inventory
                        </button>
                        @endif
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bloodType)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-lg font-semibold text-center mb-2">{{ $bloodType }}</h4>
                            <p class="text-2xl text-center text-gray-700">
                                {{ $bloodBank->inventory->where('blood_type', $bloodType)->first()->quantity_ml ?? 0 }} ml
                            </p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Recent Donations -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Recent Donations</h3>
                        @if($bloodBank->bloodDonations->count() > 0)
                            <div class="space-y-4">
                                @foreach($bloodBank->bloodDonations->take(5) as $donation)
                                    <div class="border-b pb-4">
                                        <p class="font-semibold">{{ $donation->donor->name }}</p>
                                        <p class="text-sm text-gray-600">Blood Type: {{ $donation->blood_type }}</p>
                                        <p class="text-sm text-gray-600">Quantity: {{ $donation->quantity_ml }}ml</p>
                                        <p class="text-sm text-gray-500">{{ $donation->created_at->diffForHumans() }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">No recent donations</p>
                        @endif
                    </div>
                </div>

                <!-- Recent Requests -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Recent Requests</h3>
                        @if($bloodBank->bloodRequests->count() > 0)
                            <div class="space-y-4">
                                @foreach($bloodBank->bloodRequests->take(5) as $request)
                                    <div class="border-b pb-4">
                                        <p class="font-semibold">{{ $request->patient->name }}</p>
                                        <p class="text-sm text-gray-600">Blood Type: {{ $request->blood_type }}</p>
                                        <p class="text-sm text-gray-600">Quantity: {{ $request->quantity_ml }}ml</p>
                                        <p class="text-sm text-gray-600">Status: 
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                {{ $request->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                                   ($request->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                   'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($request->status) }}
                                            </span>
                                        </p>
                                        <p class="text-sm text-gray-500">{{ $request->created_at->diffForHumans() }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">No recent requests</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 
