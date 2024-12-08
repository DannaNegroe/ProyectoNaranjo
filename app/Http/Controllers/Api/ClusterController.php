<?php

namespace App\Http\Controllers\Api;

// Importa la clase base para los controladores de Laravel.
use App\Http\Controllers\Controller;

// Importa el modelo 'Cluster' para interactuar con la tabla correspondiente en la base de datos.
use App\Models\Cluster;

class ClusterController extends Controller
{
    /**
     * Función 'isMaintenanceTime': Verifica si un clúster tiene un horario de mantenimiento definido.
     *
     * @param int $cluster_id - ID del clúster a consultar.
     * @return \Illuminate\Http\JsonResponse - Una respuesta en formato JSON con el horario de mantenimiento o un mensaje de error.
     */
    public function isMaintenanceTime($cluster_id)
    {
        // **1. Búsqueda del clúster:**
        // - `Cluster::findOrFail($cluster_id)`: Busca un registro en la base de datos por su ID.
        //   - Si no se encuentra un clúster con el ID proporcionado, Laravel automáticamente lanza una excepción `ModelNotFoundException` y retorna un error 404.
        $cluster = Cluster::findOrFail($cluster_id);

        // **2. Obtención del horario de mantenimiento:**
        // - Accede a la propiedad `maintenance_schedule` del modelo `Cluster`, que contiene el horario de mantenimiento del clúster.
        $maintenanceTime = $cluster->maintenance_schedule;

        // **3. Verificación de la existencia del horario de mantenimiento:**
        // - Si la propiedad `maintenance_schedule` está vacía o es null, significa que el clúster no tiene un horario definido.
        //   - En este caso, se retorna un mensaje de error con un código HTTP 404.
        if (!$maintenanceTime) {
            return response()->json(
                ['message' => 'El cluster no tiene un horario de mantenimiento definido.'], // Mensaje para el cliente.
                404 // Código HTTP para recurso no encontrado.
            );
        }

        // **4. Generación del mensaje:**
        // - Si el clúster tiene un horario definido, se construye un mensaje que incluye:
        //   - El nombre del clúster (`$cluster->name`).
        //   - Su horario de mantenimiento (`$maintenanceTime`).
        $message = "El horario del cluster '{$cluster->name}' es el siguiente: {$maintenanceTime}";

        // **5. Respuesta exitosa:**
        // - Retorna un JSON con el mensaje y un código HTTP 200 (OK).
        return response()->json(
            ['message' => $message], // Mensaje para el cliente.
            200 // Código HTTP para éxito.
        );
    }
}

/*
**Resumen del controlador y su funcionalidad:**
1. La función `isMaintenanceTime` permite consultar el horario de mantenimiento de un clúster específico.
2. Primero busca el clúster en la base de datos usando su ID.
   - Si no se encuentra, retorna automáticamente un error 404.
3. Verifica si el clúster tiene un horario de mantenimiento definido:
   - Si no lo tiene, retorna un mensaje de error con código 404.
   - Si lo tiene, genera un mensaje indicando el horario y lo retorna con código 200.

**Conceptos importantes:**
- `findOrFail`: Busca un registro por ID y lanza un error 404 si no existe.
- `response()->json`: Genera una respuesta JSON para el cliente.
- Propiedades del modelo: Se accede a los datos del clúster a través de sus propiedades como `maintenance_schedule` o `name`.
- Códigos HTTP:
  - 404: Indica que el recurso solicitado (clúster o información) no fue encontrado.
  - 200: Indica que la solicitud fue exitosa.
*/
