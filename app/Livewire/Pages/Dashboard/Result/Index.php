<?php

namespace App\Livewire\Pages\Dashboard\Result;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class Index extends Component
{
    public $analysisResult;

    protected $listeners = ['analysisCompleted' => 'handleAnalysisCompleted'];

    public function mount()
    {
        $this->analysisResult = Session::get('analysisResult');
    }

    public function handleAnalysisCompleted($result)
    {
        $this->analysisResult = $result;
    }

    public function render()
    {
        return view('livewire.pages.dashboard.result.index', [
            'analysisResult' => $this->analysisResult,
        ]);
    }
}
