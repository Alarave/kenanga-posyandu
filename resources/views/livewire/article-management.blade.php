<div>
    <h2>Manage Articles</h2>
    <ul>
        @foreach ($articles as $article)
            <li>{{ $article->title }} - Published: {{ $article->published_at }}</li>
        @endforeach
    </ul>
</div>
