<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cluster;

class ClusterCrud extends Component
{
    public $clusters, $cluster_id, $name, $address, $total_units, $common_areas, $maintenance_schedule, $parking_spaces, $residential_area_id;
    public $isOpen = false;
    public $search = ''; // Variable para búsqueda

    public function render()
    {
        $query = Cluster::query();

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('address', 'like', '%' . $this->search . '%');
        }

        $this->clusters = $query->get();
        return view('livewire.cluster-crud');
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
        $this->cluster_id = null;
        $this->name = '';
        $this->address = '';
        $this->total_units = '';
        $this->common_areas = '';
        $this->maintenance_schedule = '';
        $this->parking_spaces = '';
        $this->residential_area_id = '';
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'total_units' => 'required|integer',
            'common_areas' => 'nullable|string',
            'maintenance_schedule' => 'nullable|string',
            'parking_spaces' => 'required|integer',
            'residential_area_id' => 'required|exists:residential_areas,id',
        ]);

        Cluster::updateOrCreate(['id' => $this->cluster_id], [
            'name' => $this->name,
            'address' => $this->address,
            'total_units' => $this->total_units,
            'common_areas' => $this->common_areas,
            'maintenance_schedule' => $this->maintenance_schedule,
            'parking_spaces' => $this->parking_spaces,
            'residential_area_id' => $this->residential_area_id,
        ]);

        session()->flash('message', $this->cluster_id ? 'Cluster actualizado correctamente.' : 'Cluster creado correctamente.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $cluster = Cluster::findOrFail($id);
        $this->cluster_id = $id;
        $this->name = $cluster->name;
        $this->address = $cluster->address;
        $this->total_units = $cluster->total_units;
        $this->common_areas = $cluster->common_areas;
        $this->maintenance_schedule = $cluster->maintenance_schedule;
        $this->parking_spaces = $cluster->parking_spaces;
        $this->residential_area_id = $cluster->residential_area_id;

        $this->openModal();
    }

    public function delete($id)
    {
        Cluster::findOrFail($id)->delete();
        session()->flash('message', 'Cluster eliminado correctamente.');
    }
}
