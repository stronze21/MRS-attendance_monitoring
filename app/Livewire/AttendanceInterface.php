<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\AttendanceStudent;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class AttendanceInterface extends Component
{
    use LivewireAlert;

    protected $listeners = ['time_in'];

    public $dtr_date, $id_no, $type = 'in';

    public function render()
    {
        $attendances = AttendanceStudent::latest()->get();

        return view('livewire.attendance-interface', compact('attendances'));
    }

    public function mount()
    {
        $this->dtr_date = date('Y-m-d');
    }

    public function time_in()
    {
        $existing = AttendanceStudent::where('student_id', $this->id_no)->where('dtr_date', $this->dtr_date)->latest()->first();
        switch ($this->type) {
            case "in":
                if (!$existing) {
                    AttendanceStudent::create([
                        'student_id' => $this->id_no,
                        'dtr_date' => $this->dtr_date,
                        'time_in' => now(),
                    ]);
                    $this->alert('success', 'Successfull Time in');
                } else {
                    $this->alert('error', 'Your time-in has already been logged on ' . Carbon::parse($existing->time_in)->format('h:i:s A'));
                }
                break;

            case "out":
                if (!$existing) {
                    $this->alert('error', 'No time-in log found!');
                } else {
                    $existing->time_out = now();
                    $existing->save();
                    $this->alert('success', 'Successfull Time in');
                }
                break;
        }
    }
}
