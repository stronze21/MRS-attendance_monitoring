<?php

namespace App\Livewire;

use App\Models\Teacher;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class TeacherList extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $search;
    public $teacher_id, $lastname, $middlename, $firstname, $birthdate, $gender, $contact_no, $contact_no_mask = '9', $address, $appointment_date;
    public $updating = false;

    public function render()
    {
        $teachers = Teacher::paginate(20);

        return view('livewire.teacher-list', compact(
            'teachers',
        ));
    }

    public function save()
    {
        $this->contact_no = preg_replace('/\s+/', '', $this->contact_no_mask);

        $validated_data = $this->validate([
            'teacher_id' => ['required', 'string', 'max:30', 'unique:students,id'],
            'lastname' => ['required', 'string', 'max:30'],
            'middlename' => ['nullable', 'string', 'max:30'],
            'firstname' => ['required', 'string', 'max:60'],
            'birthdate' => ['required', 'date', 'before_or_equal:' . now()],
            'gender' => ['required', 'string', 'max:1'],
            'contact_no' => ['required', 'string', 'max:11'],
            'address' => ['nullable', 'string'],
        ]);

        $validated_data['id'] = $this->teacher_id;

        Teacher::create($validated_data);
        $this->reset_data();
        $this->alert('success', 'Successfully created new teacher record!');
    }

    public function select_teacher(Teacher $teacher)
    {
        $this->reset_data();
        $this->updating = true;
        $this->teacher_id = $teacher->id;
        $this->lastname = $teacher->lastname;
        $this->middlename = $teacher->middlename;
        $this->firstname = $teacher->firstname;
        $this->birthdate = $teacher->birthdate;
        $this->gender = $teacher->gender;
        $this->contact_no = $teacher->contact_no;
        $this->contact_no_mask = $teacher->contact_no;
        $this->address = $teacher->address;
    }

    public function reset_data()
    {
        $this->reset();
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
            'contact_no' => ['required', 'string', 'max:11'],
            'address' => ['nullable', 'string'],
        ]);

        $teacher = Teacher::find($this->teacher_id);
        $teacher->lastname = $this->lastname;
        $teacher->middlename = $this->middlename;
        $teacher->firstname = $this->firstname;
        $teacher->birthdate = $this->birthdate;
        $teacher->gender = $this->gender;
        $teacher->contact_no = $this->contact_no;
        $teacher->address = $this->address;
        $teacher->save();

        $this->reset_data();
        $this->alert('success', 'Successfully updated teacher record!');
    }
}
