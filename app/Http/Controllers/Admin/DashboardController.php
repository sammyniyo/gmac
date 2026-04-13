<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Feedback;
use App\Models\GalleryItem;
use App\Models\HeroSlide;
use App\Models\NewsPost;
use App\Models\Order;
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
            'orders_pending' => 0,
            'orders_open' => 0,
        ];

        if (Schema::hasTable('orders')) {
            $stats['orders_pending'] = Order::where('status', Order::STATUS_PENDING)->count();
            $stats['orders_open'] = Order::whereIn('status', [Order::STATUS_PENDING, Order::STATUS_PROCESSING])->count();
        }

        if (Schema::hasTable('feedbacks')) {
            $stats['feedbacks_pending'] = Feedback::where('is_approved', false)->count();
        } else {
            $stats['feedbacks_pending'] = 0;
        }

        $quickLinks = [
            [
                'label' => 'Products',
                'description' => 'Shop catalog and pricing',
                'route' => route('admin.products.index'),
            ],
            [
                'label' => 'Orders',
                'description' => 'Customer order requests',
                'route' => route('admin.orders.index'),
            ],
            [
                'label' => 'Messages',
                'description' => 'Contact form inbox',
                'route' => route('admin.contacts.index'),
            ],
            [
                'label' => 'Ratings & feedback',
                'description' => 'Public reviews (moderate)',
                'route' => route('admin.feedbacks.index'),
            ],
            [
                'label' => 'Hero slides',
                'description' => 'Homepage carousel',
                'route' => route('admin.hero-slides.index'),
            ],
            [
                'label' => 'News',
                'description' => 'Stories and updates',
                'route' => route('admin.news.index'),
            ],
            [
                'label' => 'Settings',
                'description' => 'Brand, contact, social',
                'route' => route('admin.settings.index'),
            ],
        ];

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

        return view('admin.dashboard', compact('stats', 'quickLinks', 'visitorStats', 'visitorTrend', 'topPages'));
    }
}
