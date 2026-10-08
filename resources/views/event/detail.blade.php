@extends('layouts.main.master')
@php
    $detailImage = $detail->image ? url($detail->image) : url($setting->logo ?? '');
    $detailSummary = \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags((string) $detail->content), ENT_QUOTES, 'UTF-8'))), 160);
@endphp
@section('title')
{{ $detail->title }}
@endsection
@section('description')
{{ $detailSummary }}
@endsection
@section('image')
{{ $detailImage }}
@endsection
@section('css')
<link rel="stylesheet" href="/frontend/css/event-page.css?v={{ filemtime(public_path('frontend/css/event-page.css')) }}">
@endsection
@section('js')
<script src="/frontend/js/sticky-sidebar.js?v={{ filemtime(public_path('frontend/js/sticky-sidebar.js')) }}"></script>
@endsection
@section('content')
<section class="events events--page events--detail">
    <div class="events__bg" aria-hidden="true">
        <span class="events__blob events__blob--blue"></span>
        <span class="events__blob events__blob--peach"></span>
    </div>

    <div class="events__inner">
        <nav class="event-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Trang chủ</a>
            <span aria-hidden="true">/</span>
            <a href="{{ route('eventList') }}">Sự kiện</a>
            <span aria-hidden="true">/</span>
            <span>{{ $detail->title }}</span>
        </nav>

        <div class="event-layout">
            <div class="event-layout__main">
                <article class="event-detail">
                    <header class="event-detail__head">
                        @if ($detail->tag)
                            <span class="events__eyebrow">{{ $detail->tag }}</span>
                        @endif
                        <h1 class="event-detail__title">{{ $detail->title }}</h1>
                        @if ($detail->event_date || $detail->event_time || $detail->location)
                            <ul class="event-detail__meta">
                                @if ($detail->event_date)
                                    <li>
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3.5" y="5" width="17" height="15.5" rx="2.5"/><path d="M3.5 10h17M8 3v4M16 3v4"/></svg>
                                        <span><small>Ngày</small>{{ $detail->event_date->format('d/m/Y') }}</span>
                                    </li>
                                @endif
                                @if ($detail->event_time)
                                    <li>
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="8.5"/><path d="M12 7.5V12l3 2"/></svg>
                                        <span><small>Thời gian</small>{{ $detail->event_time }}</span>
                                    </li>
                                @endif
                                @if ($detail->location)
                                    <li>
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 21s-6.5-5.6-6.5-11a6.5 6.5 0 0 1 13 0c0 5.4-6.5 11-6.5 11z"/><circle cx="12" cy="10" r="2.4"/></svg>
                                        <span><small>Địa điểm</small>{{ $detail->location }}</span>
                                    </li>
                                @endif
                            </ul>
                        @endif
                    </header>

                    @if ($detail->image)
                        <figure class="event-detail__cover">
                            <img src="{{ url($detail->image) }}" alt="{{ $detail->title }}" decoding="async">
                        </figure>
                    @endif

                    @if (trim(strip_tags((string) $detail->content, '<img><iframe><video>')) !== '')
                        <div class="event-detail__content">
                            {!! $detail->content !!}
                        </div>
                    @endif
                </article>

                @if ($related->isNotEmpty())
                    <section class="event-related" aria-labelledby="event-related-title">
                        <h2 class="event-related__title" id="event-related-title">Sự kiện <span class="is-accent">khác</span></h2>
                        <div class="events__grid">
                            @foreach ($related as $event)
                                @include('event._card', ['event' => $event])
                            @endforeach
                        </div>
                    </section>
                @endif
            </div>

            <aside class="event-layout__aside" aria-label="Thông tin thêm">
                <div class="event-sidebar">
                    @include('partials.sidebar-consult', [
                        'consultSource' => 'Sự kiện: ' . $detail->title,
                        'consultOption' => ['value' => 'Tham gia sự kiện: ' . $detail->title, 'label' => 'Tham gia sự kiện này'],
                    ])
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
