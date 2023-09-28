<?php

namespace App\Livewire\Report;

use App\Models\AttendanceStudent;
use App\Models\Student;
use App\Models\Teacher;
use Carbon\Carbon;
use Livewire\Component;
use PHPUnit\Framework\MockObject\Builder\Stub;

class Dtr extends Component
{

    public $teacher_id, $month, $year, $month_of;
    private $detail;

    public function render()
    {
        $start = Carbon::parse(now())->startOfMonth();
        $end = Carbon::parse(now())->endOfMonth();

        $detail = $this->detail;

        return view('livewire.report.dtr', compact(
            'detail',
        ));
    }

    public function mount($teacher_id)
    {
        $this->teacher_id = $teacher_id;
        $this->detail = Teacher::find($teacher_id);
        $this->month_of = Carbon::parse(now())->format('F Y');
        $this->month = Carbon::parse(now())->format('m');
        $this->year = Carbon::parse(now())->format('Y');
    }
}
