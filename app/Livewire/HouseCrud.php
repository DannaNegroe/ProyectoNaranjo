<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\House;
use App\Models\Cluster;

class HouseCrud extends Component
{
    public $houses, $house_id, $label, $owner, $rooms, $bathrooms, $square_footage, $status, $cluster_id;
    public $isOpen = false;
    public $search = ''; // Variable de búsqueda

    public function render()
    {
        $query = House::with('cluster');

        if ($this->search) {
            $query->where('label', 'like', '%' . $this->search . '%')
                  ->orWhere('owner', 'like', '%' . $this->search . '%');
        }

        $this->houses = $query->get();
        $clusters = Cluster::all();
        return view('livewire.house-crud', ['clusters' => $clusters]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields()
    {
        $this->house_id = null;
        $this->label = '';
        $this->owner = '';
        $this->rooms = '';
        $this->bathrooms = '';
        $this->square_footage = '';
        $this->status = '';
        $this->cluster_id = '';
    }

    public function store()
    {
        $this->validate([
            'label' => 'required',
            'owner' => 'required',
            'rooms' => 'required|integer',
            'bathrooms' => 'required|integer',
            'square_footage' => 'required|numeric',
            'status' => 'required|in:active,inactive',
            'cluster_id' => 'required|exists:clusters,id',
        ]);

        House::updateOrCreate(['id' => $this->house_id], [
            'label' => $this->label,
            'owner' => $this->owner,
            'rooms' => $this->rooms,
            'bathrooms' => $this->bathrooms,
            'square_footage' => $this->square_footage,
            'status' => $this->status,
            'cluster_id' => $this->cluster_id,
        ]);

        session()->flash('message', $this->house_id ? 'Casa actualizada correctamente.' : 'Casa creada correctamente.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $house = House::findOrFail($id);
        $this->house_id = $id;
        $this->label = $house->label;
        $this->owner = $house->owner;
        $this->rooms = $house->rooms;
        $this->bathrooms = $house->bathrooms;
        $this->square_footage = $house->square_footage;
        $this->status = $house->status;
        $this->cluster_id = $house->cluster_id;

        $this->openModal();
    }

    public function delete($id)
    {
        House::findOrFail($id)->delete();
        session()->flash('message', 'Casa eliminada correctamente.');
    }

    public function search()
    {
        // Método para disparar la búsqueda
        $this->render();
    }
}
