<div class="p-6 bg-gray-100 min-h-screen">
    <!-- Barra de búsqueda -->
    <div class="flex items-center justify-between mb-4">
        <div class="flex space-x-2">
            <input
            type="text"
            wire:model.live="search"
            placeholder="Buscar guardias..."
            class="px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300"
        />
        </div>
        <button
            wire:click="create"
            class="px-4 py-2 bg-green-600 text-white rounded-md shadow hover:bg-green-700 transition"
        >
            Crear Casa
        </button>
    </div>

    <!-- Modal -->
    @if($isOpen)
        <div class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white w-1/2 p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold mb-4">Formulario de Casa</h2>
                <form wire:submit.prevent="store" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Etiqueta:</label>
                        <input
                            type="text"
                            wire:model="label"
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300"
                        />
                        @error('label') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Propietario:</label>
                        <input
                            type="text"
                            wire:model="owner"
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300"
                        />
                        @error('owner') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Habitaciones:</label>
                            <input
                                type="number"
                                wire:model="rooms"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300"
                            />
                            @error('rooms') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Baños:</label>
                            <input
                                type="number"
                                wire:model="bathrooms"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300"
                            />
                            @error('bathrooms') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Metros cuadrados:</label>
                        <input
                            type="text"
                            wire:model="square_footage"
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300"
                        />
                        @error('square_footage') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Estado:</label>
                        <select
                            wire:model="status"
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300"
                        >
                            <option value="active">Activo</option>
                            <option value="inactive">Inactivo</option>
                        </select>
                        @error('status') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Cluster:</label>
                        <select
                            wire:model="cluster_id"
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300"
                        >
                            <option value="">Seleccione</option>
                            @foreach($clusters as $cluster)
                                <option value="{{ $cluster->id }}">{{ $cluster->name }}</option>
                            @endforeach
                        </select>
                        @error('cluster_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button
                            type="button"
                            wire:click="closeModal"
                            class="px-4 py-2 bg-gray-500 text-white rounded-md shadow hover:bg-gray-600 transition"
                        >
                            Cerrar
                        </button>
                        <button
                            type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md shadow hover:bg-blue-700 transition"
                        >
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Tabla de Casas -->
    <table class="w-full bg-white shadow rounded-lg overflow-hidden">
        <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
            <tr>
                <th class="py-3 px-6 text-left">ID</th>
                <th class="py-3 px-6 text-left">Etiqueta</th>
                <th class="py-3 px-6 text-left">Propietario</th>
                <th class="py-3 px-6 text-left">Estado</th>
                <th class="py-3 px-6 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
            @foreach($houses as $house)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left">{{ $house->id }}</td>
                    <td class="py-3 px-6 text-left">{{ $house->label }}</td>
                    <td class="py-3 px-6 text-left">{{ $house->owner }}</td>
                    <td class="py-3 px-6 text-left">{{ $house->status }}</td>
                    <td class="py-3 px-6 text-center">
                        <button
                            wire:click="edit({{ $house->id }})"
                            class="px-4 py-2 bg-yellow-500 text-white rounded-md shadow hover:bg-yellow-600 transition"
                        >
                            Editar
                        </button>
                        <button
                            wire:click="delete({{ $house->id }})"
                            class="px-4 py-2 bg-red-600 text-white rounded-md shadow hover:bg-red-700 transition"
                        >
                            Eliminar
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
