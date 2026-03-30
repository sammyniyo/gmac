<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\NewsPost;
use App\Models\GalleryItem;
use App\Models\WashingStation;
use App\Models\HeroSlide;
use App\Models\Statistic;
use App\Models\Contact;
use App\Models\Subscriber;

class FrontendController extends Controller
{
    public function home()
    {
        $slides = HeroSlide::where('is_active', true)->orderBy('order')->get();
        // Fallback dummy slide if db empty for preview
        if ($slides->isEmpty()) {
            $slides = collect([(object)['title' => 'Premium Rwandan Coffee', 'subtitle' => 'From our hills to your cup', 'image_url' => 'https://images.unsplash.com/photo-1497935586351-b67a49e012bf?q=80&w=2000&auto=format&fit=crop']]);
        }
        
        $featuredProducts = Product::where('is_active', true)->latest()->take(3)->get();
        $stats = Statistic::orderBy('order')->get();
        
        return view('frontend.home', compact('slides', 'featuredProducts', 'stats'));
    }

    public function history()
    {
        return view('frontend.history');
    }

    public function products()
    {
        $categories = \App\Models\ProductCategory::orderBy('name')->get();
        $products = Product::where('is_active', true)->with('category')->orderBy('order')->get();
        return view('frontend.products', compact('products', 'categories'));
    }

    public function product($slug)
    {
        $product = Product::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('frontend.product_detail', compact('product'));
    }

    public function news()
    {
        $posts = NewsPost::where('is_published', true)->latest('published_at')->paginate(9);
        return view('frontend.news', compact('posts'));
    }

    public function newsDetail($slug)
    {
        $post = NewsPost::where('slug', $slug)->where('is_published', true)->firstOrFail();
        return view('frontend.news_detail', compact('post'));
    }

    public function gallery()
    {
        $items = GalleryItem::latest()->get();
        return view('frontend.gallery', compact('items'));
    }

    public function stations()
    {
        $stations = WashingStation::latest()->get();
        return view('frontend.stations', compact('stations'));
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string'
        ]);

        Contact::create($validated);
        
        return back()->with('success', __('messages.contact_success'));
    }

    public function subscribe(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        
        Subscriber::firstOrCreate(
            ['email' => $request->email],
            ['is_active' => true]
        );

        return back()->with('newsletter_success', __('messages.newsletter_success'));
    }
}
