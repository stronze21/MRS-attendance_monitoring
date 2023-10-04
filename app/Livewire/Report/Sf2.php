<?php

namespace App\Livewire\Report;

use Livewire\Component;

class Sf2 extends Component
{
    public $from, $to;

    public function render()
    {
        return view('livewire.report.sf2');
    }

    public function mount($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }
}
