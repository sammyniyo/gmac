@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trix@2.1.1/dist/trix.css">
@endpush
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/trix@2.1.1/dist/trix.umd.min.js"></script>
@endpush

<x-app-layout>
    <x-slot name="header">
        <div class="shadcn-page-head">
            <div>
                <p class="shadcn-kicker">News</p>
                <h2 class="shadcn-title">{{ __('Edit Post') }}</h2>
                <p class="shadcn-desc">{{ $news->title }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="shadcn-card p-6">
                <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                        <div class="lg:col-span-2 space-y-5">
                            <div>
                                <label for="title" class="mb-1.5 block text-sm font-medium text-gray-900">Post title <span class="text-red-500">*</span></label>
                                <input type="text" name="title" id="title" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm shadow-sm focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500/20" value="{{ old('title', $news->title) }}" required>
                                @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="excerpt" class="mb-1.5 block text-sm font-medium text-gray-900">Excerpt</label>
                                <textarea name="excerpt" id="excerpt" rows="3" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm shadow-sm focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500/20" placeholder="Short summary…">{{ old('excerpt', $news->excerpt) }}</textarea>
                                @error('excerpt') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <span class="mb-1.5 block text-sm font-medium text-gray-900">Body <span class="text-red-500">*</span></span>
                                <input id="news_content" type="hidden" name="content" value="{{ e(old('content', $news->content ?? '')) }}">
                                <trix-editor input="news_content" class="trix-shadcn"></trix-editor>
                                @error('content') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="space-y-5">
                            <div class="rounded-xl border border-gray-200 bg-gray-50/80 p-4">
                                <h3 class="mb-3 border-b border-gray-200 pb-2 text-sm font-semibold text-gray-900">Publishing</h3>
                                <label class="mb-4 flex items-center gap-2 text-sm">
                                    <input type="checkbox" name="is_published" value="1" class="rounded border-gray-300 text-teal-600 focus:ring-teal-500" {{ old('is_published', $news->is_published) ? 'checked' : '' }}>
                                    <span class="font-medium">Published</span>
                                </label>
                                <div>
                                    <label for="published_at" class="mb-1 block text-xs font-medium text-gray-600">Publish date</label>
                                    <input type="date" name="published_at" id="published_at" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm" value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d') : '') }}">
                                    @error('published_at') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="rounded-xl border border-gray-200 bg-gray-50/80 p-4">
                                <h3 class="mb-3 border-b border-gray-200 pb-2 text-sm font-semibold text-gray-900">Cover image</h3>
                                @if($news->hasMedia('cover'))
                                    <div class="mb-3">
                                        <img src="{{ $news->getFirstMediaUrl('cover') }}" alt="{{ $news->title }}" class="w-full rounded-lg border border-gray-200 object-cover shadow-sm">
                                        <p class="mt-1 text-xs text-muted-foreground">Current image</p>
                                    </div>
                                @endif
                                <input type="file" name="image" id="image" class="w-full text-sm" accept="image/*">
                                <p class="mt-1 text-xs text-muted-foreground">Upload to replace. Max 2MB.</p>
                                @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex flex-wrap items-center justify-end gap-3 border-t border-gray-200 pt-6">
                        <a href="{{ route('admin.news.index') }}" class="shadcn-btn-secondary">Cancel</a>
                        <button type="submit" class="shadcn-btn">Update post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
