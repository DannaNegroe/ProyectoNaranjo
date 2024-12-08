<?php

namespace App\Livewire;

use App\Models\VisitorRecord;
use App\Models\House;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class VisitorRecordCrud extends Component
{
    use WithPagination;

    public $name, $entry, $exit, $plate, $motive, $house_id;
    public $isOpen = false, $search = '', $recordId;

    protected $rules = [
        'name' => 'required|string|max:255',
        'entry' => 'required|date',
        'exit' => 'required|date|after:entry',
        'plate' => 'required|string|max:20',
        'motive' => 'nullable|string|max:255',
        'house_id' => 'required|exists:houses,id',
    ];

    // Carga los registros de visitantes con paginación
    public function render()
    {
        $query = VisitorRecord::query();

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('plate', 'like', '%' . $this->search . '%');
        }

        $visitorRecords = $query->with('house')->paginate(10);

        return view('livewire.visitor-record-crud', [
            'visitorRecords' => $visitorRecords,
            'houses' => House::all(),
        ]);
    }

    // Abre el modal para crear o editar
    public function create()
    {
        $this->resetForm();
        $this->isOpen = true;
    }

    // Establece los valores para la edición de un registro
    public function edit($id)
    {
        $visitorRecord = VisitorRecord::findOrFail($id);
        $this->name = $visitorRecord->name;
        $this->entry = Carbon::parse($visitorRecord->entry)->format('Y-m-d\TH:i');
        $this->exit = Carbon::parse($visitorRecord->exit)->format('Y-m-d\TH:i');
        $this->plate = $visitorRecord->plate;
        $this->motive = $visitorRecord->motive;
        $this->house_id = $visitorRecord->house_id;
        $this->recordId = $visitorRecord->id;
        $this->isOpen = true;
    }

    // Cierra el modal
    public function closeModal()
    {
        $this->isOpen = false;
    }

    // Guarda o actualiza el registro
    public function store()
    {
        $this->validate();

        if ($this->recordId) {
            $visitorRecord = VisitorRecord::find($this->recordId);
            $visitorRecord->update([
                'name' => $this->name,
                'entry' => $this->entry,
                'exit' => $this->exit,
                'plate' => $this->plate,
                'motive' => $this->motive,
                'house_id' => $this->house_id,
            ]);
        } else {
            VisitorRecord::create([
                'name' => $this->name,
                'entry' => $this->entry,
                'exit' => $this->exit,
                'plate' => $this->plate,
                'motive' => $this->motive,
                'house_id' => $this->house_id,
            ]);
        }

        session()->flash('message', $this->recordId ? 'Registro actualizado correctamente.' : 'Registro creado correctamente.');
        $this->closeModal();
    }

    // Elimina un registro
    public function delete($id)
    {
        VisitorRecord::find($id)->delete();
        session()->flash('message', 'Registro eliminado correctamente.');
    }

    // Restablece el formulario
    private function resetForm()
    {
        $this->name = '';
        $this->entry = '';
        $this->exit = '';
        $this->plate = '';
        $this->motive = '';
        $this->house_id = '';
        $this->recordId = null;
    }
}
