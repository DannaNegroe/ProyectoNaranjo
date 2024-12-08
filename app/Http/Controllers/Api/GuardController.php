<?php

namespace App\Http\Controllers\Api;

// Importa la clase base para los controladores de Laravel.
use App\Http\Controllers\Controller;

// Importa el modelo 'Guard' para interactuar con la tabla correspondiente en la base de datos.
use App\Models\Guard;

// Importa la clase 'JsonResponse' para especificar el tipo de respuesta que retorna la función.
use Illuminate\Http\JsonResponse;

class GuardController extends Controller
{
    /**
     * Función 'getContactInfo': Obtiene la información de contacto de un guardia específico mediante su ID.
     *
     * @param int $id - El ID del guardia a buscar.
     * @return JsonResponse - Una respuesta en formato JSON con la información de contacto o un mensaje de error.
     */
    public function getContactInfo($id): JsonResponse
    {
        // **1. Búsqueda del guardia por ID:**
        // - `Guard::find($id)`: Busca en la base de datos un registro en la tabla 'guards' con el ID proporcionado.
        // - Si el registro no se encuentra, la función devuelve `null`.
        $guard = Guard::find($id);

        // **2. Verificación de la existencia del guardia:**
        // - Si `$guard` es `null`, significa que no se encontró un guardia con ese ID en la base de datos.
        // - En este caso, se retorna una respuesta JSON con un mensaje de error y un código HTTP 404.
        if (!$guard) {
            return response()->json([
                'message' => 'Guard not found' // Mensaje que indica que el guardia no fue encontrado.
            ], 404); // Código HTTP para recurso no encontrado.
        }

        // **3. Retorno de la información de contacto:**
        // - Si el guardia existe, se construye una respuesta JSON que incluye:
        //   - `name`: El nombre del guardia.
        //   - `phone`: El número de teléfono del guardia.
        //   - `email`: El correo electrónico del guardia.
        return response()->json([
            'name' => $guard->name,   // Nombre del guardia.
            'phone' => $guard->phone, // Teléfono del guardia.
            'email' => $guard->email, // Email del guardia.
        ]);
    }
}

/*
**Resumen de cómo funciona este controlador:**
1. La función `getContactInfo` recibe como parámetro el ID de un guardia.
2. Utiliza el modelo `Guard` para buscar el registro correspondiente en la base de datos.
   - Si no encuentra un guardia con ese ID, devuelve un mensaje de error con código 404.
3. Si encuentra el registro, extrae las propiedades `name`, `phone` y `email` del guardia y las retorna en una respuesta JSON.

**Conceptos importantes:**
- `Guard::find($id)`: Busca un registro en la tabla asociada al modelo `Guard` según su ID. Devuelve `null` si no se encuentra.
- `response()->json`: Permite construir respuestas en formato JSON que son fáciles de consumir por APIs o clientes.
- Verificación con `if (!$guard)`: Asegura que se manejen correctamente los casos en los que el recurso solicitado no existe.
- Respuestas HTTP:
  - 404: Se utiliza cuando no se encuentra el guardia en la base de datos.
  - 200: Es el código implícito cuando se retorna la información de contacto del guardia exitosamente.
- JSON: Es el formato estándar utilizado para comunicar datos entre el servidor y los clientes.
*/
