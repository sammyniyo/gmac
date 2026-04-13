<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Site Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b border-gray-200">
                    <form action="{{ route('admin.settings.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            
                            <!-- General Info -->
                            <div>
                                <h3 class="font-bold text-lg mb-4 text-indigo-700 border-b pb-2">General Information</h3>
                                
                                <div class="mb-4">
                                    <label for="company_name" class="block text-gray-700 font-medium mb-2">Company Name</label>
                                    <input type="text" name="company_name" id="company_name" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ $settings['company_name'] ?? '' }}">
                                </div>

                                <div class="mb-4">
                                    <label for="company_tagline" class="block text-gray-700 font-medium mb-2">Home hero tagline (pill above headline)</label>
                                    <input type="text" name="company_tagline" id="company_tagline" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ $settings['company_tagline'] ?? '' }}" placeholder="Coffee with character">
                                </div>

                                <div class="mb-4">
                                    <label for="site_description" class="block text-gray-700 font-medium mb-2">Site Description (SEO)</label>
                                    <textarea name="site_description" id="site_description" rows="3" class="w-full border-gray-300 rounded-md shadow-sm">{{ $settings['site_description'] ?? '' }}</textarea>
                                </div>

                                <div class="mb-4 bg-gray-50 border p-4 rounded text-sm">
                                    <label for="site_logo" class="block text-gray-700 font-medium mb-2">Site Logo</label>
                                    @if(isset($settings['site_logo']) && $settings['site_logo'])
                                        <div class="bg-white rounded p-2 mb-2 inline-block shadow-sm">
                                            <img src="{{ $settings['site_logo'] }}" alt="Logo" class="h-12 object-contain">
                                        </div>
                                    @endif
                                    <input type="file" name="site_logo" id="site_logo" class="w-full border-gray-300 rounded-md shadow-sm" accept="image/*">
                                </div>
                            </div>

                            <!-- Contact Info -->
                            <div>
                                <h3 class="font-bold text-lg mb-4 text-indigo-700 border-b pb-2">Contact Details</h3>
                                
                                <div class="mb-4">
                                    <label for="contact_email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                                    <input type="email" name="contact_email" id="contact_email" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ $settings['contact_email'] ?? '' }}">
                                </div>

                                <div class="mb-4">
                                    <label for="contact_phone" class="block text-gray-700 font-medium mb-2">Phone Number</label>
                                    <input type="text" name="contact_phone" id="contact_phone" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ $settings['contact_phone'] ?? '' }}">
                                </div>

                                <div class="mb-4">
                                    <label for="contact_address" class="block text-gray-700 font-medium mb-2">Physical Address</label>
                                    <textarea name="contact_address" id="contact_address" rows="3" class="w-full border-gray-300 rounded-md shadow-sm">{{ $settings['contact_address'] ?? '' }}</textarea>
                                </div>
                            </div>

                        </div>

                        <!-- Social Media -->
                        <div class="mt-8">
                            <h3 class="font-bold text-lg mb-4 text-indigo-700 border-b pb-2">Social Media Links</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="mb-4">
                                    <label for="social_facebook" class="block text-gray-700 font-medium mb-2">Facebook URL</label>
                                    <input type="url" name="social_facebook" id="social_facebook" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ $settings['social_facebook'] ?? '' }}" placeholder="https://facebook.com/...">
                                </div>
                                <div class="mb-4">
                                    <label for="social_instagram" class="block text-gray-700 font-medium mb-2">Instagram URL</label>
                                    <input type="url" name="social_instagram" id="social_instagram" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ $settings['social_instagram'] ?? '' }}" placeholder="https://instagram.com/...">
                                </div>
                                <div class="mb-4">
                                    <label for="social_twitter" class="block text-gray-700 font-medium mb-2">Twitter/X URL</label>
                                    <input type="url" name="social_twitter" id="social_twitter" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ $settings['social_twitter'] ?? '' }}" placeholder="https://twitter.com/...">
                                </div>
                            </div>
                        </div>

                        <!-- Homepage Content -->
                        <div class="mt-8">
                            <h3 class="font-bold text-lg mb-4 text-indigo-700 border-b pb-2">Homepage Content</h3>
                            <p class="text-sm text-gray-600 mb-6">Hero <strong>images</strong> are managed under <strong>Hero slides</strong> in the admin menu. Use these fields for text and the “Our history” section photo.</p>

                            <div class="mb-4 bg-gray-50 border p-4 rounded text-sm">
                                <label for="home_about_image" class="block text-gray-700 font-medium mb-2">About section image (next to Our History)</label>
                                @if(!empty($settings['home_about_image'] ?? null))
                                    <div class="bg-white rounded p-2 mb-2 inline-block shadow-sm">
                                        <img src="{{ $settings['home_about_image'] }}" alt="" class="h-24 w-auto object-cover rounded max-w-full">
                                    </div>
                                @endif
                                <input type="file" name="home_about_image" id="home_about_image" class="w-full border-gray-300 rounded-md shadow-sm" accept="image/*">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="home_hero_title" class="block text-gray-700 font-medium mb-2">Hero headline (when no slides, or slide has no title)</label>
                                    <input type="text" name="home_hero_title" id="home_hero_title" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ $settings['home_hero_title'] ?? '' }}">
                                </div>
                                <div>
                                    <label for="home_hero_subtitle" class="block text-gray-700 font-medium mb-2">Hero subtitle (fallback)</label>
                                    <input type="text" name="home_hero_subtitle" id="home_hero_subtitle" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ $settings['home_hero_subtitle'] ?? '' }}">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="home_hero_badges" class="block text-gray-700 font-medium mb-2">Hero badges (one per line; default: Sustainable, Premium, Rwanda)</label>
                                <textarea name="home_hero_badges" id="home_hero_badges" rows="3" class="w-full border-gray-300 rounded-md shadow-sm font-mono text-sm">{{ $settings['home_hero_badges'] ?? '' }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label for="about_short_text" class="block text-gray-700 font-medium mb-2">About Us Summary (first paragraph, hero + about block)</label>
                                <textarea name="about_short_text" id="about_short_text" rows="4" class="w-full border-gray-300 rounded-md shadow-sm placeholder-gray-400" placeholder="A brief introduction to the company...">{{ $settings['about_short_text'] ?? '' }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="home_about_title_before" class="block text-gray-700 font-medium mb-2">About heading — text before italic part</label>
                                    <input type="text" name="home_about_title_before" id="home_about_title_before" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ $settings['home_about_title_before'] ?? '' }}">
                                </div>
                                <div>
                                    <label for="home_about_title_em" class="block text-gray-700 font-medium mb-2">About heading — italic part</label>
                                    <input type="text" name="home_about_title_em" id="home_about_title_em" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ $settings['home_about_title_em'] ?? '' }}">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="home_about_paragraph_2" class="block text-gray-700 font-medium mb-2">About section — second paragraph</label>
                                <textarea name="home_about_paragraph_2" id="home_about_paragraph_2" rows="3" class="w-full border-gray-300 rounded-md shadow-sm">{{ $settings['home_about_paragraph_2'] ?? '' }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label for="home_why_lead" class="block text-gray-700 font-medium mb-2">“Why GMAC” intro (under section title)</label>
                                <textarea name="home_why_lead" id="home_why_lead" rows="2" class="w-full border-gray-300 rounded-md shadow-sm">{{ $settings['home_why_lead'] ?? '' }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="home_reviews_kicker" class="block text-gray-700 font-medium mb-2">Reviews — small label (kicker)</label>
                                    <input type="text" name="home_reviews_kicker" id="home_reviews_kicker" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ $settings['home_reviews_kicker'] ?? '' }}">
                                </div>
                                <div>
                                    <label for="home_reviews_title" class="block text-gray-700 font-medium mb-2">Reviews — title before italic</label>
                                    <input type="text" name="home_reviews_title" id="home_reviews_title" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ $settings['home_reviews_title'] ?? '' }}">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="home_reviews_title_em" class="block text-gray-700 font-medium mb-2">Reviews — italic part of title</label>
                                    <input type="text" name="home_reviews_title_em" id="home_reviews_title_em" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ $settings['home_reviews_title_em'] ?? '' }}">
                                </div>
                                <div>
                                    <label for="home_reviews_lead" class="block text-gray-700 font-medium mb-2">Reviews — subtitle paragraph</label>
                                    <input type="text" name="home_reviews_lead" id="home_reviews_lead" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ $settings['home_reviews_lead'] ?? '' }}">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="home_cta_kicker" class="block text-gray-700 font-medium mb-2">Bottom CTA — kicker</label>
                                    <input type="text" name="home_cta_kicker" id="home_cta_kicker" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ $settings['home_cta_kicker'] ?? '' }}">
                                </div>
                                <div>
                                    <label for="home_cta_title" class="block text-gray-700 font-medium mb-2">Bottom CTA — title before italic</label>
                                    <input type="text" name="home_cta_title" id="home_cta_title" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ $settings['home_cta_title'] ?? '' }}">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="home_cta_title_em" class="block text-gray-700 font-medium mb-2">Bottom CTA — italic part</label>
                                    <input type="text" name="home_cta_title_em" id="home_cta_title_em" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ $settings['home_cta_title_em'] ?? '' }}">
                                </div>
                                <div>
                                    <label for="home_cta_lead" class="block text-gray-700 font-medium mb-2">Bottom CTA — paragraph</label>
                                    <input type="text" name="home_cta_lead" id="home_cta_lead" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ $settings['home_cta_lead'] ?? '' }}">
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center mt-8 pt-6 border-t">
                            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 font-bold transition mx-auto block w-full shadow-md text-lg">Save All Settings</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
