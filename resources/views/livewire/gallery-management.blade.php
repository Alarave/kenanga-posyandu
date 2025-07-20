<div>
    <h2>Manage Gallery</h2>
    <ul>
        @foreach ($galleries as $gallery)
            <li>{{ $gallery->title }} - Type: {{ $gallery->type }}</li>
        @endforeach
    </ul>
</div>
