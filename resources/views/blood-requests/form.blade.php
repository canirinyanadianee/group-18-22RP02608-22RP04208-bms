@props(['bloodRequest' => null])

<form method="POST" action="{{ $bloodRequest ? route('blood-requests.update', $bloodRequest) : route('blood-requests.store') }}" class="space-y-6">
    @csrf
    @if($bloodRequest)
        @method('PUT')
    @endif

    <div>
        <label for="blood_type" class="block text-sm font-medium text-gray-700">Blood Type</label>
        <select id="blood_type" name="blood_type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
            @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $type)
                <option value="{{ $type }}" {{ old('blood_type', $bloodRequest?->blood_type) === $type ? 'selected' : '' }}>
                    {{ $type }}
                </option>
            @endforeach
        </select>
        @error('blood_type')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="quantity_ml" class="block text-sm font-medium text-gray-700">Quantity (ml)</label>
        <input type="number" name="quantity_ml" id="quantity_ml" min="1" step="1" required
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500"
            value="{{ old('quantity_ml', $bloodRequest?->quantity_ml) }}">
        @error('quantity_ml')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="urgency" class="block text-sm font-medium text-gray-700">Urgency Level</label>
        <select id="urgency" name="urgency" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
            @foreach(['normal', 'urgent', 'emergency'] as $urgency)
                <option value="{{ $urgency }}" {{ old('urgency', $bloodRequest?->urgency) === $urgency ? 'selected' : '' }}>
                    {{ ucfirst($urgency) }}
                </option>
            @endforeach
        </select>
        @error('urgency')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="required_date" class="block text-sm font-medium text-gray-700">Required Date</label>
        <input type="date" name="required_date" id="required_date" required
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500"
            value="{{ old('required_date', $bloodRequest?->required_date?->format('Y-m-d')) }}"
            min="{{ date('Y-m-d') }}">
        @error('required_date')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="blood_bank_id" class="block text-sm font-medium text-gray-700">Blood Bank</label>
        <select id="blood_bank_id" name="blood_bank_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
            <option value="">Select a Blood Bank</option>
            @foreach(\App\Models\BloodBank::where('is_active', true)->orderBy('name')->get() as $bloodBank)
                <option value="{{ $bloodBank->id }}" {{ old('blood_bank_id', $bloodRequest?->blood_bank_id) == $bloodBank->id ? 'selected' : '' }}>
                    {{ $bloodBank->name }} ({{ $bloodBank->city }})
                </option>
            @endforeach
        </select>
        @error('blood_bank_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="notes" class="block text-sm font-medium text-gray-700">Additional Notes</label>
        <textarea id="notes" name="notes" rows="3"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">{{ old('notes', $bloodRequest?->notes) }}</textarea>
        @error('notes')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex justify-end space-x-4">
        <a href="{{ route('blood-requests.index') }}" class="inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
            Cancel
        </a>
        <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-red-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
            {{ $bloodRequest ? 'Update Request' : 'Submit Request' }}
        </button>
    </div>
</form> 