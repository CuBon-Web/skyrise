@extends('layouts.main.master')
@php
    $collectImages = function ($raw) use (&$collectImages) {
        if (is_array($raw)) {
            return collect($raw)->flatMap(function ($item) use ($collectImages) {
                return $collectImages($item);
            })->all();
        }
        if (!is_string($raw) || trim($raw) === '') {
            return [];
        }
        $decoded = json_decode($raw, true);
        if (json_last_error() === JSON_ERROR_NONE && (is_array($decoded) || is_string($decoded)) && $decoded !== $raw) {
            return $collectImages($decoded);
        }
        return [trim($raw)];
    };
    $serviceName = languageName($cateService->name);
    $serviceDesc = trim(html_entity_decode(strip_tags(languageName($cateService->description)), ENT_QUOTES, 'UTF-8'));
    $serviceImages = collect($collectImages($cateService->image))->filter()->unique()->values();
    $serviceCover = $serviceImages->first() ?: '/frontend/images/bgbanner.jpg';
    $serviceContent = languageName($cateService->content);
    $hotline = trim((string) ($setting->phone1 ?? ''));
    $hotlineTel = preg_replace('/[^\d+]/', '', $hotline);
    $zaloUrl = $hotline !== '' ? 'https://zalo.me/' . preg_replace('/\D/', '', $hotline) : null;
    $serviceSteps = [
        ['title' => 'Tiếp nhận yêu cầu', 'text' => 'Lắng nghe mục tiêu, quy mô và thời gian sự kiện của bạn.'],
        ['title' => 'Khảo sát & tư vấn', 'text' => 'Khảo sát địa điểm, điều kiện thời tiết và đề xuất phương án bay.'],
        ['title' => 'Báo giá & ký kết', 'text' => 'Báo giá minh bạch, rõ hạng mục, không phát sinh chi phí.'],
        ['title' => 'Triển khai & bàn giao', 'text' => 'Đội bay chuyên nghiệp vận hành an toàn, đúng kế hoạch.'],
    ];
@endphp
@section('title')
{{ $serviceName }} - {{ $setting->company }}
@endsection
@section('description')
{{ \Illuminate\Support\Str::limit($serviceDesc ?: trim(strip_tags($serviceContent)), 160) }}
@endsection
@section('image')
{{ url($serviceCover) }}
@endsection
@section('css')
<link rel="stylesheet" href="/frontend/css/event-page.css?v={{ filemtime(public_path('frontend/css/event-page.css')) }}">
<link rel="stylesheet" href="/frontend/css/service-page.css?v={{ filemtime(public_path('frontend/css/service-page.css')) }}">
@endsection
@section('js')
<script src="/frontend/js/sticky-sidebar.js?v={{ filemtime(public_path('frontend/js/sticky-sidebar.js')) }}"></script>
<script>
    (function () {
        var main = document.querySelector('[data-service-cover]');
        document.querySelectorAll('[data-service-thumb]').forEach(function (thumb) {
            thumb.addEventListener('click', function () {
                if (!main) return;
                main.src = thumb.getAttribute('data-service-thumb');
                document.querySelectorAll('[data-service-thumb]').forEach(function (t) { t.classList.remove('is-active'); });
                thumb.classList.add('is-active');
            });
        });

        document.querySelectorAll('a[href="#event-consult"]').forEach(function (link) {
            link.addEventListener('click', function (e) {
                var form = document.getElementById('event-consult');
                if (!form) return;
                e.preventDefault();
                form.scrollIntoView({ behavior: 'smooth', block: 'center' });
                var first = form.querySelector('input:not([type=hidden])');
                if (first) setTimeout(function () { first.focus({ preventScroll: true }); }, 450);
            });
        });
    })();
</script>
@endsection
@section('content')
<section class="events events--page events--detail service-page">
    <div class="events__bg" aria-hidden="true">
        <span class="events__blob events__blob--blue"></span>
        <span class="events__blob events__blob--peach"></span>
    </div>

    <div class="events__inner">
        <nav class="event-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Trang chủ</a>
            <span aria-hidden="true">/</span>
            <a href="{{ route('home') }}#attractions">Dịch vụ</a>
            <span aria-hidden="true">/</span>
            <span>{{ $serviceName }}</span>
        </nav>

        <header class="service-hero">
            <div class="service-hero__content">
                <span class="events__eyebrow">Dịch vụ</span>
                <h1 class="service-hero__title">{{ $serviceName }}</h1>
                @if ($serviceDesc !== '')
                    <p class="service-hero__desc">{{ $serviceDesc }}</p>
                @endif

                <ul class="service-hero__points">
                    <li>Tư vấn &amp; khảo sát miễn phí</li>
                    <li>Báo giá minh bạch, không phát sinh</li>
                    <li>Đội bay lớn thứ 2 Châu Á</li>
                    <li>Phi công giàu kinh nghiệm, an toàn tuyệt đối</li>
                </ul>

                <div class="service-hero__actions">
                    <a class="service-btn service-btn--primary" href="#event-consult">
                        Nhận tư vấn miễn phí
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </a>
                    @if ($hotline !== '')
                        <a class="service-btn service-btn--ghost" href="tel:{{ $hotlineTel }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2"/></svg>
                            {{ $hotline }}
                        </a>
                    @endif
                </div>
            </div>

            <div class="service-hero__media">
                <div class="service-hero__frame">
                    <img src="{{ url($serviceCover) }}" alt="{{ $serviceName }}" width="900" height="640" decoding="async" data-service-cover>
                </div>
                @if ($serviceImages->count() > 1)
                    <div class="service-hero__thumbs" role="list" aria-label="Hình ảnh dịch vụ">
                        @foreach ($serviceImages->take(5) as $img)
                            <button type="button" role="listitem" class="service-hero__thumb {{ $loop->first ? 'is-active' : '' }}" data-service-thumb="{{ url($img) }}" aria-label="Xem ảnh {{ $loop->iteration }}">
                                <img src="{{ url($img) }}" alt="" width="120" height="84" loading="lazy" decoding="async">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>
        </header>

        <div class="event-layout">
            <div class="event-layout__main">
                @if (trim(strip_tags((string) $serviceContent, '<img><iframe><video>')) !== '')
                    <article class="event-detail service-content">
                        <h2 class="service-section__title">Giới thiệu <span class="is-accent">dịch vụ</span></h2>
                        <div class="event-detail__content">
                            {!! $serviceContent !!}
                        </div>
                    </article>
                @endif

                <section class="service-steps" aria-labelledby="service-steps-title">
                    <h2 class="service-section__title" id="service-steps-title">Quy trình <span class="is-accent">làm việc</span></h2>
                    <ol class="service-steps__list">
                        @foreach ($serviceSteps as $step)
                            <li class="service-step">
                                <span class="service-step__num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                <h3 class="service-step__title">{{ $step['title'] }}</h3>
                                <p class="service-step__text">{{ $step['text'] }}</p>
                            </li>
                        @endforeach
                    </ol>
                </section>

                @if ($list->count())
                    <section class="service-items" aria-labelledby="service-items-title">
                        <h2 class="service-section__title" id="service-items-title">Gói dịch vụ <span class="is-accent">&amp; bài viết</span></h2>
                        <div class="service-items__grid">
                            @foreach ($list as $item)
                                @php
                                    $itemUrl = route('serviceDetail', ['danhmuc' => $item->cate_slug, 'slug' => $item->slug]);
                                    $itemImage = collect($collectImages($item->image))->first() ?: '/frontend/images/bgbanner.jpg';
                                    $itemDesc = \Illuminate\Support\Str::limit(trim(html_entity_decode(strip_tags(languageName($item->description)), ENT_QUOTES, 'UTF-8')), 120);
                                @endphp
                                <article class="service-item">
                                    <a class="service-item__media" href="{{ $itemUrl }}" tabindex="-1">
                                        <img src="{{ url($itemImage) }}" alt="{{ languageName($item->name) }}" width="480" height="300" loading="lazy" decoding="async">
                                    </a>
                                    <div class="service-item__body">
                                        <h3 class="service-item__title"><a href="{{ $itemUrl }}">{{ languageName($item->name) }}</a></h3>
                                        @if ($itemDesc !== '')
                                            <p class="service-item__desc">{{ $itemDesc }}</p>
                                        @endif
                                        <a class="service-item__link" href="{{ $itemUrl }}">Xem chi tiết
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                                        </a>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                        @if ($list->hasPages())
                            <div class="event-pagination">
                                {{ $list->onEachSide(1)->links() }}
                            </div>
                        @endif
                    </section>
                @endif

                <section class="service-cta" aria-label="Liên hệ nhanh">
                    <div class="service-cta__text">
                        <h2>Bạn đang lên kế hoạch cho sự kiện?</h2>
                        <p>Gọi ngay hoặc để lại thông tin, chuyên viên sẽ liên hệ trong 15 phút (giờ hành chính).</p>
                    </div>
                    <div class="service-cta__actions">
                        @if ($hotline !== '')
                            <a class="service-btn service-btn--light" href="tel:{{ $hotlineTel }}">Gọi {{ $hotline }}</a>
                        @endif
                        <a class="service-btn service-btn--primary" href="#event-consult">Đăng ký tư vấn</a>
                    </div>
                </section>
            </div>

            <aside class="event-layout__aside" aria-label="Đăng ký tư vấn">
                <div class="event-sidebar">
                    @include('partials.sidebar-consult', [
                        'consultSource' => $serviceName,
                        'consultSelected' => old('service_pick', $serviceName),
                        'consultHidden' => ['service_cate_slug' => $cateService->slug],
                        'activeService' => $cateService->slug,
                    ])
                </div>
            </aside>
        </div>
    </div>
</section>

<nav class="service-mobile-bar" aria-label="Liên hệ nhanh">
    @if ($hotline !== '')
        <a href="tel:{{ $hotlineTel }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2"/></svg>
            Gọi ngay
        </a>
    @endif
    @if ($zaloUrl)
        <a href="{{ $zaloUrl }}" target="_blank" rel="noopener">
            <span class="service-mobile-bar__zalo" aria-hidden="true">Zalo</span>
            Chat Zalo
        </a>
    @endif
    <a class="is-primary" href="#event-consult">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 5h16v11H8l-4 4z"/></svg>
        Đăng ký tư vấn
    </a>
</nav>
@endsection
