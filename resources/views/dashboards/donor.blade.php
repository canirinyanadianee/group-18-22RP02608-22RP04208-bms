<x-app-layout>
    <!-- Navigation Bar -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                </div>
                <div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </div>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Donor Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Donor Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-red-100 p-4 rounded-lg">
                            <h3 class="font-bold text-lg mb-2">Total Donations</h3>
                            <p class="text-3xl text-red-600">{{ $totalDonations ?? 0 }}</p>
                        </div>
                        <div class="bg-green-100 p-4 rounded-lg">
                            <h3 class="font-bold text-lg mb-2">Last Donation</h3>
                            <p class="text-md">{{ $lastDonation ?? 'No donations yet' }}</p>
                        </div>
                        <div class="bg-blue-100 p-4 rounded-lg">
                            <h3 class="font-bold text-lg mb-2">Next Eligible Date</h3>
                            <p class="text-md">{{ $nextEligibleDate ?? 'Ready to donate' }}</p>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <a href="{{ route('blood-donations.create') }}" class="bg-red-600 text-white p-4 rounded-lg text-center hover:bg-red-700 transition">
                                Schedule New Donation
                            </a>
                            <a href="{{ route('blood-donations.index') }}" class="bg-gray-600 text-white p-4 rounded-lg text-center hover:bg-gray-700 transition">
                                View Donation History
                            </a>
                        </div>
                    </div>

                    <!-- Upcoming Appointments -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Upcoming Appointments</h3>
                        @if(isset($appointments) && count($appointments) > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white">
                                    <thead>
                                        <tr>
                                            <th class="py-2 px-4 border-b">Date</th>
                                            <th class="py-2 px-4 border-b">Time</th>
                                            <th class="py-2 px-4 border-b">Location</th>
                                            <th class="py-2 px-4 border-b">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($appointments as $appointment)
                                            <tr>
                                                <td class="py-2 px-4 border-b">{{ $appointment->date }}</td>
                                                <td class="py-2 px-4 border-b">{{ $appointment->time }}</td>
                                                <td class="py-2 px-4 border-b">{{ $appointment->location }}</td>
                                                <td class="py-2 px-4 border-b">{{ $appointment->status }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-500">No upcoming appointments</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
