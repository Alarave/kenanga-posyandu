<div>
    <input type="text" wire:model="searchTerm" placeholder="Search patients...">
    <ul>
        @foreach ($patients as $patient)
            <li>{{ $patient->full_name }} - Age: {{ $patient->age_category }}</li>
        @endforeach
    </ul>
</div>