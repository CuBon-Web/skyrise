@extends('layouts.main.master')
@section('title')
    {{ $setting->company }}
@endsection
@section('description')
    {{ $setting->webname }}
@endsection
@section('image')
    @php
        $ogBanner = $banner->first();
        $ogImage = $ogBanner && $ogBanner->image ? url($ogBanner->image) : url($setting->logo ?? '');
    @endphp
    {{ $ogImage }}
@endsection
@section('css')
@endsection
@section('js')
@endsection
@section('content')
<div id="Content" role="main">
   <div class="content_wrapper clearfix">

       <div class="sections_group">

           <div class="entry-content" itemprop="mainContentOfPage">

               <div class="mfn-builder-content mfn-default-content-buider"></div>
               <div class="section the_content has_content">
                   <div class="section_wrapper">
                       <div class="the_content_wrapper is-elementor">
                           <div data-elementor-type="wp-page" data-elementor-id="10"
                               class="elementor elementor-10">
                               @if ($banner->isNotEmpty())
                               <section class="hero-banner" data-hero-banner data-interval="6000" aria-label="Banner Khinh Khí Cầu">
                                   <div class="hero-banner__media" aria-hidden="true">
                                       @foreach ($banner as $item)
                                           <div class="hero-banner__bg {{ $loop->first ? 'is-active' : '' }}"
                                               style="--hero-bg: url('{{ url($item->image) }}');@if ($item->image_mobile) --hero-bg-mobile: url('{{ url($item->image_mobile) }}');@endif"></div>
                                       @endforeach
                                   </div>

                                   <div class="hero-banner__slides">
                                       @foreach ($banner as $item)
                                           @php
                                             $eyebrow = trim(html_entity_decode(strip_tags((string) $item->description), ENT_QUOTES, 'UTF-8'));
                                           @endphp
                                           <div class="hero-banner__slide {{ $loop->first ? 'is-active' : '' }}" @unless ($loop->first) aria-hidden="true" @endunless>
                                               
                                                   <p class="hero-banner__eyebrow">Welcome to SKYRISE</p>
                                              
                                                   <h2 class="hero-banner__title">
                                                       {!!$item->title!!}
                                                   </h2>
                                                   @if ($eyebrow !== '')
                                                       <div class="hero-banner__desc">{!! $item->description !!}</div>
                                                   @endif
                                               @if ($item->link)
                                                   <a class="hero-banner__cta" href="{{ $item->link }}">
                                                       <span class="hero-banner__cta-label">Xem chi tiết</span>
                                                       <span class="hero-banner__cta-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
                                                   </a>
                                               @endif
                                           </div>
                                       @endforeach
                                   </div>

                                   @if ($banner->count() > 1)
                                   <div class="hero-banner__pager">
                                       @foreach ($banner as $item)
                                           <button type="button" class="hero-banner__dot {{ $loop->first ? 'is-active' : '' }}" aria-label="Slide {{ $loop->iteration }}">{{ sprintf('%02d', $loop->iteration) }}</button>
                                       @endforeach
                                       <span class="hero-banner__progress"><span></span></span>
                                   </div>

                                   <div class="hero-banner__nav">
                                       <button type="button" class="hero-banner__arrow" data-hero-prev aria-label="Slide trước"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M15 6l-6 6 6 6"/></svg></button>
                                       <button type="button" class="hero-banner__arrow" data-hero-next aria-label="Slide tiếp"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M9 6l6 6-6 6"/></svg></button>
                                   </div>
                                   @endif

                                   <div class="hero-banner__wave" aria-hidden="true">
                                       <img src="/frontend/images/shapebanner.png" alt="" width="1000" height="333" decoding="async">
                                   </div>
                               </section>
                               @endif
                               <section class="about-intro" id="artists">
                                   <div class="about-intro__shapes" aria-hidden="true">
                                       <img class="about-intro__shape about-intro__shape--clouds" src="/frontend/images/dammay-clean.png" alt="" width="900" height="300" loading="lazy" decoding="async">
                                       <img class="about-intro__shape about-intro__shape--balloon-left" src="/frontend/images/khicau1.png" alt="" width="200" height="200" loading="lazy" decoding="async">
                                       <img class="about-intro__shape about-intro__shape--balloon-left-sm" src="/frontend/images/khicau2.png" alt="" width="200" height="200" loading="lazy" decoding="async">
                                       <img class="about-intro__shape about-intro__shape--balloon-right" src="/frontend/images/khicau4.png" alt="" width="200" height="200" loading="lazy" decoding="async">
                                       <img class="about-intro__shape about-intro__shape--balloon-right-sm" src="/frontend/images/khicau3.png" alt="" width="200" height="200" loading="lazy" decoding="async">
                                       <svg class="about-intro__trail about-intro__trail--left" viewBox="0 0 320 140" fill="none">
                                           <path d="M2,40 C60,8 110,70 150,52 C190,34 210,70 250,96 C280,116 300,124 318,138" />
                                       </svg>
                                       <svg class="about-intro__trail about-intro__trail--right" viewBox="0 0 260 160" fill="none">
                                           <path d="M2,150 C40,120 70,140 110,112 C150,84 170,40 210,30 C230,25 245,18 258,4" />
                                       </svg>
                                   </div>

                                   <div class="about-intro__inner">
                                       <div class="about-intro__content">
                                           <h1 class="about-intro__title">Về <span class="is-accent">Skyrise</span></h1>
                                           {!!$gioithieu->description!!}
                                           <a class="about-intro__btn" href="{{route('aboutUs')}}">
                                               <span>Khám phá khinh khí cầu</span>
                                               <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                                           </a>
                                       </div>

                                       <div class="about-intro__media">
                                           <span class="about-intro__dots" aria-hidden="true"></span>
                                           <div class="about-intro__frame">
                                               <img decoding="async" loading="lazy" width="1024" height="768"
                                                      src="{{json_decode($gioithieu->image)[0]}}"
                                                      srcset="{{json_decode($gioithieu->image)[0]}} 768w, {{json_decode($gioithieu->image)[0]}} 1024w, {{json_decode($gioithieu->image)[0]}} 1536w"
                                                   sizes="(max-width: 959px) 92vw, 560px"
                                                   alt="{{$gioithieu->title}}">
                                           </div>
                                       </div>
                                   </div>

                                   <div class="about-intro__video">
                                       <svg class="about-intro__play-text" viewBox="0 0 760 210" aria-hidden="true">
                                           <defs>
                                               <linearGradient id="aboutPlayStroke" x1="0" x2="1" y1="0" y2="0">
                                                   <stop offset="0" stop-color="#ffc24a" />
                                                   <stop offset=".5" stop-color="#ff9a3c" />
                                                   <stop offset="1" stop-color="#ff6a45" />
                                               </linearGradient>
                                           </defs>
                                           <text x="380" y="178" text-anchor="middle">PLAY</text>
                                       </svg>
                                       @php
                                           $introVideoUrl = trim((string) ($setting->fax ?? ''));
                                           preg_match('~(?:youtu\.be/|youtube(?:-nocookie)?\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/|live/|v/))([A-Za-z0-9_-]{11})~', $introVideoUrl, $introVideoMatch);
                                           $introVideoId = $introVideoMatch[1] ?? null;
                                       @endphp
                                       @if ($introVideoId)
                                       <a class="about-intro__play" aria-label="Xem video giới thiệu"
                                           href="{{ $introVideoUrl }}" data-video-popup="{{ $introVideoId }}">
                                           <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8.5 5.6c0-1.1 1.2-1.8 2.2-1.2l8.6 5.4c.9.6.9 1.9 0 2.5l-8.6 5.4c-1 .6-2.2-.1-2.2-1.2z" /></svg>
                                       </a>
                                       @endif
                                   </div>
                               </section>
                               <section
                                   class="elementor-section elementor-top-section elementor-element elementor-element-78db43d elementor-section-stretched elementor-section-boxed elementor-section-height-default elementor-section-height-default"
                                   data-id="78db43d" data-element_type="section" id="about"
                                   data-settings="{&quot;stretch_section&quot;:&quot;section-stretched&quot;}">
                                   <div class="elementor-container elementor-column-gap-wider">
                                       <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-425c787"
                                           data-id="425c787" data-element_type="column">
                                           <div class="elementor-widget-wrap elementor-element-populated">
                                               <div class="elementor-element elementor-element-7439b49 elementor-widget elementor-widget-text-editor"
                                                   data-id="7439b49" data-element_type="widget"
                                                   data-widget_type="text-editor.default">
                                                   <div class="elementor-widget-container">
                                                       <h6>ĐỘI BAY HIỆN ĐẠI</h6>
                                                       <hr class="no_line" />
                                                       <p><strong>Với quá trình phát triển lâu dài và đồng hành
                                                               cùng các sự kiện lớn tại Việt Nam, hiện tại chúng tôi
                                                               có tổng số
                                                               <span style="color: #ff0000;">20 khinh khí cầu bay
                                                                   (gồm bay chở 6 người và bay chở 12 người), 60 khinh
                                                                   khí cầu trang trí &amp; 50 khinh khí cầu bay bằng
                                                                   khí heli</span>. Skyrise tiếp tục phát triển và gia
                                                               tăng số lượng khinh khí cầu cũng như các khinh khí cầu
                                                               với hình thù đặc sắc theo yêu cầu phong phú của khách
                                                               hàng.</strong></p>
                                                   </div>
                                               </div>
                                               <div class="elementor-element elementor-element-978ff19 elementor-widget elementor-widget-spacer"
                                                   data-id="978ff19" data-element_type="widget"
                                                   data-widget_type="spacer.default">
                                                   <div class="elementor-widget-container">
                                                       <style>
                                                           /*! elementor - v3.11.5 - 14-03-2023 */
                                                           .elementor-column .elementor-spacer-inner {
                                                               height: var(--spacer-size)
                                                           }

                                                           .e-con {
                                                               --container-widget-width: 100%
                                                           }

                                                           .e-con-inner>.elementor-widget-spacer,
                                                           .e-con>.elementor-widget-spacer {
                                                               width: var(--container-widget-width, var(--spacer-size));
                                                               --align-self: var(--container-widget-align-self, initial);
                                                               --flex-shrink: 0
                                                           }

                                                           .e-con-inner>.elementor-widget-spacer>.elementor-widget-container,
                                                           .e-con-inner>.elementor-widget-spacer>.elementor-widget-container>.elementor-spacer,
                                                           .e-con>.elementor-widget-spacer>.elementor-widget-container,
                                                           .e-con>.elementor-widget-spacer>.elementor-widget-container>.elementor-spacer {
                                                               height: 100%
                                                           }

                                                           .e-con-inner>.elementor-widget-spacer>.elementor-widget-container>.elementor-spacer>.elementor-spacer-inner,
                                                           .e-con>.elementor-widget-spacer>.elementor-widget-container>.elementor-spacer>.elementor-spacer-inner {
                                                               height: var(--container-widget-height, var(--spacer-size))
                                                           }
                                                       </style>
                                                       <div class="elementor-spacer">
                                                           <div class="elementor-spacer-inner"></div>
                                                       </div>
                                                   </div>
                                               </div>
                                               <div class="elementor-element elementor-element-7f3afad elementor-align-center scroll elementor-widget elementor-widget-button"
                                                   data-id="7f3afad" data-element_type="widget"
                                                   data-widget_type="button.default">
                                                   <div class="elementor-widget-container">
                                                       <div class="elementor-button-wrapper">
                                                           <a href="{{ route('eventList') }}"
                                                               class="elementor-button-link elementor-button elementor-size-sm"
                                                               role="button">
                                                               <span class="elementor-button-content-wrapper">
                                                                   <span class="elementor-button-text">Xem sự
                                                                       kiện</span>
                                                               </span>
                                                           </a>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </section>
                               <section class="services" id="attractions">
                                   <div class="services__bg" aria-hidden="true">
                                       <span class="services__blob services__blob--mint"></span>
                                       <span class="services__blob services__blob--peach"></span>
                                       <span class="services__blob services__blob--blue"></span>
                                       <span class="services__dots services__dots--tr"></span>
                                       <span class="services__dots services__dots--bl"></span>
                                       <img class="services__shape services__shape--balloon-tr" src="/frontend/images/khicau3.png" alt="" width="200" height="200" loading="lazy" decoding="async">
                                       <img class="services__shape services__shape--balloon-l" src="/frontend/images/khicau1.png" alt="" width="200" height="200" loading="lazy" decoding="async">
                                       <img class="services__shape services__shape--balloon-r" src="/frontend/images/khicau4.png" alt="" width="200" height="200" loading="lazy" decoding="async">
                                   </div>

                                   <div class="services__inner">
                                       <header class="services__head">
                                           <h2 class="services__title">Dịch vụ <span class="is-accent">Khinh Khí Cầu</span></h2>
                                           <p class="services__lead">Các hoạt động liên quan trực tiếp đến khinh khí cầu thường được triển khai chủ lực vào buổi sáng, phụ thuộc thời tiết và trong 04 giờ/ngày.</p>
                                       </header>

                                       @php
                                           $serviceVariants = [
                                               [
                                                   'class' => 'services__card--event',
                                                   'balloon' => '/frontend/images/khicau2.png',
                                                   'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3.5" y="5" width="17" height="15.5" rx="2.5"/><path d="M3.5 10h17M8 3v4M16 3v4"/><path d="M8.5 14.5l2 2 4-4"/></svg>',
                                               ],
                                               [
                                                   'class' => 'services__card--festival',
                                                   'balloon' => '/frontend/images/khicau4.png',
                                                   'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2.8c-4 0-7 3-7 6.9 0 3.4 2.6 6.4 5.2 7.6h3.6c2.6-1.2 5.2-4.2 5.2-7.6 0-3.9-3-6.9-7-6.9z"/><path d="M12 2.8c-1.8 1.6-2.7 4.2-2.7 6.9s.9 5.8 2.7 7.6c1.8-1.8 2.7-4.9 2.7-7.6s-.9-5.3-2.7-6.9z"/><path d="M10.2 17.3l.4 2.2M13.8 17.3l-.4 2.2"/><rect x="10" y="19.5" width="4" height="2" rx=".6"/></svg>',
                                               ],
                                               [
                                                   'class' => 'services__card--sponsor',
                                                   'balloon' => '/frontend/images/khicau1.png',
                                                   'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3.5" y="8" width="17" height="4.5" rx="1.2"/><path d="M5 12.5v7.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-7.5M12 8v13"/><path d="M12 8c-1.6-3.6-5.6-4-5.6-1.6C6.4 8 9.6 8 12 8zM12 8c1.6-3.6 5.6-4 5.6-1.6C17.6 8 14.4 8 12 8z"/></svg>',
                                               ],
                                           ];
                                           $serviceFirstImage = function ($raw) {
                                               $value = $raw;
                                               for ($depth = 0; $depth < 10; $depth++) {
                                                   if (is_array($value)) {
                                                       $value = reset($value);
                                                       continue;
                                                   }
                                                   if (!is_string($value)) {
                                                       return null;
                                                   }
                                                   $decoded = json_decode($value, true);
                                                   if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded) && !is_string($decoded)) {
                                                       break;
                                                   }
                                                   $value = $decoded;
                                               }
                                               return is_string($value) && trim($value) !== '' ? trim($value) : null;
                                           };
                                       @endphp
                                       <div class="services__grid">
                                           @foreach ($servicehome as $service)
                                               @php
                                                   $variant = $serviceVariants[$loop->index % count($serviceVariants)];
                                                   $serviceImage = $serviceFirstImage($service->image) ?: '/frontend/images/bgbanner.jpg';
                                                   $serviceText = trim(html_entity_decode(strip_tags((string) $service->description), ENT_QUOTES, 'UTF-8'));
                                                   $serviceUrl = route('serviceList', ['slug' => $service->slug]);
                                                   $isReverse = $loop->index % 2 === 1;
                                               @endphp

                                               @if ($isReverse)
                                                   <figure class="services__photo services__photo--reverse" style="--sv-order: {{ $loop->index * 2 + 1 }};">
                                                       <img src="{{ $serviceImage }}" alt="{{ $service->name }}" loading="lazy" decoding="async">
                                                   </figure>
                                               @endif
                                               <article class="services__card {{ $variant['class'] }}" style="--sv-order: {{ $loop->index * 2 }};">
                                                   <div class="services__body">
                                                       <span class="services__icon" aria-hidden="true">{!! $variant['icon'] !!}</span>
                                                       <h3 class="services__name">{{ $service->name }}</h3>
                                                       @if ($serviceText !== '')
                                                           <p class="services__text">{{ $serviceText }}</p>
                                                       @endif
                                                       <a href="{{ $serviceUrl }}" class="services__btn">Xem chi tiết
                                                           <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                                                       </a>
                                                   </div>
                                                   <div class="services__deco" aria-hidden="true">
                                                       <img class="services__deco-balloon" src="{{ $variant['balloon'] }}" alt="" width="200" height="200" loading="lazy" decoding="async">
                                                   </div>
                                               </article>
                                               @unless ($isReverse)
                                                   <figure class="services__photo" style="--sv-order: {{ $loop->index * 2 + 1 }};">
                                                       <img src="{{ $serviceImage }}" alt="{{ $service->name }}" loading="lazy" decoding="async">
                                                   </figure>
                                               @endunless
                                           @endforeach
                                       </div>
                                   </div>
                               </section>
                               @if ($homeEvents->isNotEmpty())
                               <section class="events" id="events" aria-labelledby="events-title">
                                   <div class="events__bg" aria-hidden="true">
                                       <span class="events__blob events__blob--blue"></span>
                                       <span class="events__blob events__blob--peach"></span>
                                       <span class="events__dots"></span>
                                       <img class="events__shape events__shape--balloon-l" src="/frontend/images/khicau2.png" alt="" width="200" height="200" loading="lazy" decoding="async">
                                       <img class="events__shape events__shape--balloon-r" src="/frontend/images/khicau3.png" alt="" width="200" height="200" loading="lazy" decoding="async">
                                   </div>

                                   <div class="events__inner">
                                       <header class="events__head">
                                           <div class="events__intro">
                                               <span class="events__eyebrow">Lịch bay</span>
                                               <h2 class="events__title" id="events-title">Sự kiện <span class="is-accent">sắp diễn ra</span></h2>
                                               <p class="events__lead">Từ đầu năm 2022 đến nay, hoạt động khinh khí cầu đang được đẩy mạnh trở thành dấu ấn trong việc quảng bá du lịch cho các địa phương: <strong>Tp. Thủ Đức, Hội An, Đà Nẵng, Hà Nội, Kon Tum</strong> và 15 tỉnh thành tổ chức SEA GAMES 31.</p>
                                           </div>
                                           <div class="events__nav">
                                               <button type="button" class="events__arrow" data-slider-prev aria-label="Sự kiện trước">
                                                   <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5M11 6l-6 6 6 6"/></svg>
                                               </button>
                                               <button type="button" class="events__arrow" data-slider-next aria-label="Sự kiện tiếp theo">
                                                   <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                                               </button>
                                           </div>
                                       </header>

                                       <div class="events__slider" data-slider data-dot-class="events__dot">
                                           <div class="events__track" data-slider-track tabindex="0" aria-label="Danh sách sự kiện">
                                               @foreach ($homeEvents as $event)
                                                   @include('event._card', ['event' => $event])
                                               @endforeach
                                           </div>
                                           <div class="events__dots-nav" data-slider-dots role="tablist" aria-label="Chọn trang sự kiện"></div>
                                       </div>
                                       <div class="events__more">
                                           <a class="events__more-link" href="{{ route('eventList') }}">Xem tất cả sự kiện
                                               <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                                           </a>
                                       </div>
                                   </div>
                               </section>
                               @endif
                               @php
                                   $galleryImages = collect($gallery ?? [])
                                       ->map(function ($item) {
                                           return $item->image ?: ($item->after ?: $item->before);
                                       })
                                       ->filter()
                                       ->values();
                                   $galleryRows = [];
                                   if ($galleryImages->isNotEmpty()) {
                                       $galleryFill = function ($images) {
                                           $set = $images;
                                           while ($set->count() < 8) {
                                               $set = $set->concat($images);
                                           }
                                           return $set->values();
                                       };
                                       $galleryRows = [
                                           ['class' => '', 'images' => $galleryFill($galleryImages)],
                                           ['class' => 'gallery-marquee__row--reverse', 'images' => $galleryFill($galleryImages->reverse()->values())],
                                       ];
                                   }
                               @endphp
                               @if ($galleryRows)
                               <section class="gallery-marquee" id="gallery" aria-label="Thư viện ảnh khinh khí cầu">
                                   @foreach ($galleryRows as $row)
                                       <div class="gallery-marquee__row {{ $row['class'] }}">
                                           <div class="gallery-marquee__track">
                                               @foreach ([false, true] as $isClone)
                                                   @foreach ($row['images'] as $src)
                                                       <a class="gallery-marquee__item" href="{{ url($src) }}" data-elementor-open-lightbox="no" data-gallery-item @if ($isClone) aria-hidden="true" tabindex="-1" @endif>
                                                           <img src="{{ url($src) }}" width="768" height="576" alt="{{ $isClone ? '' : 'Thư viện ảnh khinh khí cầu ' . ($loop->iteration) }}" loading="lazy" decoding="async">
                                                       </a>
                                                   @endforeach
                                               @endforeach
                                           </div>
                                       </div>
                                   @endforeach
                               </section>
                               @endif
                               @if ($hotnews->isNotEmpty())
                               <section class="news" id="tickets" aria-labelledby="news-title">
                                   <div class="news__bg" aria-hidden="true">
                                       <span class="news__blob news__blob--mint"></span>
                                       <span class="news__blob news__blob--blue"></span>
                                       <span class="news__dots"></span>
                                       <img class="news__shape news__shape--balloon-l" src="/frontend/images/khicau4.png" alt="" width="200" height="200" loading="lazy" decoding="async">
                                       <img class="news__shape news__shape--balloon-r" src="/frontend/images/khicau1.png" alt="" width="200" height="200" loading="lazy" decoding="async">
                                   </div>

                                   <div class="news__inner">
                                       <header class="news__head">
                                           <div class="news__intro">
                                               <span class="news__eyebrow">Tin tức</span>
                                               <h2 class="news__title" id="news-title">Tin tức <span class="is-accent">mới nhất</span></h2>
                                               <p class="news__lead">Các tin tức mới nhất về Khinh Khí Cầu: sự kiện, cẩm nang bay và hoạt động của đội bay trên khắp Việt Nam.</p>
                                           </div>
                                           <div class="news__nav">
                                               <button type="button" class="news__arrow" data-slider-prev aria-label="Tin trước">
                                                   <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5M11 6l-6 6 6 6"/></svg>
                                               </button>
                                               <button type="button" class="news__arrow" data-slider-next aria-label="Tin tiếp theo">
                                                   <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                                               </button>
                                           </div>
                                       </header>

                                       <div class="news__slider" data-slider data-dot-class="news__dot">
                                           <div class="news__track" data-slider-track tabindex="0" aria-label="Danh sách tin tức">
                                               @foreach ($hotnews as $news)
                                                   @php
                                                       $newsTitle = languageName($news->title);
                                                       $newsExcerpt = \Illuminate\Support\Str::limit(trim(html_entity_decode(strip_tags(languageName($news->description)), ENT_QUOTES, 'UTF-8')), 160);
                                                       $newsCategory = $news->cate ? languageName($news->cate->name) : '';
                                                       $newsUrl = route('detailBlog', ['slug' => $news->slug]);
                                                   @endphp
                                                   <article class="news-card">
                                                       <a class="news-card__media" href="{{ $newsUrl }}" tabindex="-1">
                                                           <img src="{{ $news->image ? url($news->image) : '/frontend/images/bgbanner.jpg' }}" alt="{{ $newsTitle }}" loading="lazy" decoding="async">
                                                           @if ($newsCategory !== '')
                                                               <span class="news-card__cat">{{ $newsCategory }}</span>
                                                           @endif
                                                       </a>
                                                       <div class="news-card__body">
                                                           <ul class="news-card__meta">
                                                               <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3.5" y="5" width="17" height="15.5" rx="2.5"/><path d="M3.5 10h17M8 3v4M16 3v4"/></svg>{{ optional($news->created_at)->format('d/m/Y') }}</li>
                                                               <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="8.5"/><path d="M12 7.5V12l3 2"/></svg>{{ $news->reading_minutes }} phút đọc</li>
                                                           </ul>
                                                           <h3 class="news-card__title"><a href="{{ $newsUrl }}">{{ $newsTitle }}</a></h3>
                                                           @if ($newsExcerpt !== '')
                                                               <p class="news-card__excerpt">{{ $newsExcerpt }}</p>
                                                           @endif
                                                           <a class="news-card__link" href="{{ $newsUrl }}">Đọc tiếp
                                                               <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                                                           </a>
                                                       </div>
                                                   </article>
                                               @endforeach
                                           </div>
                                           <div class="news__dots-nav" data-slider-dots role="tablist" aria-label="Chọn trang tin tức"></div>
                                       </div>

                                       <div class="news__more">
                                           <a class="news__btn" href="{{ route('allListBlog') }}">Xem tất cả tin tức
                                               <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                                           </a>
                                       </div>
                                   </div>
                               </section>
                               @endif
                           </div>
                       </div>
                   </div>
               </div>

           </div>

       </div>

   </div>
</div>
@endsection
