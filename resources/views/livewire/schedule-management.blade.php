<div>
    <h2>Manage Schedules</h2>
    <ul>
        @foreach ($schedules as $schedule)
            <li>{{ $schedule->title }} - Starts at: {{ $schedule->start_time }}</li>
        @endforeach
    </ul>
</div>