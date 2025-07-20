<div>
    <h2>Manage Pedukuhan</h2>
    <ul>
        @foreach ($pedukuhans as $pedukuhan)
            <li>{{ $pedukuhan->name }} - Postal Code: {{ $pedukuhan->postal_code }}</li>
        @endforeach
    </ul>
</div>