<?php

namespace App\Livewire;

use App\Models\Level;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class LevelList extends Component
{
    use LivewireAlert;

    public $updating = false;

    public $level_id, $description, $section, $from, $to, $am_pm = 'am';

    public function render()
    {
        $levels = Level::withTrashed()->get();
        return view('livewire.level-list', [
            'levels' => $levels,
        ]);
    }

    public function mount()
    {
        $this->from = date('Y');
        $this->to = date('Y') + 1;
    }

    public function save()
    {
        $validated_data = $this->validate([
            'description' => ['required'],
            'section' => ['required'],
            'from' => ['required'],
            'to' => ['required'],
            'am_pm' => ['required'],
        ]);

        $validated_data['school_year'] = $this->from.'-'.$this->to;

        if (Level::create($validated_data)) {
            $this->resetExcept('from', 'to', 'am_pm');
            return $this->alert('success', 'Level/Section ' . $validated_data['description'] . ' has been saved.');
        }
    }

    public function select_level($level_id)
    {
        $level = Level::withTrashed()->find($level_id);

        $sy = explode('-', $level->school_year);

        $this->level_id = $level->id;
        $this->description = $level->description;
        $this->section = $level->section;
        $this->from = $sy[0];
        $this->to = $sy[1];
        $this->am_pm = $level->am_pm;
        $this->updating = true;
    }

    public function update()
    {
        $this->validate([
            'description' => ['required', 'unique:levels,description'],
        ]);
        $level = Level::find($this->level_id);
        $level->description = $this->description;
        $level->section = $this->section;
        $level->school_year = $this->from.'-'.$this->to;
        $level->am_pm = $this->am_pm;
        $level->save();

        $this->reset();
        return $this->alert('success', 'Changes has been saved.');
    }

    public function deactivate(Level $level)
    {
        $level->delete();
        $this->alert('success', 'Deactivated successfully');
    }

    public function activate($level_id)
    {
        Level::withTrashed()->find($level_id)->restore();
        $this->alert('success', 'Activated successfully');
    }
}
