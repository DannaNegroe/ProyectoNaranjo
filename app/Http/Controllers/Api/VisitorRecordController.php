<?php

namespace App\Http\Controllers\Api;

// Importa la clase base para controladores de Laravel.
use App\Http\Controllers\Controller;

// Importa el modelo 'VisitorRecord' para interactuar con la tabla correspondiente en la base de datos.
use App\Models\VisitorRecord;

// Importa la clase 'Request' para manejar solicitudes HTTP.
use Illuminate\Http\Request;

class VisitorRecordController extends Controller
{
    /**
     * Función 'createVisitorRecord': Crea un nuevo registro de visitante asociado a una casa específica.
     *
     * @param Request $request - Objeto que contiene los datos enviados por el cliente.
     * @param int $house_id - ID de la casa asociada al visitante.
     * @return \Illuminate\Http\JsonResponse - Una respuesta en formato JSON que confirma la creación del registro.
     */
    public function createVisitorRecord(Request $request, $house_id)
    {
        // **1. Validación de datos:**
        // - `validate()`: Valida los datos enviados en la solicitud.
        // - Reglas de validación:
        //   - `name`: Obligatorio, debe ser una cadena con un máximo de 255 caracteres.
        //   - `entry`: Obligatorio, debe ser una fecha válida.
        //   - `exit`: Opcional, debe ser una fecha válida y posterior o igual a la entrada.
        //   - `plate`: Opcional, debe ser una cadena con un máximo de 10 caracteres (ejemplo: placas de autos).
        //   - `motive`: Obligatorio, debe ser una cadena con un máximo de 255 caracteres que explique el motivo de la visita.
        $validated = $request->validate([
            'name' => 'required|string|max:255',        // Nombre del visitante.
            'entry' => 'required|date',                // Fecha de entrada obligatoria.
            'exit' => 'nullable|date|after_or_equal:entry', // Fecha de salida opcional, pero debe ser igual o posterior a la entrada.
            'plate' => 'nullable|string|max:10',       // Placas del vehículo, si aplica.
            'motive' => 'required|string|max:255',     // Motivo de la visita.
        ]);

        // **2. Agregar el ID de la casa al registro validado:**
        // - `house_id`: Este campo se agrega al arreglo validado para asociar el visitante con una casa específica.
        $validated['house_id'] = $house_id;

        // **3. Creación del registro de visitante:**
        // - `VisitorRecord::create($validated)`: Crea un nuevo registro en la base de datos con los datos validados.
        // - Devuelve una instancia del modelo `VisitorRecord` que representa el registro recién creado.
        $visitorRecord = VisitorRecord::create($validated);

        // **4. Respuesta JSON:**
        // - Devuelve una respuesta en formato JSON que confirma la creación del registro.
        // - Incluye:
        //   - `message`: Mensaje de confirmación.
        //   - `visitor`: Detalles del registro recién creado.
        // - Código HTTP 201 (Created): Indica que se ha creado un recurso exitosamente.
        return response()->json(
            [
                'message' => 'Visitor record created successfully.', // Mensaje de éxito.
                'visitor' => $visitorRecord, // Información del registro recién creado.
            ],
            201 // Código HTTP para creación exitosa.
        );
    }
}

/*
**Resumen de cómo funciona este controlador:**
1. La función `createVisitorRecord` recibe los datos del visitante y el ID de la casa como parámetros.
2. Valida los datos del visitante utilizando reglas específicas para asegurar que sean correctos y completos.
3. Agrega el `house_id` al conjunto de datos validados para asociar al visitante con una casa específica.
4. Utiliza el modelo `VisitorRecord` para crear un nuevo registro en la base de datos.
5. Devuelve una respuesta JSON con un mensaje de éxito y los detalles del registro recién creado.

**Conceptos importantes:**
- **Validación de datos:**
  - `required`: Indica que un campo es obligatorio.
  - `nullable`: Permite que un campo sea opcional.
  - `after_or_equal:entry`: Asegura que la fecha de salida no sea anterior a la de entrada.
  - `max:255`: Restringe la longitud de cadenas para evitar entradas excesivas.

- **Eloquent ORM:**
  - `VisitorRecord::create($validated)`: Inserta un nuevo registro en la tabla asociada al modelo `VisitorRecord` utilizando los datos validados.

- **Respuestas HTTP:**
  - `201 Created`: Se utiliza para confirmar que un recurso ha sido creado exitosamente.

**Casos de uso típicos:**
- Registrar visitas de personas a propiedades o viviendas.
- Asociar registros de visitantes con casas específicas en un sistema de gestión residencial.
- Proporcionar datos a sistemas de monitoreo o seguridad.
*/
