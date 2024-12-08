<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Guard;
use App\Models\Cluster;

class GuardCrud extends Component
{
    public $guards, $guard_id, $name, $email, $phone, $shift, $cluster_id;
    public $isOpen = false;
    public $search = '';

    public function render()
    {
        $query = Guard::with('cluster');

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
        }

        $this->guards = $query->get();
        $clusters = Cluster::all();
        return view('livewire.guard-crud', ['clusters' => $clusters]);
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
        $this->guard_id = null;
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->shift = '';
        $this->cluster_id = '';
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'shift' => 'required|in:day,night',
            'cluster_id' => 'required|exists:clusters,id',
        ]);

        Guard::updateOrCreate(['id' => $this->guard_id], [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'shift' => $this->shift,
            'cluster_id' => $this->cluster_id,
        ]);

        session()->flash('message', $this->guard_id ? 'Guardia actualizado correctamente.' : 'Guardia creado correctamente.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $guard = Guard::findOrFail($id);
        $this->guard_id = $id;
        $this->name = $guard->name;
        $this->email = $guard->email;
        $this->phone = $guard->phone;
        $this->shift = $guard->shift;
        $this->cluster_id = $guard->cluster_id;

        $this->openModal();
    }

    public function delete($id)
    {
        Guard::findOrFail($id)->delete();
        session()->flash('message', 'Guardia eliminado correctamente.');
    }


}
