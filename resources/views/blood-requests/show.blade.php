@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="md:flex md:items-center md:justify-between mb-6">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Blood Request Details
                </h2>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4">
                <a href="{{ route('blood-requests.edit', $bloodRequest) }}" 
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Edit Request
                </a>
                <form action="{{ route('blood-requests.destroy', $bloodRequest) }}" method="POST" class="ml-3">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                        onclick="return confirm('Are you sure you want to delete this blood request?')">
                        Delete Request
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Patient Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900">Patient Information</h3>
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Patient Name</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $bloodRequest->patient_name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Blood Type</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $bloodRequest->blood_type }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Quantity Required</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $bloodRequest->quantity }} units</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Request Details -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900">Request Details</h3>
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Blood Bank</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $bloodRequest->bloodBank->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Urgency Level</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($bloodRequest->urgency_level === 'Critical') bg-red-100 text-red-800
                                        @elseif($bloodRequest->urgency_level === 'High') bg-orange-100 text-orange-800
                                        @elseif($bloodRequest->urgency_level === 'Medium') bg-yellow-100 text-yellow-800
                                        @else bg-green-100 text-green-800
                                        @endif">
                                        {{ $bloodRequest->urgency_level }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Required Date</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $bloodRequest->required_date->format('M d, Y') }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Hospital Information -->
                    <div class="space-y-4 md:col-span-2">
                        <h3 class="text-lg font-medium text-gray-900">Hospital Information</h3>
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Hospital Name</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $bloodRequest->hospital_name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Hospital Address</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $bloodRequest->hospital_address }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Additional Information -->
                    <div class="space-y-4 md:col-span-2">
                        <h3 class="text-lg font-medium text-gray-900">Additional Information</h3>
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Reason for Request</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $bloodRequest->reason }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($bloodRequest->status === 'Pending') bg-yellow-100 text-yellow-800
                                        @elseif($bloodRequest->status === 'Approved') bg-green-100 text-green-800
                                        @elseif($bloodRequest->status === 'Rejected') bg-red-100 text-red-800
                                        @elseif($bloodRequest->status === 'Completed') bg-blue-100 text-blue-800
                                        @endif">
                                        {{ $bloodRequest->status }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Created At</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $bloodRequest->created_at->format('M d, Y H:i') }}</dd>
                            </div>
                            @if($bloodRequest->updated_at != $bloodRequest->created_at)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $bloodRequest->updated_at->format('M d, Y H:i') }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 