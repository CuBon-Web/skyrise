@extends('layouts.main.master')
@section('title')
{{$title_page}} 
@endsection
@section('description')
{{$title_page}} 
@endsection
@section('image')
{{ url(optional($banner->first())->image ?: ($setting->logo ?? '')) }}
@endsection
@section('schema')
@php
    $cleanText = function ($value) {
        $text = (string) $value;
        // Remove zero-width chars that usually appear from copy/paste.
        return preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $text);
    };
    $jsonFlags = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;
    $currentUrl = url()->current();
    $homeUrl = route('home');
    $siteUrl = url('/');
    $categoryUrl = !empty($cate_slug) ? route('listCateBlog', ['slug' => $cate_slug]) : $currentUrl;
    $pageTitle = $cleanText($title_page);
    $siteName = $cleanText($setting->webname ?? $setting->company ?? $title_page);
    $publisherName = $cleanText($setting->company ?? $siteName);
    $publisherLogo = !empty($setting->logo)
        ? url($setting->logo)
        : (!empty($banner[0]->image) ? url($banner[0]->image) : null);

    $itemListElements = [];
    foreach ($blog as $index => $item) {
        $postUrl = route('detailBlog', ['slug' => $item->slug]);
        $postImage = !empty($item->image) ? url($item->image) : null;
        $itemListElements[] = [
            '@type' => 'ListItem',
            'position' => $index + 1,
            'url' => $postUrl,
            'item' => array_filter([
                '@type' => 'BlogPosting',
                'headline' => $cleanText(languageName($item->title)),
                'description' => $cleanText(strip_tags(languageName($item->description))),
                'datePublished' => optional($item->created_at)->toIso8601String(),
                'image' => $postImage,
                'mainEntityOfPage' => $postUrl,
            ], function ($value) {
                return !is_null($value) && $value !== '';
            }),
        ];
    }

    $schemaGraph = [
        [
            '@type' => 'WebSite',
            '@id' => $siteUrl . '#website',
            'url' => $siteUrl,
            'name' => $siteName,
            'inLanguage' => 'vi-VN',
        ],
        array_filter([
            '@type' => 'Organization',
            '@id' => $siteUrl . '#organization',
            'name' => $publisherName,
            'url' => $siteUrl,
            'logo' => $publisherLogo ? [
                '@type' => 'ImageObject',
                'url' => $publisherLogo,
            ] : null,
        ], function ($value) {
            return !is_null($value) && $value !== '';
        }),
        [
            '@type' => 'BreadcrumbList',
            '@id' => $currentUrl . '#breadcrumb',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Trang chủ',
                    'item' => $homeUrl,
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => $pageTitle,
                    'item' => $categoryUrl,
                ],
            ],
        ],
        [
            '@type' => 'CollectionPage',
            '@id' => $currentUrl . '#collection',
            'url' => $currentUrl,
            'name' => $pageTitle,
            'description' => $pageTitle,
            'inLanguage' => 'vi-VN',
            'isPartOf' => [
                '@type' => 'WebSite',
                '@id' => $siteUrl . '#website',
            ],
        ],
        [
            '@type' => 'ItemList',
            '@id' => $currentUrl . '#itemlist',
            'name' => $pageTitle,
            'numberOfItems' => count($itemListElements),
            'itemListElement' => $itemListElements,
        ],
    ];
@endphp
<script type="application/ld+json">{!! json_encode(['@context' => 'https://schema.org', '@graph' => $schemaGraph], $jsonFlags) !!}</script>
@endsection
@section('css')
<link rel="stylesheet" href="/frontend/css/event-page.css?v={{ filemtime(public_path('frontend/css/event-page.css')) }}">
<link rel="stylesheet" href="/frontend/css/blog-page.css?v={{ filemtime(public_path('frontend/css/blog-page.css')) }}">
@endsection
@section('js')
<script src="/frontend/js/sticky-sidebar.js?v={{ filemtime(public_path('frontend/js/sticky-sidebar.js')) }}"></script>
@endsection
@section('content')
<section class="news news--page" aria-labelledby="blog-title">
    <div class="news__bg" aria-hidden="true">
        <span class="news__blob news__blob--mint"></span>
        <span class="news__blob news__blob--blue"></span>
    </div>

    <div class="news__inner">
        <nav class="event-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Trang chủ</a>
            <span aria-hidden="true">/</span>
            @if (!empty($type_name) && !empty($cate_slug) && $cate_name !== '')
                <a href="{{ route('listCateBlog', ['slug' => $cate_slug]) }}">{{ $cate_name }}</a>
                <span aria-hidden="true">/</span>
            @endif
            <span>{{ $title_page }}</span>
        </nav>

        <header class="news__head">
            <div class="news__intro">
                <span class="news__eyebrow">Tin tức</span>
                <h1 class="news__title" id="blog-title">{{ $title_page }}</h1>
                <p class="news__lead">Cập nhật tin tức, cẩm nang bay và hoạt động mới nhất của đội bay khinh khí cầu.</p>
            </div>
            @if ($blog->total())
                <p class="events__count"><strong>{{ $blog->total() }}</strong> bài viết</p>
            @endif
        </header>

        <div class="event-layout">
            <div class="event-layout__main">
                @if ($blog->count())
                    <div class="blog-grid">
                        @foreach ($blog as $item)
                            @include('blog._card', ['item' => $item])
                        @endforeach
                    </div>

                    @if ($blog->hasPages())
                        <div class="event-pagination">
                            {{ $blog->onEachSide(1)->links() }}
                        </div>
                    @endif
                @else
                    <p class="event-empty">Chưa có bài viết nào trong danh mục này.</p>
                @endif
            </div>

            <aside class="event-layout__aside" aria-label="Thông tin thêm">
                <div class="event-sidebar">
                    @if ($blognew->isNotEmpty())
                        <div class="event-widget">
                            <h2 class="event-widget__title">Bài viết <span class="is-accent">mới</span></h2>
                            <ul class="blog-recent">
                                @foreach ($blognew as $item)
                                    <li>
                                        <a href="{{ route('detailBlog', ['slug' => $item->slug]) }}">
                                            <img src="{{ $item->image ? url($item->image) : '/frontend/images/bgbanner.jpg' }}" alt="" width="64" height="48" loading="lazy" decoding="async">
                                            <span>
                                                <strong>{{ languageName($item->title) }}</strong>
                                                <small>{{ optional($item->created_at)->format('d/m/Y') }}</small>
                                            </span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (!empty($popularBlogTags))
                        <div class="event-widget">
                            <h2 class="event-widget__title">Thẻ <span class="is-accent">phổ biến</span></h2>
                            <ul class="blog-tags">
                                @foreach (array_slice($popularBlogTags, 0, 12) as $tag)
                                    <li><a href="{{ route('listBlogTag', ['tag' => $tag]) }}">{{ $tag }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @include('partials.sidebar-consult', ['consultSource' => 'Tin tức: ' . $title_page])
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
