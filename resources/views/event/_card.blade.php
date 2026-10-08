@php
    $eventUrl = route('eventDetail', ['slug' => $event->slug]);
@endphp
<article class="event-card">
    <a class="event-card__media" href="{{ $eventUrl }}" tabindex="-1">
        <img src="{{ $event->image ? url($event->image) : '/frontend/images/bgbanner.jpg' }}" alt="{{ $event->title }}" loading="lazy" decoding="async">
        @if ($event->event_date)
            <span class="event-card__date"><strong>{{ $event->event_date->format('d') }}</strong>Th {{ $event->event_date->format('m') }}</span>
        @endif
        @if ($event->tag)
            <span class="event-card__tag">{{ $event->tag }}</span>
        @endif
    </a>
    <div class="event-card__body">
        <h3 class="event-card__title"><a href="{{ $eventUrl }}">{{ $event->title }}</a></h3>
        @if ($event->event_time || $event->location)
            <ul class="event-card__meta">
                @if ($event->event_time)
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="8.5"/><path d="M12 7.5V12l3 2"/></svg>{{ $event->event_time }}</li>
                @endif
                @if ($event->location)
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 21s-6.5-5.6-6.5-11a6.5 6.5 0 0 1 13 0c0 5.4-6.5 11-6.5 11z"/><circle cx="12" cy="10" r="2.4"/></svg>{{ $event->location }}</li>
                @endif
            </ul>
        @endif
        <a class="event-card__link" href="{{ $eventUrl }}">Xem chi tiết
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </a>
    </div>
</article>
