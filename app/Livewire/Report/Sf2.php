<?php

namespace App\Livewire\Report;

use App\Models\Level;
use App\Models\StudentSection;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Sf2 extends Component
{
    public Collection $levels;
    public $from, $to, $level_id;

    public function render()
    {
        $selected_level = Level::withTrashed()->find($this->level_id);

        return view('livewire.report.sf2', [
            'selected_level' => $selected_level,
        ]);
    }

    public function mount($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
        $this->levels = Level::withTrashed()->get();
        if($this->levels){
            $this->level_id = $this->levels[0]->id;
        }
    }
}
