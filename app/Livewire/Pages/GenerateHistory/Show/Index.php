<?php

namespace App\Livewire\Pages\GenerateHistory\Show;

use Livewire\Component;
use App\Models\GenerateHistory;

class Index extends Component
{
    public $uuid;

    public function mount(string $uuid)
    {
        $this->uuid = $uuid;
    }

    public function render()
    {
        $generateHistory = GenerateHistory::where('uuid', $this->uuid)->firstOrFail();
        $result = json_decode($generateHistory->result, true) ?? [];

        return view('livewire.pages.generate-history.show.index', [
            'generateHistory' => $generateHistory,
            'result' => $result,
        ]);
    }
}
