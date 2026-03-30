<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products' => \App\Models\Product::count(),
            'messages' => \App\Models\Contact::count(),
            'subscribers' => \App\Models\Subscriber::count(),
        ];
        return view('admin.dashboard', compact('stats'));
    }
}
