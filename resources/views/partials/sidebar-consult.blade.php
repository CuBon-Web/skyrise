@php
    $consultSource = $consultSource ?? '';
    $consultOption = $consultOption ?? null;
    $consultSelected = $consultSelected ?? old('service_pick');
    $consultHidden = $consultHidden ?? [];
    $activeService = $activeService ?? null;
    $sidebarHotline = trim((string) ($setting->phone1 ?? ''));
    $sidebarImage = function ($raw) {
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
<div class="event-widget event-consult" id="event-consult">
    <h2 class="event-widget__title">Đăng ký <span class="is-accent">tư vấn</span></h2>
    <p class="event-consult__lead">Để lại thông tin, chúng tôi sẽ liên hệ tư vấn dịch vụ khinh khí cầu cho bạn.</p>

    @if (session('success'))
        <p class="event-consult__alert" role="status">{{ session('success') }}</p>
    @endif

    <form class="event-consult__form" action="{{ route('postcontact') }}" method="post">
        @csrf
        <input type="hidden" name="redirect_url" value="{{ url()->current() }}#event-consult">
        @if ($consultSource !== '')
            <input type="hidden" name="service_name" value="{{ $consultSource }}">
        @endif
        @foreach ($consultHidden as $hiddenName => $hiddenValue)
            <input type="hidden" name="{{ $hiddenName }}" value="{{ $hiddenValue }}">
        @endforeach
        <label class="sr-only" for="consult-name">Họ và tên</label>
        <input id="consult-name" type="text" name="name" placeholder="Họ và tên *" required autocomplete="name" value="{{ old('name') }}">
        <label class="sr-only" for="consult-phone">Số điện thoại</label>
        <input id="consult-phone" type="tel" name="phone" placeholder="Số điện thoại *" required autocomplete="tel" pattern="[0-9+\s().-]{8,}" value="{{ old('phone') }}">
        <label class="sr-only" for="consult-email">Email</label>
        <input id="consult-email" type="email" name="email" placeholder="Email" autocomplete="email" value="{{ old('email') }}">
        <label class="sr-only" for="consult-service">Dịch vụ quan tâm</label>
        <select id="consult-service" name="service_pick">
            <option value="">Dịch vụ quan tâm</option>
            @foreach ($servicehome as $service)
                <option value="{{ languageName($service->name) }}" @if ($consultSelected === languageName($service->name)) selected @endif>{{ languageName($service->name) }}</option>
            @endforeach
            @if ($consultOption)
                <option value="{{ $consultOption['value'] }}">{{ $consultOption['label'] }}</option>
            @endif
        </select>
        <label class="sr-only" for="consult-mess">Nội dung</label>
        <textarea id="consult-mess" name="mess" rows="2" placeholder="Nội dung cần tư vấn">{{ old('mess') }}</textarea>
        <button type="submit" class="event-consult__submit">
            Gửi đăng ký
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </button>
    </form>

    @if ($sidebarHotline !== '')
        <a class="event-consult__hotline" href="tel:{{ preg_replace('/[^\d+]/', '', $sidebarHotline) }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2"/></svg>
            <span><small>Hotline tư vấn</small>{{ $sidebarHotline }}</span>
        </a>
    @endif
</div>

@if ($servicehome->isNotEmpty())
    <div class="event-widget">
        <h2 class="event-widget__title">Dịch vụ <span class="is-accent">của chúng tôi</span></h2>
        <ul class="event-services">
            @foreach ($servicehome as $service)
                @php
                    $serviceThumb = $sidebarImage($service->image) ?: '/frontend/images/bgbanner.jpg';
                @endphp
                <li>
                    <a href="{{ route('serviceList', ['slug' => $service->slug]) }}" @if ($activeService === $service->slug) class="is-active" aria-current="page" @endif>
                        <img src="{{ url($serviceThumb) }}" alt="" width="56" height="56" loading="lazy" decoding="async">
                        <span>{{ languageName($service->name) }}</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 6l6 6-6 6"/></svg>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endif
