<?php

namespace App\Http\Controllers\Api;

// Importa la clase base para los controladores de Laravel.
use App\Http\Controllers\Controller;

// Importa el modelo 'Resident' para interactuar con la tabla correspondiente en la base de datos.
use App\Models\Resident;

class ResidentController extends Controller
{
    /**
     * Función 'countResidents': Cuenta el número total de residentes registrados en la base de datos.
     *
     * @return \Illuminate\Http\JsonResponse - Una respuesta en formato JSON con el total de residentes.
     */
    public function countResidents()
    {
        // **1. Cálculo del total de residentes:**
        // - `Resident::count()`: Utiliza la función `count` de Eloquent para calcular el número total de registros en la tabla asociada al modelo `Resident`.
        //   - Esta función realiza una consulta SQL equivalente a `SELECT COUNT(*) FROM residents`.
        $count = Resident::count();

        // **2. Respuesta JSON:**
        // - Construye una respuesta en formato JSON que incluye:
        //   - `total_residents`: Contiene el total de residentes obtenidos con la consulta.
        // - Retorna la respuesta con un código HTTP 200 (OK) para indicar que la solicitud fue exitosa.
        return response()->json(
            ['total_residents' => $count], // Clave 'total_residents' contiene el número total de residentes.
            200 // Código HTTP que indica éxito.
        );
    }
}

/*
**Resumen de cómo funciona este controlador:**
1. La función `countResidents` calcula el número total de registros en la tabla `residents` de la base de datos.
2. Utiliza el método `count()` del modelo `Resident` para obtener el total de registros.
3. Retorna una respuesta JSON con la clave `total_residents` y el valor del total calculado.
4. La respuesta tiene un código HTTP 200 para indicar que la operación fue exitosa.

**Conceptos importantes:**
- **Eloquent ORM:**
  - `Resident::count()`: Método que realiza una consulta SQL para contar todos los registros de la tabla asociada al modelo `Resident`.
  - Es eficiente, ya que genera una consulta directa al servidor de base de datos.

- **response()->json:**
  - Permite generar una respuesta en formato JSON que es adecuada para APIs RESTful.
  - En este caso, incluye una clave descriptiva (`total_residents`) para que el cliente entienda fácilmente el dato retornado.

- **Códigos HTTP:**
  - `200`: Se utiliza para indicar que la operación fue exitosa y que la respuesta contiene datos válidos.

**Casos de uso típicos:**
- Mostrar el número total de residentes en un panel administrativo.
- Proporcionar datos estadísticos para aplicaciones front-end.
- Implementar funciones de monitoreo o análisis que requieran conocer cuántos residentes hay registrados.
*/
