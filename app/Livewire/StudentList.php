<?php

namespace App\Livewire;

use App\Models\Level;
use App\Models\Student;
use App\Models\TableBarangay;
use App\Models\TableMunicipality;
use App\Models\TableProvince;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class StudentList extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $search;
    public $student_id, $nickname, $lastname, $middlename, $firstname, $gender, $guardian_name, $contact_no, $contact_no_2, $contact_no_mask = '9', $notify_sms, $level_id;
    public $address, $barangay, $city = '12', $province = '2';
    public $updating = false;
    public $levels = [];

    public function render()
    {
        $students = Student::paginate(20);
        $province_table = TableProvince::all();
        $municipality_table = TableMunicipality::where('table_province_id', $this->province)->get();
        $barangay_table = TableBarangay::where('table_municipality_id', $this->city)->orderBy('barangay_name', 'ASC')->get();

        return view('livewire.student-list', compact(
            'students',
            'province_table',
            'municipality_table',
            'barangay_table',
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
            'gender' => ['required', 'string', 'max:1'],
            'guardian_name' => ['required', 'string', 'max:255'],
            'contact_no' => ['required', 'string', 'max:11', 'max:11'],
            'level_id' => ['required', 'string', 'max:1'],
            'nickname' => ['required', 'string', 'max:30'],
            'contact_no_2' => ['nullable', 'string', 'max:15'],
            'address' => ['nullable', 'string'],
            'barangay' => ['required', 'string', 'max:80'],
            'city' => ['required', 'string', 'max:80'],
            'province' => ['required', 'string', 'max:80'],
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
        $this->gender = $student->gender;
        $this->guardian_name = $student->guardian_name;
        $this->contact_no = $student->contact_no;
        $this->contact_no_2 = $student->contact_no_2;
        $this->level_id = $student->level_id;
        $this->contact_no_mask = $student->contact_no;
        $this->notify_sms = $student->notify_sms == 1 ? true : false;
        $this->nickname = $student->nickname;
        $this->address = $student->address;
        $this->barangay = $student->barangay;
        $this->city = $student->city;
        $this->province = $student->province;
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
            'gender' => ['required', 'string', 'max:1'],
            'guardian_name' => ['required', 'string', 'max:255'],
            'contact_no' => ['required', 'string', 'max:11'],
            'contact_no_2' => ['nullable', 'string', 'max:11'],
            'level_id' => ['required', 'exists:levels,id'],
        ]);

        $student = Student::find($this->student_id);
        $student->lastname = $this->lastname;
        $student->middlename = $this->middlename;
        $student->firstname = $this->firstname;
        $student->gender = $this->gender;
        $student->guardian_name = $this->guardian_name;
        $student->contact_no = $this->contact_no;
        $student->contact_no_2 = $this->contact_no_2;
        $student->notify_sms = $this->notify_sms;
        $student->level_id = $this->level_id;
        $student->save();

        $this->reset_data();
        $this->alert('success', 'Successfully updated student record!');
    }
}
