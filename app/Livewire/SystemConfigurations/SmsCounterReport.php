<?php

namespace App\Livewire\SystemConfigurations;

use App\Models\MessageCounter;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SmsCounterReport extends Component
{
    public $month, $search;

    public function render()
    {
        $from = Carbon::parse($this->month . '-01')->startOfMonth();
        $to = Carbon::parse($this->month . '-01')->endOfMonth();
        $data = DB::select(
            "SELECT COUNT(ctr.id) as total, stu.guardian_name, ctr.contact_no
        FROM message_counters ctr
        INNER JOIN students stu ON ctr.student_id = stu.id
        WHERE stu.guardian_name LIKE ? AND ctr.created_at BETWEEN ? AND ?
        GROUP BY ctr.student_id, ctr.contact_no, stu.guardian_name",
            ['%' . $this->search . '%', $from, $to]
        );
        return view('livewire.system-configurations.sms-counter-report', compact(
            'data',
        ));
    }

    public function mount()
    {
        $this->month = date('Y-m');
    }
}
