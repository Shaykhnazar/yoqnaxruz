<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Complaints Widget -->
    <div class="bg-white shadow rounded-lg p-4 flex items-center">
        <div class="p-3 bg-blue-500 text-white rounded-full mr-4">
            <i class="fas fa-exclamation-circle fa-2x"></i>
        </div>
        <div>
            <div class="text-lg font-semibold">{{ $complaintCount }}</div>
            <div class="text-sm text-gray-500">{{ __('dashboard.complaints_awaiting_review') }}</div>
            <a href="{{ route('filament.admin.resources.complaints.index') }}" class="text-blue-500 hover:underline">{{ __('dashboard.view_complaints') }}</a>
        </div>
    </div>

    <!-- Feedback Widget -->
    <div class="bg-white shadow rounded-lg p-4 flex items-center">
        <div class="p-3 bg-green-500 text-white rounded-full mr-4">
            <i class="fas fa-comments fa-2x"></i>
        </div>
        <div>
            <div class="text-lg font-semibold">{{ $feedbackCount }}</div>
            <div class="text-sm text-gray-500">{{ __('dashboard.feedback_received') }}</div>
            <a href="{{ route('filament.admin.resources.feedback.index') }}" class="text-blue-500 hover:underline">{{ __('dashboard.view_feedback') }}</a>
        </div>
    </div>

    <!-- Fuel Prices Widget -->
    <div class="bg-white shadow rounded-lg p-4 flex items-center">
        <div class="p-3 bg-yellow-500 text-white rounded-full mr-4">
            <i class="fas fa-dollar-sign fa-2x"></i>
        </div>
        <div>
            <div class="text-lg font-semibold">{{ $fuelPriceCount }}</div>
            <div class="text-sm text-gray-500">{{ __('dashboard.fuel_prices_awaiting_review') }}</div>
            <a href="{{ route('filament.admin.resources.prices.index') }}" class="text-blue-500 hover:underline">{{ __('dashboard.view_fuel_prices') }}</a>
        </div>
    </div>

    <!-- Stations Widget -->
    <div class="bg-white shadow rounded-lg p-4 flex items-center">
        <div class="p-3 bg-purple-500 text-white rounded-full mr-4">
            <i class="fas fa-map-marker-alt fa-2x"></i>
        </div>
        <div>
            <div class="text-lg font-semibold">{{ $stationCount }}</div>
            <div class="text-sm text-gray-500">{{ __('dashboard.stations_registered_awaiting_review') }}</div>
            <a href="{{ route('filament.admin.resources.stations.index') }}" class="text-blue-500 hover:underline">{{ __('dashboard.view_stations') }}</a>
        </div>
    </div>
</div>
