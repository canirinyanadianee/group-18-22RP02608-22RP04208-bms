<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <a href="{{ url('/') }}" class="text-gray-500 hover:text-gray-700 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Patient Dashboard') }}
                </h2>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="flex items-center">
                @csrf
                <button type="submit" class="text-red-600 hover:text-red-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 mr-1">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    {{ __('Logout') }}
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Patient Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-red-100 p-4 rounded-lg">
                            <h3 class="font-bold text-lg mb-2">Blood Type</h3>
                            <p class="text-3xl text-red-600">{{ auth()->user()->blood_type }}</p>
                        </div>
                        <div class="bg-yellow-100 p-4 rounded-lg">
                            <h3 class="font-bold text-lg mb-2">Active Requests</h3>
                            <p class="text-3xl text-yellow-600">{{ $activeRequests ?? 0 }}</p>
                        </div>
                        <div class="bg-green-100 p-4 rounded-lg">
                            <h3 class="font-bold text-lg mb-2">Fulfilled Requests</h3>
                            <p class="text-3xl text-green-600">{{ $fulfilledRequests ?? 0 }}</p>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <a href="{{ route('blood-requests.create') }}" class="bg-red-600 text-white p-4 rounded-lg text-center hover:bg-red-700 transition">
                                New Blood Request
                            </a>
                            <a href="{{ route('blood-requests.index') }}" class="bg-gray-600 text-white p-4 rounded-lg text-center hover:bg-gray-700 transition">
                                View Request History
                            </a>
                        </div>
                    </div>

                    <!-- Current Blood Requests -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Current Blood Requests</h3>
                        @if(isset($bloodRequests) && count($bloodRequests) > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white">
                                    <thead>
                                        <tr>
                                            <th class="py-2 px-4 border-b">Request Date</th>
                                            <th class="py-2 px-4 border-b">Blood Type</th>
                                            <th class="py-2 px-4 border-b">Units</th>
                                            <th class="py-2 px-4 border-b">Status</th>
                                            <th class="py-2 px-4 border-b">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bloodRequests as $request)
                                            <tr>
                                                <td class="py-2 px-4 border-b">{{ $request->created_at->format('Y-m-d') }}</td>
                                                <td class="py-2 px-4 border-b">{{ $request->blood_type }}</td>
                                                <td class="py-2 px-4 border-b">{{ $request->units }}</td>
                                                <td class="py-2 px-4 border-b">{{ $request->status }}</td>
                                                <td class="py-2 px-4 border-b">
                                                    <a href="{{ route('blood-requests.show', $request) }}" class="text-blue-600 hover:text-blue-800">
                                                        View Details
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-500">No active blood requests</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
