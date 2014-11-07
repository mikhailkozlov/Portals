<article>
    <h3>{{ $page->title }}</h3>
    <div class="datetime muted">{{ $page->created_at->format('F j, Y') }}</div>
    <p>{{ $page->excerpt }}</p>
    <p><a href="{{ url($portal->slug.'/'.$page->slug) }}">Read More</a></p>
</article>