@props(['bloodRequest' => null, 'bloodBanks'])

<div {{ $attributes->merge(['class' => 'space-y-6']) }}>
    <form method="POST" action="{{ $bloodRequest ? route('blood-requests.update', $bloodRequest) : route('blood-requests.store') }}" class="space-y-6">
        @csrf
        @if($bloodRequest)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Patient Name -->
            <div>
                <label for="patient_name" class="block text-sm font-medium text-gray-700">Patient Name</label>
                <input type="text" name="patient_name" id="patient_name" value="{{ old('patient_name', $bloodRequest?->patient_name) }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                @error('patient_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Blood Type -->
            <div>
                <label for="blood_type" class="block text-sm font-medium text-gray-700">Blood Type</label>
                <select name="blood_type" id="blood_type" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    <option value="">Select Blood Type</option>
                    @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $type)
                        <option value="{{ $type }}" {{ old('blood_type', $bloodRequest?->blood_type) == $type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                    @endforeach
                </select>
                @error('blood_type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Quantity (Units) -->
            <div>
                <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity (Units)</label>
                <input type="number" name="quantity" id="quantity" min="1" value="{{ old('quantity', $bloodRequest?->quantity) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                @error('quantity')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Blood Bank -->
            <div>
                <label for="blood_bank_id" class="block text-sm font-medium text-gray-700">Blood Bank</label>
                <select name="blood_bank_id" id="blood_bank_id" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    <option value="">Select Blood Bank</option>
                    @foreach($bloodBanks as $bloodBank)
                        @php
                            $availableQuantity = $bloodBank->bloodInventory()
                                ->where('blood_type', old('blood_type', $bloodRequest?->blood_type))
                                ->sum('quantity');
                        @endphp
                        <option value="{{ $bloodBank->id }}" 
                            {{ old('blood_bank_id', $bloodRequest?->blood_bank_id) == $bloodBank->id ? 'selected' : '' }}
                            {{ $availableQuantity > 0 ? '' : 'disabled' }}>
                            {{ $bloodBank->name }} ({{ $availableQuantity }} units available)
                        </option>
                    @endforeach
                </select>
                @error('blood_bank_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Urgency Level -->
            <div>
                <label for="urgency_level" class="block text-sm font-medium text-gray-700">Urgency Level</label>
                <select name="urgency_level" id="urgency_level" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    <option value="">Select Urgency Level</option>
                    @foreach(['Low', 'Medium', 'High', 'Critical'] as $level)
                        <option value="{{ $level }}" {{ old('urgency_level', $bloodRequest?->urgency_level) == $level ? 'selected' : '' }}>
                            {{ $level }}
                        </option>
                    @endforeach
                </select>
                @error('urgency_level')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Required Date -->
            <div>
                <label for="required_date" class="block text-sm font-medium text-gray-700">Required Date</label>
                <input type="date" name="required_date" id="required_date" value="{{ old('required_date', $bloodRequest?->required_date?->format('Y-m-d')) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                @error('required_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Hospital Name -->
            <div>
                <label for="hospital_name" class="block text-sm font-medium text-gray-700">Hospital Name</label>
                <input type="text" name="hospital_name" id="hospital_name" value="{{ old('hospital_name', $bloodRequest?->hospital_name) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                @error('hospital_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Hospital Address -->
            <div class="md:col-span-2">
                <label for="hospital_address" class="block text-sm font-medium text-gray-700">Hospital Address</label>
                <textarea name="hospital_address" id="hospital_address" rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>{{ old('hospital_address', $bloodRequest?->hospital_address) }}</textarea>
                @error('hospital_address')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Reason for Request -->
            <div class="md:col-span-2">
                <label for="reason" class="block text-sm font-medium text-gray-700">Reason for Request</label>
                <textarea name="reason" id="reason" rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>{{ old('reason', $bloodRequest?->reason) }}</textarea>
                @error('reason')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('blood-requests.index') }}" 
                class="inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Cancel
            </a>
            <button type="submit" 
                class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                {{ $bloodRequest ? 'Update' : 'Create' }} Blood Request
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('blood_type').addEventListener('change', function() {
        const bloodType = this.value;
        const bloodBankSelect = document.getElementById('blood_bank_id');
        
        // Clear current selection
        bloodBankSelect.value = '';
        
        // Fetch available blood banks for the selected blood type
        fetch(`/api/blood-banks/available/${bloodType}`)
            .then(response => response.json())
            .then(data => {
                // Update blood bank options
                const options = data.map(bank => {
                    const disabled = bank.available_quantity <= 0;
                    return `<option value="${bank.id}" ${disabled ? 'disabled' : ''}>
                        ${bank.name} (${bank.available_quantity} units available)
                    </option>`;
                });
                
                bloodBankSelect.innerHTML = '<option value="">Select Blood Bank</option>' + options.join('');
            })
            .catch(error => console.error('Error:', error));
    });
</script> 