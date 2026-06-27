@props(['title' => 'Terjadi Kesalahan'])

@if ($errors->any())
    <div 
        class="mb-4 p-4 bg-red-50 border-l-4 border-error rounded-r-lg"
        role="alert"
        aria-live="assertive"
    >
        <div class="flex items-start">
            <span class="material-symbols-outlined text-error mr-3 text-headline-sm">error</span>
            <div class="flex-1">
                <h3 class="text-sm font-bold text-red-800 mb-2">{{ $title }}</h3>
                <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif