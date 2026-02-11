<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_cars' => \App\Models\Car::count(),
            'total_users' => \App\Models\User::count(),
            'total_orders' => \App\Models\Order::count(),
            'total_reviews' => \App\Models\Review::count(),
            'total_revenue' => \App\Models\Order::sum('total'),
            'pending_reviews' => \App\Models\Review::whereDate('created_at', '>=', now()->subDays(7))->count(),
            'new_users_week' => \App\Models\User::whereDate('created_at', '>=', now()->subDays(7))->count(),
        ];

        $recentReviews = \App\Models\Review::with(['user', 'car'])->latest()->take(5)->get();
        $recentOrders = \App\Models\Order::with('user')->latest()->take(5)->get();
        $recentCars = \App\Models\Car::with(['brand', 'team'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentReviews', 'recentOrders', 'recentCars'));
    }
}
