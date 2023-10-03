<?php

namespace App\Livewire;

use App\Models\Level;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class LevelList extends Component
{
    use LivewireAlert;

    public $updating = false;

    public $level_id, $description;

    public function render()
    {
        $levels = Level::all();
        return view('livewire.level-list', [
            'levels' => $levels,
        ]);
    }

    public function save()
    {
        $validated_data = $this->validate([
            'description' => ['required', 'unique:levels,description'],
        ]);

        if (Level::create($validated_data)) {
            $this->reset();
            return $this->alert('success', 'Level/Section ' . $validated_data['description'] . ' has been saved.');
        }
    }

    public function select_level(Level $level)
    {
        $this->level_id = $level->id;
        $this->description = $level->description;
        $this->updating = true;
    }

    public function update()
    {
        $this->validate([
            'description' => ['required', 'unique:levels,description'],
        ]);
        $level = Level::find($this->level_id);
        $level->description = $this->description;
        $level->save();

        $this->reset();
        return $this->alert('success', 'Changes has been saved.');
    }
}
