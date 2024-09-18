<?php

namespace App\Providers;

use App\Models\Complaint;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\HelpDeskReply;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('partials.usernav', function ($view) {
            $user = Auth::user();
            $totalNotifications = 0;

            if ($user && $user->hasRole('User')) {
                // Fetch help desk tickets for the user
                $helpDeskTickets = Complaint::where('user_id', $user->user_id)->get();

                // Calculate total notifications
                $total = 0;
                foreach ($helpDeskTickets as $ticket) {
                    $repliesCount = Complaint::where('complaint_id', $ticket->complaint_id)
                        ->where('reply_by', 'Admin')
                        ->count();
                    $total += $repliesCount;
                }
                $totalNotifications = $total;
            }

            $view->with('totalNotifications', $totalNotifications);
        });
    }
}
