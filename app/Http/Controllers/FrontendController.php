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
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\Setting;
use App\Models\Feedback;
use Illuminate\Support\Collection;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class FrontendController extends Controller
{
    public function index()
    {
        return $this->home();
    }

    public function home()
    {
        $settingKeys = [
            'company_tagline',
            'about_short_text',
            'home_about_image',
            'home_about_title_before',
            'home_about_title_em',
            'home_about_paragraph_2',
            'home_why_lead',
            'home_reviews_kicker',
            'home_reviews_title',
            'home_reviews_title_em',
            'home_reviews_lead',
            'home_cta_kicker',
            'home_cta_title',
            'home_cta_title_em',
            'home_cta_lead',
            'home_hero_title',
            'home_hero_subtitle',
            'home_hero_badges',
        ];

        $settings = Setting::whereIn('key', $settingKeys)->pluck('value', 'key');

        $heroSlides = HeroSlide::where('is_active', true)
            ->orderBy('order')
            ->get()
            ->map(function (HeroSlide $slide) {
                $url = $slide->getFirstMediaUrl('slides');
                if ($url === '') {
                    return null;
                }

                return (object) [
                    'title' => $slide->title,
                    'subtitle' => $slide->subtitle,
                    'image_url' => $url,
                    'button_text' => $slide->button_text,
                    'button_href' => $this->localizeHeroButtonLink($slide->button_link),
                ];
            })
            ->filter()
            ->values();

        $firstSlide = $heroSlides->first();

        $heroTitle = $firstSlide?->title ?? $settings['home_hero_title'] ?? __('messages.slogan');
        $heroSub = $firstSlide?->subtitle ?? $settings['home_hero_subtitle']
            ?? __('messages.home_hero_subtitle_default');

        $tagline = $settings['company_tagline'] ?? __('messages.home_tagline_default');

        $aboutShort = $settings['about_short_text'] ?? __('messages.home_about_short_default');

        $brandStoryImage = $settings['home_about_image'] ?? null;
        if (empty($brandStoryImage)) {
            $brandStoryImage = asset('images/pexels-adam-lukac-254247-773958-1920x1280.jpg.jpeg');
        }

        $aboutTitleBefore = $settings['home_about_title_before'] ?? __('messages.home_about_title_before_default');
        $aboutTitleEm = $settings['home_about_title_em'] ?? __('messages.home_about_title_em_default');

        $aboutParagraph2 = $settings['home_about_paragraph_2'] ?? __('messages.home_about_paragraph_2_default');

        $whyLead = $settings['home_why_lead'] ?? __('messages.home_why_lead_default');

        $reviewsKicker = $settings['home_reviews_kicker'] ?? __('messages.home_reviews_kicker_default');
        $reviewsTitle = $settings['home_reviews_title'] ?? __('messages.home_reviews_title_default');
        $reviewsTitleEm = $settings['home_reviews_title_em'] ?? __('messages.home_reviews_title_em_default');
        $reviewsLead = $settings['home_reviews_lead'] ?? __('messages.home_reviews_lead_default');

        $ctaKicker = $settings['home_cta_kicker'] ?? __('messages.home_cta_kicker_default');
        $ctaTitle = $settings['home_cta_title'] ?? __('messages.home_cta_title_default');
        $ctaTitleEm = $settings['home_cta_title_em'] ?? __('messages.home_cta_title_em_default');
        $ctaLead = $settings['home_cta_lead'] ?? __('messages.home_cta_lead_default');

        $heroBadges = $this->parseHomeHeroBadges($settings['home_hero_badges'] ?? null);

        $featuredProducts = Product::where('is_active', true)->latest()->take(3)->get();
        $stats = Statistic::orderBy('order')->get();
        $testimonials = Testimonial::where('is_active', true)->orderBy('order')->take(6)->get();

        return view('frontend.home', compact(
            'heroSlides',
            'heroTitle',
            'heroSub',
            'tagline',
            'aboutShort',
            'brandStoryImage',
            'aboutTitleBefore',
            'aboutTitleEm',
            'aboutParagraph2',
            'whyLead',
            'reviewsKicker',
            'reviewsTitle',
            'reviewsTitleEm',
            'reviewsLead',
            'ctaKicker',
            'ctaTitle',
            'ctaTitleEm',
            'ctaLead',
            'heroBadges',
            'featuredProducts',
            'stats',
            'testimonials'
        ));
    }

    /**
     * @return Collection<int, string>
     */
    private function parseHomeHeroBadges(?string $raw): Collection
    {
        if ($raw === null || trim($raw) === '') {
            return collect([
                __('messages.sustainable'),
                __('messages.premium'),
                __('messages.home_hero_badge_region_default'),
            ]);
        }

        return collect(preg_split('/\r\n|\r|\n/', $raw))
            ->map(fn (string $line) => trim($line))
            ->filter()
            ->values();
    }

    /**
     * Hero slide "Button link" in admin: full URL, or path like /shop, shop, products.
     */
    protected function localizeHeroButtonLink(?string $link): string
    {
        if ($link === null || trim($link) === '') {
            return LaravelLocalization::localizeUrl(url('/products'));
        }

        $link = trim($link);
        if (preg_match('#^https?://#i', $link)) {
            return $link;
        }

        $path = str_starts_with($link, '/') ? $link : '/'.ltrim($link, '/');

        return LaravelLocalization::localizeUrl(url($path));
    }

    public function reviews()
    {
        $feedbacks = Feedback::where('is_approved', true)->latest()->take(50)->get();

        return view('frontend.reviews', compact('feedbacks'));
    }

    public function submitFeedback(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'body' => 'required|string|min:10|max:5000',
        ]);

        Feedback::create([
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'rating' => $validated['rating'],
            'body' => $validated['body'],
            'is_approved' => false,
        ]);

        return back()->with('feedback_success', __('messages.feedback_success'));
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

    public function shop()
    {
        $categories = \App\Models\ProductCategory::orderBy('name')->get();
        $products = Product::where('is_active', true)->with('category')->orderBy('order')->get();
        return view('frontend.shop', compact('products', 'categories'));
    }

    public function productDetail(Product $product)
    {
        abort_unless($product->is_active, 404);
        return view('frontend.product_detail', compact('product'));
    }

    public function news()
    {
        $posts = NewsPost::where('is_published', true)->latest('published_at')->paginate(9);
        $heroPosts = NewsPost::where('is_published', true)
            ->latest('published_at')
            ->take(6)
            ->get();

        return view('frontend.news', compact('posts', 'heroPosts'));
    }

    public function newsDetail(NewsPost $post)
    {
        abort_unless($post->is_published, 404);

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

    public function team()
    {
        $team = TeamMember::where('is_active', true)
            ->orderBy('order')
            ->get()
            ->map(function (TeamMember $member) {
                return [
                    'name' => $member->name,
                    'role' => $member->role,
                    'email' => $member->email,
                    'phone' => $member->phone,
                    'bio' => $member->bio,
                    'photo' => $member->getFirstMediaUrl('photos') ?: null,
                ];
            });

        if ($team->isEmpty()) {
            $team = collect([
                [
                    'name' => 'Niyonsaba Jeanne',
                    'role' => 'Founder & Chairperson',
                    'email' => 'info@gmac.coffee',
                    'phone' => '+250 783 053 415',
                    'bio' => 'Jeanne founded GMAC Coffee with a vision to create more value from origin, build stronger traceability, and open better opportunities for farmers, especially women in Rwanda’s coffee sector.',
                    'photo' => asset('images/Jeanne.png'),
                ],
            ]);
        }

        return view('frontend.team', compact('team'));
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function sendContact(Request $request)
    {
        return $this->submitContact($request);
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
