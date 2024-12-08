<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ResidentialArea;

class ResidentialAreaCrud extends Component
{
    public $residentialAreas, $name, $city, $state, $search, $isOpen = false, $residentialAreaId;

    protected $rules = [
        'name' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'state' => 'required|string|max:255',
    ];

    public function render()
    {
        $this->residentialAreas = ResidentialArea::when($this->search, function($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('city', 'like', '%' . $this->search . '%')
                ->orWhere('state', 'like', '%' . $this->search . '%');
        })->get();

        return view('livewire.residential-area-crud');
    }

    public function create()
    {
        $this->resetForm();
        $this->isOpen = true;
    }

    public function store()
    {
        $this->validate();

        ResidentialArea::updateOrCreate(
            ['id' => $this->residentialAreaId],
            [
                'name' => $this->name,
                'city' => $this->city,
                'state' => $this->state
            ]
        );

        session()->flash('message', $this->residentialAreaId ? 'Área Residencial actualizada.' : 'Área Residencial creada.');

        $this->closeModal();
    }

    public function edit($id)
    {
        $residentialArea = ResidentialArea::findOrFail($id);
        $this->residentialAreaId = $residentialArea->id;
        $this->name = $residentialArea->name;
        $this->city = $residentialArea->city;
        $this->state = $residentialArea->state;
        $this->isOpen = true;
    }

    public function delete($id)
    {
        ResidentialArea::findOrFail($id)->delete();
        session()->flash('message', 'Área Residencial eliminada.');
    }

    public function closeModal()
    {
        $this->resetForm();
        $this->isOpen = false;
    }

    private function resetForm()
    {
        $this->name = '';
        $this->city = '';
        $this->state = '';
        $this->residentialAreaId = null;
    }
}
