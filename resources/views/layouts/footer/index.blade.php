@php
    $footerUrl = function ($link) {
        $link = trim((string) $link);
        if ($link === '') {
            return null;
        }
        return preg_match('#^(https?:)?//#i', $link) ? $link : 'https://' . ltrim($link, '/');
    };
    $footerTel = function ($phone) {
        return preg_replace('/[^\d+]/', '', (string) $phone);
    };
    $footerPhones = collect([$setting->phone1 ?? null, $setting->phone2 ?? null])->filter(function ($p) {
        return trim((string) $p) !== '';
    })->values();
    $footerHotline = $footerPhones->first();
    $footerLogo = ($setting->logo_footer ?? null) ?: ($setting->logo ?? null);
    $footerCompany = trim((string) ($setting->company ?? '')) ?: 'Khinh Khí Cầu';
    $footerAbout = \Illuminate\Support\Str::limit(trim(html_entity_decode(strip_tags((string) ($setting->webname ?? '')), ENT_QUOTES, 'UTF-8')), 220);
    $footerAddresses = collect([$setting->address1 ?? null, $setting->address2 ?? null])->filter(function ($a) {
        return trim((string) $a) !== '';
    })->values();
    $footerZalo = $footerHotline ? 'https://zalo.me/' . preg_replace('/\D/', '', $footerHotline) : null;
    $footerSocials = array_filter([
        'Facebook' => [
            'url' => $footerUrl($setting->facebook ?? null),
            'icon' => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M13.5 21v-7.5h2.6l.4-3h-3V8.6c0-.9.3-1.5 1.6-1.5h1.6V4.4c-.3 0-1.2-.1-2.3-.1-2.3 0-3.9 1.4-3.9 4v2.2H8v3h2.5V21h3z"/></svg>',
        ],
        'YouTube' => [
            'url' => $footerUrl($setting->fax ?? null),
            'icon' => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M21.6 7.2a2.5 2.5 0 0 0-1.8-1.8C18.2 5 12 5 12 5s-6.2 0-7.8.4A2.5 2.5 0 0 0 2.4 7.2 26 26 0 0 0 2 12a26 26 0 0 0 .4 4.8 2.5 2.5 0 0 0 1.8 1.8C5.8 19 12 19 12 19s6.2 0 7.8-.4a2.5 2.5 0 0 0 1.8-1.8A26 26 0 0 0 22 12a26 26 0 0 0-.4-4.8zM10 15V9l5.2 3L10 15z"/></svg>',
        ],
        'TikTok' => [
            'url' => $footerUrl($setting->google ?? null),
            'icon' => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M16.6 5.8A4.3 4.3 0 0 1 15.5 3h-3.1v12.4a2.6 2.6 0 1 1-2.6-2.6c.3 0 .5 0 .8.1V9.7a5.7 5.7 0 1 0 4.9 5.7V9.1a7.3 7.3 0 0 0 4.3 1.4V7.4a4.3 4.3 0 0 1-3.2-1.6z"/></svg>',
        ],
        'Instagram' => [
            'url' => $footerUrl($setting->fbPixel ?? null),
            'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r=".6" fill="currentColor"/></svg>',
        ],
        'Zalo' => [
            'url' => $footerZalo,
            'icon' => '<span>Zalo</span>',
        ],
    ], function ($item) {
        return !empty($item['url']);
    });
    $footerHost = parse_url(url('/'), PHP_URL_HOST);
@endphp
<footer class="site-footer" id="site-footer">
   <div class="site-footer__bg" aria-hidden="true">
       <span class="site-footer__blob site-footer__blob--blue"></span>
       <span class="site-footer__blob site-footer__blob--peach"></span>
       <span class="site-footer__dots"></span>
       <img class="site-footer__shape site-footer__shape--balloon-l" src="/frontend/images/khicau2.png" alt="" width="200" height="200" loading="lazy" decoding="async">
       <img class="site-footer__shape site-footer__shape--balloon-r" src="/frontend/images/khicau4.png" alt="" width="200" height="200" loading="lazy" decoding="async">
   </div>

   <div class="site-footer__inner">
       <div class="site-footer__cta">
           <div class="site-footer__cta-text">
               <h2 class="site-footer__cta-title">Sẵn sàng <span class="is-accent">bay cao</span> cùng chúng tôi?</h2>
               <p>Liên hệ ngay để được tư vấn tổ chức sự kiện, lễ hội và quảng cáo bằng khinh khí cầu.</p>
           </div>
           @if ($footerHotline)
           <a class="site-footer__cta-btn" href="tel:{{ $footerTel($footerHotline) }}">
               <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2"/></svg>
               Gọi {{ $footerHotline }}
           </a>
           @else
           <a class="site-footer__cta-btn" href="{{ route('lienHe') }}">Liên hệ ngay</a>
           @endif
       </div>

       <div class="site-footer__grid">
           <div class="site-footer__brand">
               <a class="site-footer__logo" href="{{ route('home') }}" aria-label="{{ $footerCompany }} – Trang chủ">
                   @if ($footerLogo)
                   <img src="{{ $footerLogo }}" alt="{{ $footerCompany }}" width="400" height="140" loading="lazy" decoding="async">
                   @else
                   <strong>{{ $footerCompany }}</strong>
                   @endif
               </a>
               @if ($footerAbout !== '')
               <p class="site-footer__about">{{ $footerAbout }}</p>
               @endif
               @if (count($footerSocials))
               <ul class="site-footer__social" aria-label="Mạng xã hội">
                   @foreach ($footerSocials as $label => $social)
                   <li><a href="{{ $social['url'] }}" target="_blank" rel="noopener" aria-label="{{ $label }}">{!! $social['icon'] !!}</a></li>
                   @endforeach
               </ul>
               @endif
           </div>

           <nav class="site-footer__col" aria-label="Liên kết nhanh">
               <h3 class="site-footer__heading">Liên kết</h3>
               <ul class="site-footer__links">
                   <li><a href="{{ route('home') }}">Trang chủ</a></li>
                   <li><a href="{{ route('aboutUs') }}">Giới thiệu</a></li>
                   <li><a href="{{ route('eventList') }}">Sự kiện</a></li>
                   @foreach ($blogCate as $cate)
                   <li><a href="{{ route('listCateBlog', ['slug' => $cate->slug]) }}">{{ languageName($cate->name) }}</a></li>
                   @endforeach
                   <li><a href="{{ route('lienHe') }}">Liên hệ</a></li>
               </ul>
           </nav>

           <nav class="site-footer__col" aria-label="Dịch vụ">
               <h3 class="site-footer__heading">Dịch vụ</h3>
               <ul class="site-footer__links">
                   @foreach ($servicehome->take(5) as $service)
                   <li><a href="{{ route('serviceList', ['slug' => $service->slug]) }}">{{ languageName($service->name) }}</a></li>
                   @endforeach
                   <li><a href="{{ route('eventList') }}">Lịch bay sắp tới</a></li>
                   <li><a href="{{ route('home') }}#gallery">Thư viện ảnh</a></li>
               </ul>
           </nav>

           <div class="site-footer__col">
               <h3 class="site-footer__heading">Liên hệ</h3>
               <ul class="site-footer__contact">
                   @if ($footerPhones->isNotEmpty())
                   <li>
                       <span class="site-footer__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2"/></svg></span>
                       <span><small>Hotline</small>@foreach ($footerPhones as $phone)<a href="tel:{{ $footerTel($phone) }}">{{ $phone }}</a>@endforeach</span>
                   </li>
                   @endif
                   @if (!empty($setting->email))
                   <li>
                       <span class="site-footer__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg></span>
                       <span><small>Email</small><a href="mailto:{{ $setting->email }}">{{ $setting->email }}</a></span>
                   </li>
                   @endif
                   @foreach ($footerAddresses as $address)
                   <li>
                       <span class="site-footer__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s-7-6.2-7-11.5a7 7 0 0 1 14 0C19 14.8 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.5"/></svg></span>
                       <span><small>{{ $loop->first ? 'Văn phòng' : 'Địa chỉ' }}</small>{{ $address }}</span>
                   </li>
                   @endforeach
                   <li>
                       <span class="site-footer__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a14 14 0 0 1 0 18M12 3a14 14 0 0 0 0 18"/></svg></span>
                       <span><small>Website</small><a href="{{ route('home') }}">{{ $footerHost }}</a></span>
                   </li>
               </ul>
           </div>
       </div>

       <p class="site-footer__member">
           <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3l7 3v5c0 4.5-3 8.3-7 10-4-1.7-7-5.5-7-10V6l7-3z"/><path d="M9 12l2 2 4-4"/></svg>
           Thành viên Liên đoàn Thể thao Hàng không Việt Nam &amp; Balloon Federation of America
       </p>
   </div>

   <div class="site-footer__bottom">
       <div class="site-footer__bottom-inner">
           <p>© {{ date('Y') }} <strong>{{ $footerCompany }}</strong>. Bảo lưu mọi quyền.</p>
           <a class="site-footer__top" href="#Wrapper" aria-label="Lên đầu trang">
               Lên đầu trang
               <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 19V5M6 11l6-6 6 6"/></svg>
           </a>
       </div>
   </div>
</footer>
