<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Donor Details') }}
            </h2>
            <a href="{{ route('hospital.donors') }}" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                Back to Donors List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Donor Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Personal Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Name</p>
                            <p class="font-medium">{{ $donor->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Blood Type</p>
                            <p class="font-medium">{{ $donor->blood_type }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Contact</p>
                            <p class="font-medium">{{ $donor->phone }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Location</p>
                            <p class="font-medium">{{ $donor->city }}, {{ $donor->state }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Last Donation Date</p>
                            <p class="font-medium">
                                {{ $donor->last_donation_date ? $donor->last_donation_date->format('M d, Y') : 'Never donated' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Donations</p>
                            <p class="font-medium">{{ $donations->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Donation History -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Donation History</h3>
                    @if($donations->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="py-3 px-4 text-left">Date</th>
                                        <th class="py-3 px-4 text-left">Blood Bank</th>
                                        <th class="py-3 px-4 text-left">Quantity</th>
                                        <th class="py-3 px-4 text-left">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($donations as $donation)
                                        <tr>
                                            <td class="py-3 px-4">{{ $donation->donation_date->format('M d, Y') }}</td>
                                            <td class="py-3 px-4">{{ $donation->bloodBank->name }}</td>
                                            <td class="py-3 px-4">{{ $donation->quantity_ml }}ml</td>
                                            <td class="py-3 px-4">
                                                <span class="px-2 py-1 text-sm rounded-full 
                                                    {{ $donation->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                                       ($donation->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                       'bg-red-100 text-red-800') }}">
                                                    {{ ucfirst($donation->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500">No donation history available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 