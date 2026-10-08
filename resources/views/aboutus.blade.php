@extends('layouts.main.master')
@php
    $aboutTitle = $gioithieu ? (languageName($gioithieu->title) ?: 'Giới thiệu') : 'Giới thiệu';
    $aboutImages = $gioithieu ? json_decode((string) $gioithieu->image, true) : null;
    $aboutImage = is_array($aboutImages) ? ($aboutImages[0] ?? null) : ($gioithieu->image ?? null);
    $aboutImage = $aboutImage ?: '/frontend/images/bgbanner.jpg';
    $aboutDescription = $gioithieu ? trim((string) $gioithieu->description) : '';
    $aboutVideoUrl = trim((string) ($setting->fax ?? ''));
    preg_match('~(?:youtu\.be/|youtube(?:-nocookie)?\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/|live/|v/))([A-Za-z0-9_-]{11})~', $aboutVideoUrl, $aboutVideoMatch);
    $aboutVideoId = $aboutVideoMatch[1] ?? null;
    $aboutStats = [
        ['value' => '20', 'label' => 'Khinh khí cầu lớn'],
        ['value' => '60', 'label' => 'Khinh khí cầu nhỏ'],
        ['value' => '10', 'label' => 'Khinh khí cầu hơi'],
        ['value' => 'Top 2', 'label' => 'Đội bay lớn tại Châu Á'],
    ];
@endphp
@section('title')
    {{ $aboutTitle }} - {{ $setting->company }}
@endsection
@section('description')
    {{ \Illuminate\Support\Str::limit(trim(strip_tags(html_entity_decode($aboutDescription ?: (string) $setting->webname, ENT_QUOTES, 'UTF-8'))), 160) }}
@endsection
@section('image')
{{ url($aboutImage) }}
@endsection
@section('css')
<link rel="stylesheet" href="/frontend/css/about-page.css?v={{ filemtime(public_path('frontend/css/about-page.css')) }}">
@endsection
@section('content')
<div class="about-page">
    <div class="about-page__bg" aria-hidden="true">
        <span class="about-page__blob about-page__blob--blue"></span>
        <span class="about-page__blob about-page__blob--peach"></span>
        <span class="about-page__dots"></span>
        <img class="about-page__shape about-page__shape--l" src="/frontend/images/khicau2.png" alt="" width="200" height="200" loading="lazy" decoding="async">
        <img class="about-page__shape about-page__shape--r" src="/frontend/images/khicau4.png" alt="" width="200" height="200" loading="lazy" decoding="async">
    </div>

    <div class="about-page__inner">
        <nav class="about-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Trang chủ</a>
            <span aria-hidden="true">/</span>
            <span>{{ $aboutTitle }}</span>
        </nav>

        <section class="about-hero" aria-labelledby="about-title">
            <div class="about-hero__content">
                <span class="about-page__eyebrow">Về chúng tôi</span>
                <h1 class="about-hero__title" id="about-title">Vươn tầm <span class="is-accent">&amp; Bay xa</span></h1>
                @if ($aboutDescription !== '')
                    <div class="about-hero__desc">{!! $aboutDescription !!}</div>
                @endif
                <div class="about-hero__actions">
                    <a class="about-page__btn" href="{{ route('eventList') }}">
                        <span>Xem sự kiện</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </a>
                    <a class="about-page__btn about-page__btn--ghost" href="{{ route('lienHe') }}">Liên hệ tư vấn</a>
                </div>
            </div>

            <div class="about-hero__media">
                <span class="about-hero__dots" aria-hidden="true"></span>
                <div class="about-hero__frame">
                    <img src="{{ $aboutImage }}" alt="{{ $aboutTitle }}" width="1024" height="768" decoding="async">
                    @if ($aboutVideoId)
                        <a class="about-hero__play" href="{{ $aboutVideoUrl }}" data-video-popup="{{ $aboutVideoId }}" aria-label="Xem video giới thiệu">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8.5 5.6c0-1.1 1.2-1.8 2.2-1.2l8.6 5.4c.9.6.9 1.9 0 2.5l-8.6 5.4c-1 .6-2.2-.1-2.2-1.2z"/></svg>
                        </a>
                    @endif
                </div>
            </div>
        </section>

        <ul class="about-stats" aria-label="Đội bay">
            @foreach ($aboutStats as $stat)
                <li class="about-stats__item">
                    <strong>{{ $stat['value'] }}</strong>
                    <span>{{ $stat['label'] }}</span>
                </li>
            @endforeach
        </ul>

        @if ($gioithieu && trim(strip_tags((string) $gioithieu->content)) !== '')
            <section class="about-story" aria-labelledby="about-story-title">
                <header class="about-page__head">
                    <span class="about-page__eyebrow">Câu chuyện</span>
                    <h2 class="about-page__title" id="about-story-title">Hành trình <span class="is-accent">của chúng tôi</span></h2>
                </header>
                <div class="about-story__card">
                    <div class="about-story__content">{!! $gioithieu->content !!}</div>
                </div>
            </section>
        @endif

        @if ($ReviewCus->isNotEmpty())
            <section class="about-reviews" aria-labelledby="about-reviews-title">
                <header class="about-page__head">
                    <span class="about-page__eyebrow">Khách hàng</span>
                    <h2 class="about-page__title" id="about-reviews-title">Khách hàng <span class="is-accent">nói gì</span></h2>
                </header>
                <div class="about-reviews__grid">
                    @foreach ($ReviewCus as $review)
                        <figure class="about-review">
                            <svg class="about-review__quote" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M9.6 6C6.5 7.2 4.5 9.9 4.5 13.4V18h6v-6H7.6c.2-1.8 1.3-3.2 3.1-4zm9 0c-3.1 1.2-5.1 3.9-5.1 7.4V18h6v-6h-2.9c.2-1.8 1.3-3.2 3.1-4z"/></svg>
                            <blockquote>{{ trim(strip_tags(languageName($review->content))) }}</blockquote>
                            <figcaption>
                                @if ($review->avatar)
                                    <img src="{{ $review->avatar }}" alt="{{ languageName($review->name) }}" width="52" height="52" loading="lazy" decoding="async">
                                @endif
                                <span>
                                    <strong>{{ languageName($review->name) }}</strong>
                                    @if (languageName($review->position))
                                        <small>{{ languageName($review->position) }}</small>
                                    @endif
                                </span>
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
            </section>
        @endif

        @if ($partner->isNotEmpty())
            <section class="about-partners" aria-labelledby="about-partners-title">
                <header class="about-page__head">
                    <span class="about-page__eyebrow">Đồng hành</span>
                    <h2 class="about-page__title" id="about-partners-title">Đối tác <span class="is-accent">tin cậy</span></h2>
                </header>
                <ul class="about-partners__list">
                    @foreach ($partner as $item)
                        <li>
                            @if ($item->link)
                                <a href="{{ $item->link }}" target="_blank" rel="noopener"><img src="{{ $item->image }}" alt="{{ $item->name ?: 'Đối tác' }}" loading="lazy" decoding="async"></a>
                            @else
                                <img src="{{ $item->image }}" alt="{{ $item->name ?: 'Đối tác' }}" loading="lazy" decoding="async">
                            @endif
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif
    </div>
</div>
@endsection
