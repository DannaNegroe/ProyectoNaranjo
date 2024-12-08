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
            Crear Cluster
        </button>
    </div>

    <!-- Modal -->
    @if($isOpen)
        <div class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white w-1/2 p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold mb-4">Formulario de Cluster</h2>
                <form wire:submit.prevent="store" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nombre:</label>
                        <input
                            type="text"
                            wire:model="name"
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300"
                        />
                        @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Dirección:</label>
                        <input
                            type="text"
                            wire:model="address"
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300"
                        />
                        @error('address') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Total de Unidades:</label>
                        <input
                            type="number"
                            wire:model="total_units"
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300"
                        />
                        @error('total_units') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Áreas Comunes:</label>
                        <textarea
                            wire:model="common_areas"
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300"
                        ></textarea>
                        @error('common_areas') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Horario de Mantenimiento:</label>
                        <input
                            type="text"
                            wire:model="maintenance_schedule"
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300"
                        />
                        @error('maintenance_schedule') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Espacios de Estacionamiento:</label>
                        <input
                            type="number"
                            wire:model="parking_spaces"
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300"
                        />
                        @error('parking_spaces') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Área Residencial:</label>
                        <input
                            type="text"
                            wire:model="residential_area_id"
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300"
                        />
                        @error('residential_area_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
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

    <!-- Tabla de Clusters -->
    <table class="w-full bg-white shadow rounded-lg overflow-hidden">
        <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
            <tr>
                <th class="py-3 px-6 text-left">ID</th>
                <th class="py-3 px-6 text-left">Nombre</th>
                <th class="py-3 px-6 text-left">Dirección</th>
                <th class="py-3 px-6 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
            @foreach($clusters as $cluster)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left">{{ $cluster->id }}</td>
                    <td class="py-3 px-6 text-left">{{ $cluster->name }}</td>
                    <td class="py-3 px-6 text-left">{{ $cluster->address }}</td>
                    <td class="py-3 px-6 text-center">
                        <button
                            wire:click="edit({{ $cluster->id }})"
                            class="px-4 py-2 bg-yellow-500 text-white rounded-md shadow hover:bg-yellow-600 transition"
                        >
                            Editar
                        </button>
                        <button
                            wire:click="delete({{ $cluster->id }})"
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
