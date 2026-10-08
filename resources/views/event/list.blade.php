@extends('layouts.main.master')
@section('title')
Sự kiện - {{ $setting->company }}
@endsection
@section('description')
Lịch bay và các sự kiện khinh khí cầu sắp diễn ra.
@endsection
@section('image')
{{ url($setting->logo ?? '') }}
@endsection
@section('css')
<link rel="stylesheet" href="/frontend/css/event-page.css?v={{ filemtime(public_path('frontend/css/event-page.css')) }}">
@endsection
@section('content')
<section class="events events--page" aria-labelledby="events-title">
    <div class="events__bg" aria-hidden="true">
        <span class="events__blob events__blob--blue"></span>
        <span class="events__blob events__blob--peach"></span>
        <span class="events__dots"></span>
    </div>

    <div class="events__inner">
        <nav class="event-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Trang chủ</a>
            <span aria-hidden="true">/</span>
            <span>Sự kiện</span>
        </nav>

        <header class="events__head">
            <div class="events__intro">
                <span class="events__eyebrow">Lịch bay</span>
                <h1 class="events__title" id="events-title">Sự kiện <span class="is-accent">khinh khí cầu</span></h1>
                <p class="events__lead">Lịch bay và các lễ hội khinh khí cầu sắp diễn ra trên khắp Việt Nam.</p>
            </div>
            @if ($events->total())
                <p class="events__count"><strong>{{ $events->total() }}</strong> sự kiện</p>
            @endif
        </header>

        @if ($events->count())
            <div class="events__grid">
                @foreach ($events as $event)
                    @include('event._card', ['event' => $event])
                @endforeach
            </div>

            @if ($events->hasPages())
                <div class="event-pagination">
                    {{ $events->onEachSide(1)->links() }}
                </div>
            @endif
        @else
            <p class="event-empty">Chưa có sự kiện nào.</p>
        @endif
    </div>
</section>
@endsection
