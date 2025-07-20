<div>
    <h2>Manage Medical Records</h2>
    <ul>
        @foreach ($medicalRecords as $record)
            <li>Patient: {{ $record->patient->full_name }} - Diagnosis: {{ $record->diagnosis }}</li>
        @endforeach
    </ul>
</div>
