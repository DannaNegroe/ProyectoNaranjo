<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Resident;
use App\Models\House;

class ResidentCrud extends Component
{
    public $residents;
    public $houses;
    public $resident_id;
    public $name;
    public $house_id;
    public $search = '';
    public $isOpen = false;

    private function openModal()
    {
        $this->isOpen = true;
    }

    private function closeModal()
    {
        $this->isOpen = false;
    }

    public function render()
    {
        $this->residents = Resident::with('house')
            ->where('name', 'like', '%' . $this->search . '%')
            ->get();

        $this->houses = House::all();

        return view('livewire.resident-crud');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'house_id' => 'required|exists:houses,id',
        ]);

        Resident::updateOrCreate(
            ['id' => $this->resident_id],
            [
                'name' => $this->name,
                'house_id' => $this->house_id,
            ]
        );

        session()->flash('message', $this->resident_id ? 'Residente actualizado exitosamente.' : 'Residente creado exitosamente.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $resident = Resident::findOrFail($id);

        $this->resident_id = $resident->id;
        $this->name = $resident->name;
        $this->house_id = $resident->house_id;

        $this->openModal();
    }

    public function delete($id)
    {
        Resident::findOrFail($id)->delete();
        session()->flash('message', 'Residente eliminado exitosamente.');
    }

    private function resetInputFields()
    {
        $this->resident_id = null;
        $this->name = '';
        $this->house_id = null;
    }


}
