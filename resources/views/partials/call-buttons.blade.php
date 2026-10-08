@php
    $callPhone = trim((string) ($setting->phone1 ?? ''));
    $callPhoneDigits = preg_replace('/[^0-9+]/', '', $callPhone);
    $callZalo = $callPhone !== '' ? 'https://zalo.me/' . preg_replace('/\D/', '', $callPhone) : null;
    $callMessenger = null;
    $callFacebook = trim((string) ($setting->facebook ?? ''));
    if ($callFacebook !== '' && preg_match('#facebook\.com/(?:profile\.php\?id=)?([^/?&\#]+)#i', $callFacebook, $callFbMatch)) {
        $callMessenger = 'https://m.me/' . $callFbMatch[1];
    }
@endphp
@if ($callPhone !== '')
    <div class="call-buttons" aria-label="Liên hệ nhanh">
        @if ($callMessenger)
            <a class="call-buttons__item call-buttons__item--messenger" href="{{ $callMessenger }}" target="_blank" rel="noopener" aria-label="Chat Messenger">
                <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2C6.36 2 2 6.13 2 11.7c0 2.91 1.19 5.44 3.14 7.17.16.15.26.35.27.57l.05 1.78a.8.8 0 0 0 1.12.71l1.98-.87a.8.8 0 0 1 .53-.04c.91.25 1.88.38 2.91.38 5.64 0 10-4.13 10-9.7S17.64 2 12 2zm6 7.46-2.94 4.66a1.5 1.5 0 0 1-2.17.4l-2.34-1.75a.6.6 0 0 0-.72 0l-3.16 2.4c-.42.32-.97-.18-.69-.63l2.94-4.66a1.5 1.5 0 0 1 2.17-.4l2.34 1.75a.6.6 0 0 0 .72 0l3.16-2.4c.42-.32.97.18.69.63z"/></svg>
                <span class="call-buttons__tip">Chat Messenger</span>
            </a>
        @endif
        @if ($callZalo)
            <a class="call-buttons__item call-buttons__item--zalo" href="{{ $callZalo }}" target="_blank" rel="noopener" aria-label="Chat Zalo">
                <b>Zalo</b>
                <span class="call-buttons__tip">Chat Zalo</span>
            </a>
        @endif
        <a class="call-buttons__phone" href="tel:{{ $callPhoneDigits }}" aria-label="Gọi {{ $callPhone }}">
            <span class="call-buttons__ring" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6.62 10.79a15.05 15.05 0 0 0 6.59 6.59l2.2-2.2a1 1 0 0 1 1.02-.24c1.12.37 2.33.57 3.57.57a1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.45.57 3.57a1 1 0 0 1-.25 1.02l-2.2 2.2z"/></svg>
            </span>
            <span class="call-buttons__label">{{ $callPhone }}</span>
        </a>
    </div>
@endif
