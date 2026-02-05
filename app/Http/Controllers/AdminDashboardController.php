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
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
