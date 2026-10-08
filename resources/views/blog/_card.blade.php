@php
    $postTitle = languageName($item->title);
    $postUrl = route('detailBlog', ['slug' => $item->slug]);
    $postExcerpt = \Illuminate\Support\Str::limit(trim(html_entity_decode(strip_tags(languageName($item->description)), ENT_QUOTES, 'UTF-8')), 140);
    $postWords = preg_split('/\s+/u', trim(strip_tags(languageName($item->content))), -1, PREG_SPLIT_NO_EMPTY);
    $postMinutes = max(1, (int) ceil(count($postWords) / 200));
    $postCategory = $item->cate ? languageName($item->cate->name) : '';
@endphp
<article class="news-card">
    <a class="news-card__media" href="{{ $postUrl }}" tabindex="-1">
        <img src="{{ $item->image ? url($item->image) : '/frontend/images/bgbanner.jpg' }}" alt="{{ $postTitle }}" width="600" height="375" loading="lazy" decoding="async">
        @if ($postCategory !== '')
            <span class="news-card__cat">{{ $postCategory }}</span>
        @endif
    </a>
    <div class="news-card__body">
        <ul class="news-card__meta">
            <li>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3.5" y="5" width="17" height="15.5" rx="2.5"/><path d="M3.5 10h17M8 3v4M16 3v4"/></svg>
                <time datetime="{{ optional($item->created_at)->toDateString() }}">{{ optional($item->created_at)->format('d/m/Y') }}</time>
            </li>
            <li>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="8.5"/><path d="M12 7.5V12l3 2"/></svg>
                {{ $postMinutes }} phút đọc
            </li>
        </ul>
        <h3 class="news-card__title"><a href="{{ $postUrl }}">{{ $postTitle }}</a></h3>
        @if ($postExcerpt !== '')
            <p class="news-card__excerpt">{{ $postExcerpt }}</p>
        @endif
        <a class="news-card__link" href="{{ $postUrl }}">Đọc tiếp
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </a>
    </div>
</article>
