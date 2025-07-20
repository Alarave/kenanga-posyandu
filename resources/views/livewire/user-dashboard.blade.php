<div>
    <h2>User Dashboard</h2>
    <ul>
        @foreach ($users as $user)
            <li>{{ $user->name }} - Role: {{ $user->role }}</li>
        @endforeach
    </ul>
</div>