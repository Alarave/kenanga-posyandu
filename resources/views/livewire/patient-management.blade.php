<div>
    <h2>Manage Patients</h2>
    <ul>
        @foreach ($patients as $patient)
            <li>{{ $patient->full_name }} - Age: {{ $patient->age_category }}</li>
        @endforeach
    </ul>
</div>
