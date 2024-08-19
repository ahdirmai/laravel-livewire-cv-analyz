<?php

namespace App\Livewire\Pages\GenerateHistory\Table;

use Livewire\Component;
use App\Models\GenerateHistory;

class Index extends Component
{
    public function render()
    {
        $generatedHistory = GenerateHistory::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();

        return view('livewire.pages.generate-history.table.index', [
            'generatedHistory' => $generatedHistory,
        ]);
    }
}
