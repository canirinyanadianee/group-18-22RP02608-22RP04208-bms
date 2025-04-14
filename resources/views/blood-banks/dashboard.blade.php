<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $bloodBank->name }} Dashboard
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
            <!-- Blood Inventory -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Current Blood Inventory</h3>
                        <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Update Inventory
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($inventory as $type => $quantity)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-lg font-semibold text-center mb-2">{{ $type }}</h4>
                            <p class="text-2xl text-center text-gray-700">{{ $quantity }} ml</p>
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
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Recent Donations</h3>
                            <a href="{{ route('blood-donations.index') }}" class="text-blue-600 hover:text-blue-900">View All</a>
                        </div>
                        @if($recentDonations->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentDonations as $donation)
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
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Recent Requests</h3>
                            <a href="{{ route('blood-requests.index') }}" class="text-blue-600 hover:text-blue-900">View All</a>
                        </div>
                        @if($recentRequests->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentRequests as $request)
                                    <div class="border-b pb-4">
                                        <p class="font-semibold">{{ $request->requester->name }}</p>
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

    <!-- Update Inventory Modal -->
    <div id="updateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Update Blood Inventory</h3>
                <form action="{{ route('blood-banks.update-inventory', $bloodBank) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="blood_type" id="modalBloodType">
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="quantity">
                            Quantity (ml)
                        </label>
                        <input type="number" name="quantity_ml" id="quantity" min="0" required
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="expiry_date">
                            Expiry Date
                        </label>
                        <input type="date" name="expiry_date" id="expiry_date" required
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeUpdateModal()"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function openUpdateModal(bloodType) {
            document.getElementById('modalBloodType').value = bloodType;
            document.getElementById('updateModal').classList.remove('hidden');
        }

        function closeUpdateModal() {
            document.getElementById('updateModal').classList.add('hidden');
        }

        // Set minimum date for expiry date input to tomorrow
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        document.getElementById('expiry_date').min = tomorrow.toISOString().split('T')[0];
    </script>
    @endpush
</x-app-layout> 