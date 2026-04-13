<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\GalleryItem;
use App\Models\HeroSlide;
use App\Models\NewsPost;
use App\Models\Product;
use App\Models\Statistic;
use App\Models\Subscriber;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\VisitorLog;
use App\Models\WashingStation;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'slides' => HeroSlide::count(),
            'team_members' => TeamMember::count(),
            'testimonials' => Testimonial::count(),
            'products' => Product::count(),
            'messages' => Contact::count(),
            'subscribers' => Subscriber::count(),
            'users' => User::count(),
            'admins' => User::where('is_admin', true)->count(),
            'verified_users' => User::whereNotNull('email_verified_at')->count(),
            'news_posts' => NewsPost::count(),
            'gallery_items' => GalleryItem::count(),
            'stations' => WashingStation::count(),
            'statistics' => Statistic::count(),
        ];

        $quickLinks = [
            [
                'label' => 'Add Product',
                'description' => 'Create a new coffee listing for the shop.',
                'route' => route('admin.products.create'),
            ],
            [
                'label' => 'Manage Messages',
                'description' => 'Review incoming contact requests and leads.',
                'route' => route('admin.contacts.index'),
            ],
            [
                'label' => 'Update Hero Slides',
                'description' => 'Refresh homepage visuals and calls to action.',
                'route' => route('admin.hero-slides.index'),
            ],
            [
                'label' => 'Manage Users',
                'description' => 'Review admin access and create new accounts.',
                'route' => route('admin.users.index'),
            ],
            [
                'label' => 'Site Settings',
                'description' => 'Edit brand, contact, and footer information.',
                'route' => route('admin.settings.index'),
            ],
        ];

        $recentUsers = User::latest()
            ->take(6)
            ->get(['id', 'name', 'email', 'is_admin', 'email_verified_at', 'created_at']);

        $visitorStats = [
            'today_visits' => 0,
            'today_unique' => 0,
            'week_visits' => 0,
            'week_unique' => 0,
        ];

        $visitorTrend = collect();
        $topPages = collect();

        if (Schema::hasTable('visitor_logs')) {
            $today = now()->toDateString();
            $weekStart = now()->subDays(6)->startOfDay();

            $visitorStats = [
                'today_visits' => VisitorLog::whereDate('visited_at', $today)->count(),
                'today_unique' => VisitorLog::whereDate('visited_at', $today)->distinct('visitor_hash')->count('visitor_hash'),
                'week_visits' => VisitorLog::where('visited_at', '>=', $weekStart)->count(),
                'week_unique' => VisitorLog::where('visited_at', '>=', $weekStart)->distinct('visitor_hash')->count('visitor_hash'),
            ];

            $trendRows = VisitorLog::query()
                ->selectRaw('DATE(visited_at) as day, COUNT(*) as visits, COUNT(DISTINCT visitor_hash) as unique_visitors')
                ->where('visited_at', '>=', $weekStart)
                ->groupBy('day')
                ->orderBy('day')
                ->get()
                ->keyBy('day');

            $visitorTrend = collect(range(6, 0, -1))
                ->map(function (int $daysAgo) use ($trendRows) {
                    $day = now()->subDays($daysAgo)->toDateString();
                    $row = $trendRows->get($day);

                    return [
                        'label' => now()->subDays($daysAgo)->format('M d'),
                        'visits' => (int) ($row->visits ?? 0),
                        'unique_visitors' => (int) ($row->unique_visitors ?? 0),
                    ];
                })
                ->push([
                    'label' => now()->format('M d'),
                    'visits' => (int) ($trendRows->get($today)->visits ?? 0),
                    'unique_visitors' => (int) ($trendRows->get($today)->unique_visitors ?? 0),
                ]);

            $topPages = VisitorLog::query()
                ->selectRaw('path, COUNT(*) as visits, COUNT(DISTINCT visitor_hash) as unique_visitors')
                ->where('visited_at', '>=', $weekStart)
                ->groupBy('path')
                ->orderByDesc('visits')
                ->take(5)
                ->get();
        }

        return view('admin.dashboard', compact('stats', 'quickLinks', 'recentUsers', 'visitorStats', 'visitorTrend', 'topPages'));
    }
}
