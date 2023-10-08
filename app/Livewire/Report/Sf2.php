<?php

namespace App\Livewire\Report;

use App\Models\Level;
use App\Models\StudentSection;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Sf2 extends Component
{
    public Collection $levels;
    public $from, $to, $level_id, $month, $current_month;

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
        $this->current_month = Carbon::parse($from)->format('F Y');
        $this->month = date('Y-m', strtotime($from));
        $this->levels = Level::withTrashed()->get();
        if($this->levels){
            $this->level_id = $this->levels[0]->id;
        }
    }

    public function updatedMonth()
    {
        $this->current_month = Carbon::parse($this->month.'-01')->format('F Y');
        $this->from = Carbon::parse($this->month.'-01')->startOfMonth()->format('Y-m-d');
        $this->to = Carbon::parse($this->month.'-01')->endOfMonth()->format('Y-m-d');
    }
}
