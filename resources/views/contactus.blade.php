@extends('layouts.main.master')
@section('title')
Liên hệ - {{ $setting->company }}
@endsection
@section('description')
Liên hệ tư vấn dịch vụ bay khinh khí cầu, tổ chức sự kiện và lễ hội.
@endsection
@section('image')
{{ url($setting->logo ?? '') }}
@endsection
@section('css')
<link rel="stylesheet" href="/frontend/css/event-page.css?v={{ filemtime(public_path('frontend/css/event-page.css')) }}">
<link rel="stylesheet" href="/frontend/css/contact-page.css?v={{ filemtime(public_path('frontend/css/contact-page.css')) }}">
@endsection
@section('content')
@php
    $contactPhone1 = trim((string) ($setting->phone1 ?? ''));
    $contactPhone2 = trim((string) ($setting->phone2 ?? ''));
    $contactPhone1Digits = preg_replace('/[^0-9+]/', '', $contactPhone1);
    $contactPhone2Digits = preg_replace('/[^0-9+]/', '', $contactPhone2);
    $contactEmail = trim((string) ($setting->email ?? ''));
    $contactAddressMain = trim((string) ($setting->address2 ?? ''));
    $contactAddressOffice = trim((string) ($setting->address1 ?? ''));
    $contactAddress = $contactAddressMain !== '' ? $contactAddressMain : $contactAddressOffice;
    $contactZalo = $contactPhone1 !== '' ? 'https://zalo.me/' . preg_replace('/\D/', '', $contactPhone1) : null;
    $contactMapUrl = $contactAddress !== '' ? 'https://www.google.com/maps/search/?api=1&query=' . urlencode($contactAddress) : null;
    $socialUrl = function ($link) {
        $link = trim((string) $link);
        if ($link === '') {
            return null;
        }
        return preg_match('#^(https?:)?//#i', $link) ? $link : 'https://' . ltrim($link, '/');
    };
    $contactSocials = array_filter([
        'Facebook' => $socialUrl($setting->facebook ?? null),
        'TikTok' => $socialUrl($setting->google ?? null),
        'Instagram' => $socialUrl($setting->fbPixel ?? null),
        'YouTube' => $socialUrl($setting->fax ?? null),
    ]);
@endphp
<section class="events events--page contact-page" aria-labelledby="contact-title">
    <div class="events__bg" aria-hidden="true">
        <span class="events__blob events__blob--blue"></span>
        <span class="events__blob events__blob--peach"></span>
        <span class="events__dots"></span>
    </div>

    <div class="events__inner contact-page__inner">
        <nav class="event-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Trang chủ</a>
            <span aria-hidden="true">/</span>
            <span>Liên hệ</span>
        </nav>

        <header class="events__head">
            <div class="events__intro">
                <span class="events__eyebrow">Liên hệ</span>
                <h1 class="events__title" id="contact-title">Kết nối <span class="is-accent">với chúng tôi</span></h1>
                <p class="events__lead">Tư vấn miễn phí về bay khinh khí cầu, tổ chức sự kiện, lễ hội và quảng cáo. Chọn cách liên hệ thuận tiện nhất với bạn.</p>
            </div>
        </header>

        <ul class="contact-quick">
            @if ($contactPhone1 !== '')
                <li>
                    <a class="contact-quick__item" href="tel:{{ $contactPhone1Digits }}">
                        <span class="contact-quick__icon contact-quick__icon--orange"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2"/></svg></span>
                        <span><small>Hotline</small><strong>{{ $contactPhone1 }}</strong></span>
                    </a>
                </li>
            @endif
            @if ($contactZalo)
                <li>
                    <a class="contact-quick__item" href="{{ $contactZalo }}" target="_blank" rel="noopener">
                        <span class="contact-quick__icon contact-quick__icon--zalo">Zalo</span>
                        <span><small>Chat Zalo</small><strong>Nhắn tin ngay</strong></span>
                    </a>
                </li>
            @endif
            @if ($contactEmail !== '')
                <li>
                    <a class="contact-quick__item" href="mailto:{{ $contactEmail }}">
                        <span class="contact-quick__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg></span>
                        <span><small>Email</small><strong>{{ $contactEmail }}</strong></span>
                    </a>
                </li>
            @endif
            @if ($contactMapUrl)
                <li>
                    <a class="contact-quick__item" href="{{ $contactMapUrl }}" target="_blank" rel="noopener">
                        <span class="contact-quick__icon contact-quick__icon--green"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 21s-7-6.2-7-11.5a7 7 0 0 1 14 0C19 14.8 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.5"/></svg></span>
                        <span><small>Chỉ đường</small><strong>Xem bản đồ</strong></span>
                    </a>
                </li>
            @endif
        </ul>

        <div class="contact-grid">
            <div class="event-widget event-consult contact-form" id="event-consult">
                <h2 class="event-widget__title">Gửi yêu cầu <span class="is-accent">tư vấn</span></h2>
                <p class="event-consult__lead">Điền thông tin bên dưới, chuyên viên sẽ liên hệ lại với bạn trong thời gian sớm nhất.</p>

                @if (session('success'))
                    <p class="event-consult__alert" role="status">{{ session('success') }}</p>
                @endif
                @if (session('error'))
                    <p class="event-consult__alert contact-form__error" role="alert">{{ session('error') }}</p>
                @endif

                <form class="event-consult__form contact-form__grid" method="post" action="{{ route('postcontact') }}" accept-charset="UTF-8">
                    @csrf
                    <input type="hidden" name="redirect_url" value="{{ route('lienHe') }}#event-consult">
                    <input type="hidden" name="service_name" value="Trang liên hệ">
                    <div class="contact-form__field">
                        <label for="contact-name">Họ và tên <span>*</span></label>
                        <input id="contact-name" type="text" name="name" placeholder="Nguyễn Văn A" required autocomplete="name" value="{{ old('name') }}">
                    </div>
                    <div class="contact-form__field">
                        <label for="contact-phone">Số điện thoại <span>*</span></label>
                        <input id="contact-phone" type="tel" name="phone" placeholder="09xx xxx xxx" required autocomplete="tel" pattern="[0-9+\s().-]{8,}" value="{{ old('phone') }}">
                    </div>
                    <div class="contact-form__field">
                        <label for="contact-email">Email</label>
                        <input id="contact-email" type="email" name="email" placeholder="email@congty.vn" autocomplete="email" value="{{ old('email') }}">
                    </div>
                    <div class="contact-form__field">
                        <label for="contact-service">Dịch vụ quan tâm</label>
                        <select id="contact-service" name="service_pick">
                            <option value="">Chọn dịch vụ</option>
                            @foreach ($servicehome as $service)
                                <option value="{{ languageName($service->name) }}" @if (old('service_pick') === languageName($service->name)) selected @endif>{{ languageName($service->name) }}</option>
                            @endforeach
                            <option value="Khác">Khác</option>
                        </select>
                    </div>
                    <div class="contact-form__field contact-form__field--full">
                        <label for="contact-mess">Nội dung</label>
                        <textarea id="contact-mess" name="mess" rows="4" placeholder="Thời gian, địa điểm, quy mô sự kiện...">{{ old('mess') }}</textarea>
                    </div>
                    <div class="contact-form__field--full contact-form__submit">
                        <button type="submit" class="event-consult__submit">
                            Gửi yêu cầu
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                        </button>
                        <p class="contact-form__note">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3l7 3v5c0 4.5-3 8.3-7 10-4-1.7-7-5.5-7-10V6l7-3z"/></svg>
                            Thông tin của bạn được bảo mật tuyệt đối.
                        </p>
                    </div>
                </form>
            </div>

            <div class="contact-side">
                <div class="event-widget contact-info">
                    <h2 class="event-widget__title">{{ $setting->company ?: 'Thông tin liên hệ' }}</h2>
                    <ul class="contact-info__list">
                        @if ($contactAddress !== '')
                            <li>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 21s-7-6.2-7-11.5a7 7 0 0 1 14 0C19 14.8 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.5"/></svg>
                                <span><small>Địa chỉ</small>{{ $contactAddress }}</span>
                            </li>
                        @endif
                        @if ($contactAddressOffice !== '' && $contactAddressOffice !== $contactAddress)
                            <li>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 21V7l8-4 8 4v14"/><path d="M9 21v-6h6v6"/></svg>
                                <span><small>Văn phòng đại diện</small>{{ $contactAddressOffice }}</span>
                            </li>
                        @endif
                        @if ($contactPhone1 !== '' || $contactPhone2 !== '')
                            <li>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2"/></svg>
                                <span>
                                    <small>Điện thoại</small>
                                    @if ($contactPhone1 !== '')<a href="tel:{{ $contactPhone1Digits }}">{{ $contactPhone1 }}</a>@endif
                                    @if ($contactPhone2 !== '')<a href="tel:{{ $contactPhone2Digits }}">{{ $contactPhone2 }}</a>@endif
                                </span>
                            </li>
                        @endif
                        @if ($contactEmail !== '')
                            <li>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg>
                                <span><small>Email</small><a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a></span>
                            </li>
                        @endif
                        <li>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="8.5"/><path d="M12 7.5V12l3 2"/></svg>
                            <span><small>Giờ làm việc</small>Thứ 2 – Chủ nhật, 7:30 – 21:00</span>
                        </li>
                    </ul>

                    @if (count($contactSocials))
                        <div class="contact-info__social">
                            <span>Theo dõi</span>
                            @foreach ($contactSocials as $label => $url)
                                <a href="{{ $url }}" target="_blank" rel="noopener">{{ $label }}</a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @if (!empty($setting->iframe_map) || $contactAddress !== '')
            <div class="contact-map">
                @if (!empty($setting->iframe_map))
                    {!! $setting->iframe_map !!}
                @else
                    <iframe src="https://www.google.com/maps?q={{ urlencode($contactAddress) }}&output=embed" title="Bản đồ" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                @endif
            </div>
        @endif
    </div>
</section>
@endsection
