<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-500">Welcome, {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        {{ __('Logout') }}
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-semibold mb-6">Dashboard</h2>

                    <!-- Statistics Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="bg-blue-100 p-6 rounded-lg shadow">
                            <h3 class="text-lg font-semibold text-blue-800">Blood Banks</h3>
                            <p class="text-3xl font-bold text-blue-600">{{ $data['totalBloodBanks'] ?? 0 }}</p>
                        </div>
                        <div class="bg-green-100 p-6 rounded-lg shadow">
                            <h3 class="text-lg font-semibold text-green-800">Blood Donations</h3>
                            <p class="text-3xl font-bold text-green-600">{{ $data['totalDonations'] ?? 0 }}</p>
                        </div>
                        <div class="bg-red-100 p-6 rounded-lg shadow">
                            <h3 class="text-lg font-semibold text-red-800">Blood Requests</h3>
                            <p class="text-3xl font-bold text-red-600">{{ $data['totalRequests'] ?? 0 }}</p>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Recent Donations -->
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h3 class="text-xl font-semibold mb-4">Recent Donations</h3>
                            @if(count($data['recentDonations']) > 0)
                                <div class="space-y-4">
                                    @foreach($data['recentDonations'] as $donation)
                                        <div class="border-b pb-4">
                                            <p class="font-semibold">{{ $donation->donor->name }}</p>
                                            <p class="text-sm text-gray-600">Blood Type: {{ $donation->blood_type }}</p>
                                            <p class="text-sm text-gray-600">{{ $donation->created_at->diffForHumans() }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">No recent donations</p>
                            @endif
                        </div>

                        <!-- Recent Requests -->
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h3 class="text-xl font-semibold mb-4">Recent Requests</h3>
                            @if(count($data['recentRequests']) > 0)
                                <div class="space-y-4">
                                    @foreach($data['recentRequests'] as $request)
                                        <div class="border-b pb-4">
                                            <p class="font-semibold">{{ $request->patient_name }}</p>
                                            <p class="text-sm text-gray-600">Blood Type: {{ $request->blood_type }}</p>
                                            <p class="text-sm text-gray-600">Status: 
                                                <span class="@if($request->status === 'pending') text-yellow-600 
                                                           @elseif($request->status === 'approved') text-green-600 
                                                           @else text-red-600 @endif">
                                                    {{ ucfirst($request->status) }}
                                                </span>
                                            </p>
                                            <p class="text-sm text-gray-600">{{ $request->created_at->diffForHumans() }}</p>
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
    </div>
</x-app-layout> 
