<?php

namespace App\Livewire\Report;

use App\Models\AttendanceStudent;
use App\Models\Student;
use Carbon\Carbon;
use Livewire\Component;

class Dtr extends Component
{
    public function render()
    {
        $start = Carbon::parse(now())->startOfMonth();
        $end = Carbon::parse(now())->endOfMonth();

        $month_of = Carbon::parse(now())->format('F Y');
        $month = Carbon::parse(now())->format('m');
        $year = Carbon::parse(now())->format('Y');

        $detail = Student::find('001783');

        return view('livewire.report.dtr', compact(
            'detail',
            'month_of',
            'month',
            'year',
        ));
    }
}
