<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactMessageRequest;
use App\Mail\ContactReceived;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
use App\Support\FrontendShowcase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
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

        $heroDefaults = collect(FrontendShowcase::heroSlides());

        $heroSlides = HeroSlide::where('is_active', true)
            ->orderBy('order')
            ->get()
            ->map(function (HeroSlide $slide) use ($heroDefaults) {
                $url = $slide->getFirstMediaUrl('slides');
                if ($url === '') {
                    return null;
                }

                $fallback = $heroDefaults->first(
                    fn (array $row) => mb_strtolower($row['title']) === mb_strtolower($slide->title)
                );

                return (object) [
                    'title' => $slide->title,
                    'subtitle' => $slide->subtitle,
                    'image_url' => $url,
                    'image_position' => $fallback['position'] ?? 'center 40%',
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
            $brandStoryImage = FrontendShowcase::img('women_beds');
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

        $featuredProducts = Product::where('is_active', true)
            ->with('category')
            ->orderBy('order')
            ->get()
            ->unique(fn (Product $product) => $product->product_category_id)
            ->take(3)
            ->values();
        $stats = Statistic::orderBy('order')->get();
        if ($stats->isEmpty()) {
            $stats = collect(FrontendShowcase::stats())->map(fn (array $row) => (object) $row);
        }
        $testimonials = Testimonial::where('is_active', true)->orderBy('order')->take(6)->get();
        if ($testimonials->isEmpty()) {
            $testimonials = collect(FrontendShowcase::testimonials())->map(fn (array $row) => (object) $row);
        }
        $processSteps = FrontendShowcase::process();

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
            'testimonials',
            'processSteps'
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
        $feedbacks = collect();
        if (Schema::hasTable('feedbacks')) {
            $feedbacks = Feedback::where('is_approved', true)->latest()->take(50)->get();
        }

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
        $products = Product::where('is_active', true)->with('category')->orderBy('order')->get();
        $categories = \App\Models\ProductCategory::whereHas('products', fn ($q) => $q->where('is_active', true))
            ->orderBy('name')
            ->get();

        return view('frontend.products', compact('products', 'categories'));
    }

    public function shop()
    {
        $products = Product::where('is_active', true)->with('category')->orderBy('order')->get();
        $categories = \App\Models\ProductCategory::whereHas('products', fn ($q) => $q->where('is_active', true))
            ->orderBy('name')
            ->get();

        return view('frontend.shop', compact('products', 'categories'));
    }

    public function productDetail(Product $product)
    {
        abort_unless($product->is_active, 404);
        $product->load('category');

        $catalog = Product::where('is_active', true)->with('category')->orderBy('order')->get();
        $variants = $catalog
            ->filter(fn (Product $row) => $row->packColor() === $product->packColor())
            ->unique(fn (Product $row) => $row->packSize())
            ->values();
        $colours = $catalog
            ->filter(fn (Product $row) => $row->packSize() === $product->packSize())
            ->unique(fn (Product $row) => $row->packColor())
            ->values();

        $related = $catalog
            ->where('id', '!=', $product->id)
            ->take(4)
            ->values();

        $gallery = collect([
            ['src' => $product->displayImage(), 'label' => $product->name, 'pack' => $product->usesPackShot()],
            ['src' => FrontendShowcase::img('cupping_line'), 'label' => 'The cupping table', 'pack' => false],
            ['src' => FrontendShowcase::img('roaster'), 'label' => 'Sample roast', 'pack' => false],
            ['src' => FrontendShowcase::img('cupping_glasses'), 'label' => 'Ready to taste', 'pack' => false],
        ])->unique('src')->values();

        return view('frontend.product_detail', compact('product', 'variants', 'colours', 'related', 'gallery'));
    }

    public function news()
    {
        $posts = NewsPost::where('is_published', true)->latest('published_at')->paginate(9);
        if ($posts->total() === 0) {
            $fallback = collect(FrontendShowcase::news())
                ->map(fn (array $row) => new NewsPost($row))
                ->sortByDesc('published_at')
                ->values();
            $posts = new \Illuminate\Pagination\LengthAwarePaginator(
                $fallback->forPage(1, 9)->values(),
                $fallback->count(),
                9,
                1,
                ['path' => request()->url()]
            );
        }

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
        $items = GalleryItem::where('is_active', true)->orderBy('order')->get();
        return view('frontend.gallery', compact('items'));
    }

    public function stations()
    {
        $stations = WashingStation::query()->orderBy('order')->orderBy('id')->get();
        if ($stations->isEmpty()) {
            $stations = collect(FrontendShowcase::stations())
                ->map(fn (array $row) => new WashingStation($row));
        }

        return view('frontend.stations', compact('stations'));
    }

    public function team()
    {
        $defaults = collect(FrontendShowcase::teamMembers());

        $team = TeamMember::query()
            ->where('is_active', true)
            ->orderBy('order')
            ->orderBy('name')
            ->get()
            ->map(function (TeamMember $member) use ($defaults) {
                $fallback = $defaults->first(
                    fn ($row) => mb_strtolower($row['name']) === mb_strtolower($member->name)
                );

                return [
                    'name' => $member->name,
                    'role' => $member->role,
                    'email' => $member->email,
                    'phone' => $member->phone,
                    'bio' => $member->bio ?: ($fallback['bio'] ?? null),
                    'quote' => $fallback['quote'] ?? null,
                    'photo' => $member->portraitUrl() ?: ($fallback['photo'] ?? null),
                    'focus' => $fallback['focus'] ?? null,
                    'pose' => $fallback['pose'] ?? 'face',
                    'initials' => $member->avatarInitials(),
                ];
            });

        if ($team->isEmpty()) {
            $team = $defaults->map(fn (array $row) => array_merge($row, [
                'initials' => TeamMember::makeInitials($row['name']),
            ]));
        }

        $stories = FrontendShowcase::teamStories();

        return view('frontend.team', compact('stories', 'team'));
    }

    public function contact()
    {
        return view('frontend.contact', [
            'topics' => ContactMessageRequest::TOPICS,
        ]);
    }

    public function sendContact(ContactMessageRequest $request)
    {
        return $this->submitContact($request);
    }

    public function submitContact(ContactMessageRequest $request)
    {
        if ($request->shouldDrop()) {
            return back()->with('success', __('messages.contact_success'));
        }

        $payload = $request->safePayload();
        Contact::create($payload);

        $notify = Setting::where('key', 'contact_email')->value('value')
            ?: config('mail.from.address')
            ?: 'info@gmac.coffee';

        try {
            Mail::to($notify)->send(new ContactReceived($payload));
        } catch (\Throwable $e) {
            Log::warning('Contact mail failed: '.$e->getMessage());
        }

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
