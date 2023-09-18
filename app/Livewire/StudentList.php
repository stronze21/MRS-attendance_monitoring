<?php

namespace App\Livewire;

use App\Models\Level;
use App\Models\Student;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class StudentList extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $search;
    public $student_id, $lastname, $middlename, $firstname, $birthdate, $gender, $guardian_name, $guardian_relationship, $contact_no, $contact_no_mask = '9', $notify_sms, $level_id;
    public $updating = false;
    public $levels = [];

    public function render()
    {
        $students = Student::paginate(20);

        return view('livewire.student-list', compact(
            'students',
        ));
    }

    public function mount()
    {
        $this->levels = Level::all();
    }

    public function save()
    {
        $this->contact_no = preg_replace('/\s+/', '', $this->contact_no_mask);

        $validated_data = $this->validate([
            'student_id' => ['required', 'string', 'max:30', 'unique:students,id'],
            'lastname' => ['required', 'string', 'max:30'],
            'middlename' => ['nullable', 'string', 'max:30'],
            'firstname' => ['required', 'string', 'max:60'],
            'birthdate' => ['required', 'date', 'before_or_equal:' . now()],
            'gender' => ['required', 'string', 'max:1'],
            'guardian_name' => ['required', 'string', 'max:255'],
            'guardian_relationship' => ['required', 'string', 'max:255'],
            'contact_no' => ['required', 'string', 'max:11'],
            'level_id' => ['required', 'string', 'max:1'],
        ]);

        $validated_data['id'] = $this->student_id;

        Student::create($validated_data);
        $this->reset_data();
        $this->alert('success', 'Successfully created new student record!');
    }

    public function select_student(Student $student)
    {
        $this->reset_data();
        $this->updating = true;
        $this->student_id = $student->id;
        $this->lastname = $student->lastname;
        $this->middlename = $student->middlename;
        $this->firstname = $student->firstname;
        $this->birthdate = $student->birthdate;
        $this->gender = $student->gender;
        $this->guardian_name = $student->guardian_name;
        $this->guardian_relationship = $student->guardian_relationship;
        $this->contact_no = $student->contact_no;
        $this->contact_no_mask = $student->contact_no;
        $this->notify_sms = $student->notify_sms == 1 ? true : false;
        $this->level_id = $student->level_id;
    }

    public function reset_data()
    {
        $this->resetExcept('levels');
    }

    public function update()
    {
        $this->contact_no = preg_replace('/\s+/', '', $this->contact_no_mask);

        $this->validate([
            'lastname' => ['required', 'string', 'max:30'],
            'middlename' => ['nullable', 'string', 'max:30'],
            'firstname' => ['required', 'string', 'max:60'],
            'birthdate' => ['required', 'date', 'before_or_equal:' . now()],
            'gender' => ['required', 'string', 'max:1'],
            'guardian_name' => ['required', 'string', 'max:255'],
            'guardian_relationship' => ['required', 'string', 'max:255'],
            'contact_no' => ['required', 'string', 'max:11'],
            'level_id' => ['required', 'exists:levels,id'],
        ]);

        $student = Student::find($this->student_id);
        $student->lastname = $this->lastname;
        $student->middlename = $this->middlename;
        $student->firstname = $this->firstname;
        $student->birthdate = $this->birthdate;
        $student->gender = $this->gender;
        $student->guardian_name = $this->guardian_name;
        $student->guardian_relationship = $this->guardian_relationship;
        $student->contact_no = $this->contact_no;
        $student->notify_sms = $this->notify_sms;
        $student->level_id = $this->level_id;
        $student->save();

        $this->reset_data();
        $this->alert('success', 'Successfully updated student record!');
    }
}
