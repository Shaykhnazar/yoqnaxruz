<?php

namespace App\Filament\Widgets;

use App\Models\Complaint;
use App\Models\Feedback;
use App\Models\Price;
use App\Models\Station;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class DashboardStats extends Widget
{
    protected static string $view = 'filament.widgets.dashboard-stats';

    public int $complaintCount = 0;
    public int $feedbackCount = 0;
    public int $fuelPriceCount = 0;
    public int $stationCount = 0;

    public function mount(): void
    {
        // Fetch counts based on your application's logic
        // Adjust the queries as per your models and relationships

        $this->complaintCount = Complaint::where('status', 'pending')->count();
        $this->feedbackCount = Feedback::count();
        $this->fuelPriceCount = Price::where(['verified_by' => 'Pending', 'approved_by' => 'Pending'])->count();
        $this->stationCount = Station::count();
    }
}
