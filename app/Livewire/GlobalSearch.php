<?php

namespace App\Livewire;

use Livewire\Component;

class GlobalSearch extends Component
{
    public $search = '';

    public function render()
    {
        $results = [
            'patients' => [],
            'schedules' => [],
            'articles' => [],
            'records' => [],
            'users' => [],
        ];

        if (strlen($this->search) >= 2) {
            $searchTerm = '%'.strtolower($this->search).'%';
            $blindIndex = \App\Models\Patient::generateBlindIndex($this->search);

            $results['patients'] = \App\Models\Patient::whereRaw('LOWER(full_name) LIKE ?', [$searchTerm])
                ->orWhere('id_number_hash', $blindIndex)
                ->limit(5)->get();

            $results['schedules'] = \App\Models\Schedule::whereRaw('LOWER(title) LIKE ?', [$searchTerm])
                ->orWhereRaw('LOWER(location) LIKE ?', [$searchTerm])
                ->limit(3)->get();

            $results['articles'] = \App\Models\Article::whereRaw('LOWER(title) LIKE ?', [$searchTerm])
                ->limit(3)->get();

            $results['records'] = \App\Models\MedicalRecord::whereHas('patient', function ($q) use ($searchTerm, $blindIndex) {
                $q->whereRaw('LOWER(full_name) LIKE ?', [$searchTerm])
                  ->orWhere('id_number_hash', $blindIndex);
            })
                ->with('patient')
                ->latest()
                ->limit(3)->get();

            $results['users'] = \App\Models\User::whereRaw('LOWER(name) LIKE ?', [$searchTerm])
                ->orWhereRaw('LOWER(email) LIKE ?', [$searchTerm])
                ->limit(3)->get();
        }

        return view('livewire.global-search', [
            'results' => $results,
        ]);
    }
}
