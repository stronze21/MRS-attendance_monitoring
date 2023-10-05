<?php

namespace App\Livewire;

use App\Models\Level;
use App\Models\Student;
use App\Models\StudentSection;
use Illuminate\Database\Eloquent\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ViewClassSection extends Component
{
    use LivewireAlert;

    public $level_id;
    public Collection $levels;
    public $student_id;

    public function render()
    {
        $current_level = Level::find($this->level_id);

        return view('livewire.view-class-section', [
            'current_level' => $current_level,
        ]);
    }

    public function mount($level_id)
    {
        $this->level_id = $level_id;
        $this->levels = Level::all();
    }

    public function save()
    {
        $validated_data = $this->validate([
            'student_id' => ['required', 'exists:students,id'],
            'level_id' => ['required'],
        ]);

        $current = StudentSection::where('student_id', $this->student_id)->where('level_id', $this->level_id)->first();
        if ($current) {
            $this->alert('error', 'Student already in class/section.');
        } else {
            StudentSection::create($validated_data);
            $student = Student::find($this->student_id);
            $student->level_id = $this->level_id;
            $student->save();
            $this->alert('success', 'Student added to class/section.');
        }
    }

    public function remove($student_id)
    {
        $current = StudentSection::where('student_id', $student_id)->where('level_id', $this->level_id)->first();
        if ($current) {
            $student = Student::find($student_id);
            $student->level_id = "";
            $student->save();
            $current->delete();
            $this->alert('success', 'Student removed to class/section.');
        }
    }
}
