@extends('layouts.main.master')
@section('title')
    {{ $blog_detail->seo_title ? $blog_detail->seo_title : languageName($blog_detail->title) }}
@endsection
@section('description')
    {{ $blog_detail->meta_description ? $blog_detail->meta_description : languageName($blog_detail->description) }}
@endsection
@section('image')
    {{ url($blog_detail->image ?: ($setting->logo ?? '')) }}
@endsection
@section('schema')
    @php
        $cleanText = function ($value) {
            $text = (string) $value;
            // Remove zero-width chars that usually appear from copy/paste.
            return preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $text);
        };
        $jsonFlags = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;
        $postTitle = $cleanText(languageName($blog_detail->title));
        $postDescription = $cleanText(
            $blog_detail->meta_description ?: strip_tags(languageName($blog_detail->description))
        );
        $postContentText = trim($cleanText(strip_tags(languageName($blog_detail->content))));
        preg_match_all('/[\p{L}\p{N}]+/u', $postContentText, $wordMatches);
        $postWordCount = count($wordMatches[0]);
        $postUrl = url()->current();
        $homeUrl = route('home');
        $categoryUrl = route('listCateBlog', ['slug' => $blog_detail->category]);
        $categoryName = $blog_detail->cate ? $cleanText(languageName($blog_detail->cate->name)) : $cleanText($blog_detail->category);
        $siteName = $setting->webname ?? ($setting->company ?? 'Website');
        $publisherName = $setting->company ?? $siteName;
        $publisherLogo = !empty($setting->logo) ? url($setting->logo) : url('' . $blog_detail->image);
    @endphp
    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "WebSite",
      "@id": {!! json_encode(url('/') . '#website', $jsonFlags) !!},
      "url": {!! json_encode(url('/'), $jsonFlags) !!},
      "name": {!! json_encode($siteName, $jsonFlags) !!}
    },
    {
      "@type": "Organization",
      "@id": {!! json_encode(url('/') . '#organization', $jsonFlags) !!},
      "name": {!! json_encode($publisherName, $jsonFlags) !!},
      "url": {!! json_encode(url('/'), $jsonFlags) !!},
      "logo": {
        "@type": "ImageObject",
        "url": {!! json_encode($publisherLogo, $jsonFlags) !!}
      }
    },
    {
      "@type": "BreadcrumbList",
      "@id": {!! json_encode($postUrl . '#breadcrumb', $jsonFlags) !!},
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "Trang chủ",
          "item": {!! json_encode($homeUrl, $jsonFlags) !!}
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": {!! json_encode($categoryName, $jsonFlags) !!},
          "item": {!! json_encode($categoryUrl, $jsonFlags) !!}
        },
        {
          "@type": "ListItem",
          "position": 3,
          "name": {!! json_encode($postTitle, $jsonFlags) !!},
          "item": {!! json_encode($postUrl, $jsonFlags) !!}
        }
      ]
    },
    {
      "@type": "BlogPosting",
      "@id": {!! json_encode($postUrl . '#article', $jsonFlags) !!},
      "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": {!! json_encode($postUrl, $jsonFlags) !!}
      },
      "headline": {!! json_encode($postTitle, $jsonFlags) !!},
      "description": {!! json_encode($postDescription, $jsonFlags) !!},
      "articleSection": {!! json_encode($categoryName, $jsonFlags) !!},
      "keywords": {!! json_encode(implode(', ', $blogTags ?? []), $jsonFlags) !!},
      "inLanguage": "vi-VN",
      "wordCount": {{ $postWordCount }},
      "datePublished": {!! json_encode(optional($blog_detail->created_at)->toIso8601String(), $jsonFlags) !!},
      "dateModified": {!! json_encode(optional($blog_detail->updated_at)->toIso8601String(), $jsonFlags) !!},
      "image": [
        {
          "@type": "ImageObject",
          "url": {!! json_encode(url($blog_detail->image ?: ($setting->logo ?? '')), $jsonFlags) !!}
        }
      ],
      "author": {
        "@type": "Person",
        "name": {!! json_encode($cleanText($blog_detail->author ?: 'Admin'), $jsonFlags) !!}
      },
      "publisher": {
        "@type": "Organization",
        "@id": {!! json_encode(url('/') . '#organization', $jsonFlags) !!}
      }
    }
  ]
}
</script>
@endsection
@section('css')
<link rel="stylesheet" href="/frontend/css/event-page.css?v={{ filemtime(public_path('frontend/css/event-page.css')) }}">
<link rel="stylesheet" href="/frontend/css/blog-page.css?v={{ filemtime(public_path('frontend/css/blog-page.css')) }}">
@endsection
@section('js')
<script src="/frontend/js/sticky-sidebar.js?v={{ filemtime(public_path('frontend/js/sticky-sidebar.js')) }}"></script>
<script>
    (function () {
        var btn = document.querySelector('[data-copy-link]');
        if (!btn || !navigator.clipboard) return;
        btn.addEventListener('click', function () {
            navigator.clipboard.writeText(btn.getAttribute('data-copy-link')).then(function () {
                btn.classList.add('is-copied');
                setTimeout(function () { btn.classList.remove('is-copied'); }, 1800);
            });
        });
    })();
</script>
@endsection
@section('content')
@php
    $detailTitle = languageName($blog_detail->title);
    $detailLead = trim(html_entity_decode(strip_tags(languageName($blog_detail->description)), ENT_QUOTES, 'UTF-8'));
    $detailCategory = $blog_detail->cate ? languageName($blog_detail->cate->name) : '';
    $detailWords = preg_split('/\s+/u', trim(strip_tags(languageName($blog_detail->content))), -1, PREG_SPLIT_NO_EMPTY);
    $detailMinutes = max(1, (int) ceil(count($detailWords) / 200));
    $detailAuthor = languageName($blog_detail->author ?: 'Admin');
    $shareUrl = urlencode(url()->current());
@endphp
<section class="news news--page news--detail">
    <div class="news__bg" aria-hidden="true">
        <span class="news__blob news__blob--mint"></span>
        <span class="news__blob news__blob--blue"></span>
    </div>

    <div class="news__inner">
        <nav class="event-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Trang chủ</a>
            <span aria-hidden="true">/</span>
            @if ($detailCategory !== '')
                <a href="{{ route('listCateBlog', ['slug' => $blog_detail->category]) }}">{{ $detailCategory }}</a>
                <span aria-hidden="true">/</span>
            @endif
            <span>{{ $detailTitle }}</span>
        </nav>

        <div class="event-layout">
            <div class="event-layout__main">
                <article class="event-detail blog-article">
                    <header class="event-detail__head">
                        @if ($detailCategory !== '')
                            <a class="events__eyebrow blog-article__cat" href="{{ route('listCateBlog', ['slug' => $blog_detail->category]) }}">{{ $detailCategory }}</a>
                        @endif
                        <h1 class="event-detail__title">{{ $detailTitle }}</h1>
                        <ul class="blog-article__meta">
                            <li>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3.5" y="5" width="17" height="15.5" rx="2.5"/><path d="M3.5 10h17M8 3v4M16 3v4"/></svg>
                                <time datetime="{{ optional($blog_detail->created_at)->toDateString() }}">{{ optional($blog_detail->created_at)->format('d/m/Y') }}</time>
                            </li>
                            <li>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="8.5"/><path d="M12 7.5V12l3 2"/></svg>
                                {{ $detailMinutes }} phút đọc
                            </li>
                            <li>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/></svg>
                                {{ $detailAuthor }}
                            </li>
                        </ul>
                        @if ($detailLead !== '')
                            <p class="blog-article__lead">{{ $detailLead }}</p>
                        @endif
                    </header>

                    @if ($blog_detail->image)
                        <figure class="event-detail__cover">
                            <img src="{{ url($blog_detail->image) }}" alt="{{ $detailTitle }}" decoding="async">
                        </figure>
                    @endif

                    <div class="event-detail__content">
                        {!! languageName($blog_detail->content) !!}
                    </div>

                    <footer class="blog-article__foot">
                        @if (!empty($blogTags))
                            <ul class="blog-tags" aria-label="Thẻ bài viết">
                                @foreach ($blogTags as $tag)
                                    <li><a href="{{ route('listBlogTag', ['tag' => $tag]) }}">#{{ $tag }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                        <div class="blog-share">
                            <span class="blog-share__label">Chia sẻ</span>
                            <a class="blog-share__btn" href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener" aria-label="Chia sẻ lên Facebook">
                                <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M13.5 21v-7.5h2.6l.4-3h-3V8.6c0-.9.3-1.5 1.6-1.5h1.6V4.4c-.3 0-1.2-.1-2.3-.1-2.3 0-3.9 1.4-3.9 4v2.2H8v3h2.5V21h3z"/></svg>
                            </a>
                            <a class="blog-share__btn" href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ urlencode($detailTitle) }}" target="_blank" rel="noopener" aria-label="Chia sẻ lên X">
                                <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.8 3h3.1l-6.8 7.8L22 21h-6.2l-4.9-6.4L5.3 21H2.2l7.3-8.3L1.9 3h6.3l4.4 5.8L17.8 3zm-1.1 16.2h1.7L7.4 4.7H5.6l11.1 14.5z"/></svg>
                            </a>
                            <a class="blog-share__btn" href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}" target="_blank" rel="noopener" aria-label="Chia sẻ lên LinkedIn">
                                <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6.9 8.8H3.6V20h3.3V8.8zM5.3 3.5a1.9 1.9 0 1 0 0 3.8 1.9 1.9 0 0 0 0-3.8zM20.4 13.6c0-3-1.6-5-4.3-5-1.4 0-2.4.8-2.8 1.5V8.8H10V20h3.3v-5.6c0-1.5.3-2.9 2.1-2.9 1.8 0 1.8 1.7 1.8 3V20h3.3l-.1-6.4z"/></svg>
                            </a>
                            <button type="button" class="blog-share__btn" data-copy-link="{{ url()->current() }}" aria-label="Sao chép liên kết">
                                <svg class="blog-share__icon-link" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10 14a4.5 4.5 0 0 0 6.4 0l3-3a4.5 4.5 0 0 0-6.4-6.4l-1 1"/><path d="M14 10a4.5 4.5 0 0 0-6.4 0l-3 3a4.5 4.5 0 0 0 6.4 6.4l1-1"/></svg>
                                <svg class="blog-share__icon-done" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12.5l4.5 4.5L19 7.5"/></svg>
                            </button>
                        </div>
                    </footer>
                </article>

                @if ($bloglq->isNotEmpty())
                    <section class="event-related" aria-labelledby="blog-related-title">
                        <h2 class="event-related__title" id="blog-related-title">Bài viết <span class="is-accent">liên quan</span></h2>
                        <div class="blog-grid">
                            @foreach ($bloglq as $item)
                                @include('blog._card', ['item' => $item])
                            @endforeach
                        </div>
                    </section>
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

                    @include('partials.sidebar-consult', ['consultSource' => 'Tin tức: ' . $detailTitle])
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
