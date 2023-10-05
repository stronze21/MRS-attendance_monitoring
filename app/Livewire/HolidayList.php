<?php

namespace App\Livewire;

use App\Models\Holiday;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class HolidayList extends Component
{
    use LivewireAlert;

    public $date_holiday, $updating = false;
    public $search;

    public function render()
    {
        $holidays = Holiday::where('date_holiday', 'LIKE', '%' . $this->search)
            ->latest('date_holiday')
            ->get();

        return view('livewire.holiday-list', [
            'holidays' => $holidays,
        ]);
    }

    public function save()
    {
        $this->validate([
            'date_holiday' => ['date', 'unique:holidays,date_holiday'],
        ]);

        Holiday::create([
            'date_holiday' => $this->date_holiday,
        ]);
        $this->reset();
        $this->alert('success', 'Holiday added to calendar.');
    }
}
