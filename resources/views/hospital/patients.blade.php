<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Patients List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-3 px-4 text-left">Name</th>
                                    <th class="py-3 px-4 text-left">Blood Type</th>
                                    <th class="py-3 px-4 text-left">Location</th>
                                    <th class="py-3 px-4 text-left">Total Requests</th>
                                    <th class="py-3 px-4 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($patients as $patient)
                                    <tr>
                                        <td class="py-3 px-4">{{ $patient->name }}</td>
                                        <td class="py-3 px-4">{{ $patient->blood_type }}</td>
                                        <td class="py-3 px-4">{{ $patient->city }}, {{ $patient->state }}</td>
                                        <td class="py-3 px-4">{{ $patient->blood_requests_count }}</td>
                                        <td class="py-3 px-4">
                                            <a href="{{ route('hospital.patient-details', $patient) }}" 
                                               class="text-blue-600 hover:text-blue-900">View Details</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $patients->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 