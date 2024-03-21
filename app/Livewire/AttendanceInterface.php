<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Student;
use Livewire\Component;
use App\Models\AttendanceStudent;
use App\Models\AttendanceTeacher;
use App\Models\MessageCounter;
use App\Models\Teacher;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class AttendanceInterface extends Component
{
    use LivewireAlert;

    protected $listeners = ['time_in'];

    public $dtr_date, $id_no, $type = 'in', $for_user = 'student';

    public function updatedIdNo()
    {
        $id = explode('=', $this->id_no);
        $this->id_no = implode('-', $id);
        $this->time_in();
    }

    public function render()
    {
        $attendances = $this->for_user == 'student' ?
            AttendanceStudent::where('dtr_date', date('Y-m-d'))->latest()->take(5)->get() :
            AttendanceTeacher::where('dtr_date', date('Y-m-d'))->latest()->take(5)->get();

        return view('livewire.attendance-interface', compact('attendances'));
    }

    public function send_message($number, $message, $student_id)
    {
        $ch = curl_init();
        $parameters = array(
            'apikey' => env('SMS_API_KEY'), //Your API KEY
            'number' => $number,
            'message' => $message,
            'sendername' => 'MRSDCS'
        );
        curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
        curl_setopt($ch, CURLOPT_POST, 1);

        //Send the parameters set above with the request
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));

        // Receive response from server
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);

        MessageCounter::create([
            'student_id' => $student_id,
            'contact_no' => $number,
        ]);

        return;
    }

    public function mount()
    {
        $this->dtr_date = date('Y-m-d');
    }

    public function log()
    {
        $this->id_no = '001783';
        $this->time_in();
    }

    public function time_in()
    {
        $id_no = implode("", explode('http://', $this->id_no));
        switch ($this->for_user) {
            case "teacher":
                switch ($this->type) {
                    case "in":
                        $existing = AttendanceTeacher::where('teacher_id', $id_no)
                            ->where('dtr_date', $this->dtr_date)
                            ->latest()
                            ->first();

                        if (!$existing or ($existing and $existing->time_in_am and $existing->time_out_am and !$existing->time_in_pm and !$existing->time_out_pm)) {
                            $teacher = Teacher::find($id_no);
                            if ($teacher) {
                                $attendance = AttendanceTeacher::firstOrCreate([
                                    'teacher_id' => $id_no,
                                    'dtr_date' => $this->dtr_date,
                                ]);
                                $hour = Carbon::parse(now())->format('H');

                                if ($hour <= 12 && !$attendance->time_out_am)
                                    $attendance->time_in_am = $time_in = now();
                                else
                                    $attendance->time_in_pm = $time_in = now();

                                $attendance->save();

                                $this->alert('success', 'Successfull Time in');
                            } else {
                                $this->alert('error', 'ID not found.');
                            }
                        } else {
                            $this->alert('error', 'Your time-IN has already been logged today.');
                        }
                        break;

                    case "out":
                        $existing = AttendanceTeacher::where('teacher_id', $id_no)
                            ->where('dtr_date', $this->dtr_date)
                            ->where(function ($query) {
                                $query->whereNotNull('time_in_am')
                                    ->orWhereNotNull('time_in_pm');
                            })
                            ->latest()
                            ->first();

                        if (
                            !$existing or
                            ($existing and
                                (($existing->time_in_am and
                                    ($existing->time_out_am or $existing->time_out_pm)) or
                                    ($existing->time_in_pm and $existing->time_out_pm))
                            )
                        ) {
                            $this->alert('error', 'No time-IN log found!');
                        } else {
                            $teacher = Teacher::find($id_no);
                            $hour = Carbon::parse(now())->format('H');

                            if ($hour <= 12 && !$existing->time_out_am)
                                $time_out = $existing->time_out_am = now();
                            else
                                $time_out = $existing->time_out_pm = now();

                            $existing->save();
                            $this->alert('success', 'Successfull time-OUT');
                        }
                        break;
                }
                break;
            default:
                switch ($this->type) {
                    case "in":
                        $existing = AttendanceStudent::where('student_id', $id_no)
                            ->where('dtr_date', $this->dtr_date)
                            ->latest()
                            ->first();

                        if (!$existing or ($existing and $existing->time_in_am and $existing->time_out_am and !$existing->time_in_pm and !$existing->time_out_pm)) {
                            $student = Student::find($id_no);
                            if ($student) {
                                $attendance = AttendanceStudent::firstOrCreate([
                                    'student_id' => $id_no,
                                    'dtr_date' => $this->dtr_date,
                                    'level_id' => $student->level_id,
                                ]);
                                $hour = Carbon::parse(now())->format('H');

                                if ($hour <= 12 && !$attendance->time_out_am)
                                    $attendance->time_in_am = $time_in = now();
                                else
                                    $attendance->time_in_pm = $time_in = now();

                                $attendance->save();

                                if ($student->notify_sms) {
                                    $this->send_message($student->contact_no, $student->fullname() . ' has timed-IN on ' . Carbon::parse($time_in)->format('h:i:s A'), $id_no);
                                }
                                $this->alert('success', 'Successfull Time in');
                            } else {
                                $this->alert('error', 'ID not found.');
                            }
                        } else {
                            $this->alert('error', 'Your time-IN has already been logged today.');
                        }
                        break;

                    case "out":
                        $existing = AttendanceStudent::where('student_id', $id_no)
                            ->where('dtr_date', $this->dtr_date)
                            ->where(function ($query) {
                                $query->whereNotNull('time_in_am')
                                    ->orWhereNotNull('time_in_pm');
                            })
                            ->latest()
                            ->first();

                        if (
                            !$existing or
                            ($existing and
                                (($existing->time_in_am and
                                    ($existing->time_out_am or $existing->time_out_pm)) or
                                    ($existing->time_in_pm and $existing->time_out_pm))
                            )
                        ) {
                            $student = Student::find($id_no);
                            $hour = Carbon::parse(now())->format('H');
                            $attendance = AttendanceStudent::firstOrCreate([
                                'student_id' => $id_no,
                                'dtr_date' => $this->dtr_date,
                                'level_id' => $student->level_id,
                            ]);
                            $hour = Carbon::parse(now())->format('H');

                            if ($hour <= 12 && !$attendance->time_out_am)
                                $attendance->time_out_am = $time_out = now();
                            else
                                $attendance->time_out_pm = $time_out = now();

                            $attendance->save();

                            if ($student->notify_sms) {
                                $this->send_message($student->contact_no, $student->fullname() . ' has timed-OUT on ' . Carbon::parse($time_out)->format('h:i:s A'), $id_no);
                            }
                            $this->alert('success', 'Successfull time-OUT');
                        } else {
                            $student = Student::find($id_no);
                            $hour = Carbon::parse(now())->format('H');

                            if ($hour <= 12 && !$existing->time_out_am)
                                $time_out = $existing->time_out_am = now();
                            else
                                $time_out = $existing->time_out_pm = now();

                            $existing->save();
                            if ($student->notify_sms) {
                                $this->send_message($student->contact_no, $student->fullname() . ' has timed-OUT on ' . Carbon::parse($time_out)->format('h:i:s A'), $id_no);
                            }
                            $this->alert('success', 'Successfull time-OUT');
                        }
                        break;
                }
        }
        $this->reset('id_no');
    }
}
