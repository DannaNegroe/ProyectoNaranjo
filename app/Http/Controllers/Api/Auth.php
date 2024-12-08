<?php

namespace App\Http\Controllers\Api;

// Importa la clase base para los controladores de Laravel.
use App\Http\Controllers\Controller;

// Importa el modelo 'User' para interactuar con la base de datos.
use App\Models\User;

// Importa la clase 'Request' para manejar solicitudes HTTP.
use Illuminate\Http\Request;

// Importa la clase 'Hash' para trabajar con hashes, como la verificación de contraseñas.
use Illuminate\Support\Facades\Hash;

class Auth extends Controller
{
    /**
     * Función 'auth': Autentica a un usuario mediante email y contraseña.
     *
     * @param Request $request - La solicitud HTTP que contiene los datos enviados por el cliente.
     * @return \Illuminate\Http\JsonResponse - Una respuesta en formato JSON con un token o un mensaje de error.
     */
    public function auth(Request $request)
    {
        // **1. Validación de la solicitud:**
        // La función `validate` asegura que los datos proporcionados cumplan con ciertas reglas:
        // - 'email': Obligatorio y debe ser un email válido.
        // - 'password': Obligatorio.
        $request->validate([
            'email' => 'required|email',    // Verifica que el campo email esté presente y sea válido.
            'password' => 'required'       // Verifica que el campo password esté presente.
        ]);

        // **2. Verificación del usuario:**
        // Se busca un usuario en la base de datos cuyo email coincida con el proporcionado.
        // `User::where('email', $request->email)->first()` devuelve el primer usuario que coincida o `null` si no se encuentra.
        $user = User::where('email', $request->email)->first();

        // **3. Verificación de credenciales:**
        // - Si no se encuentra un usuario (`$user` es null) o la contraseña no coincide (verificada con `Hash::check`),
        //   se retorna un mensaje de error con código HTTP 401 (Unauthorized).
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Las credenciales son incorrectas', // Mensaje de error para el cliente.
            ], 401); // Código de respuesta HTTP para error de autenticación.
        }

        // **4. Generación de un token de autenticación:**
        // - `createToken('auth_token')`: Genera un token único para este usuario con el nombre 'auth_token'.
        // - `plainTextToken`: Devuelve el token en texto plano para su uso en el cliente.
        $token = $user->createToken('auth_token')->plainTextToken;

        // **5. Respuesta exitosa:**
        // - Retorna un JSON que incluye:
        //   - `access_token`: El token generado para autenticar futuras solicitudes.
        //   - `token_type`: Especifica el tipo de token ('Bearer') que es común en APIs.
        return response()->json([
            'access_token' => $token, // Token único para identificar al usuario en solicitudes futuras.
            'token_type' => 'Bearer', // Especifica el tipo de token utilizado para autenticación.
        ]);
    }
}

/*
**Resumen de cómo funciona este controlador:**
1. La función `auth` verifica que los datos enviados en la solicitud cumplan con los requisitos.
2. Busca al usuario por email en la base de datos.
3. Comprueba que la contraseña proporcionada coincida con la almacenada.
4. Si las credenciales son correctas, genera un token único que el cliente utilizará para autenticarse en futuras solicitudes.
5. Devuelve una respuesta JSON con el token o un mensaje de error en caso de que las credenciales sean incorrectas.

**Conceptos importantes:**
- `Request`: Maneja los datos enviados desde el cliente.
- `validate`: Valida los datos antes de procesarlos para garantizar seguridad y evitar errores.
- `Hash::check`: Compara una contraseña en texto plano con su versión hasheada.
- `createToken`: Genera tokens de autenticación que siguen estándares como OAuth2.
*/
