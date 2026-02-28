<?php

namespace App\Http\Controllers;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{

    public function index(Request $request)
        {
            // opcional: búsqueda por ?search=
            $search = trim((string) $request->query('search', ''));

            $q = Usuario::query();

            if ($search !== '') {
                $q->where('cedula_usuario', 'ilike', "%{$search}%")
                    ->orWhere('nombre_usuario', 'ilike', "%{$search}%")
                    ->orWhere('email_usuario', 'ilike', "%{$search}%");
            }

            // puedes devolver todo (simple) o paginado
            return response()->json([
                'data' => $q->orderBy('nombre_usuario')->get()
            ]);
        }
    
        public function show(string $cedula)
        {
            $usuario = Usuario::find($cedula);

            if (!$usuario) {
                return response()->json(['message' => 'Usuario no encontrado'], 404);
            }

            return response()->json(['data' => $usuario]);
        }


        public function store(Request $request)
        {
            if (empty($request->all())) {
                return response()->json([
                    'message' => 'El cuerpo de la solicitud no puede estar vacío',
                ], 422);
            }

            $validated = $request->validate($this->storeRules());

            // PK duplicada
            if (Usuario::find($validated['cedula_usuario'])) {
                return response()->json(['message' => 'La cédula ya está registrada'], 409);
            }

            $usuario = Usuario::create($validated);

            return response()->json(['message' => 'Usuario creado', 'data' => $usuario], 201);
        }

        public function update(Request $request, string $cedula)
        {
            $usuario = Usuario::find($cedula);

            if (!$usuario) {
                return response()->json(['message' => 'Usuario no encontrado'], 404);
            }

            $validated = $request->validate($this->updateRules());

            $usuario->update($validated);

            return response()->json(['message' => 'Usuario actualizado', 'data' => $usuario]);
        }

        public function destroy(string $cedula)
        {
            $usuario = Usuario::find($cedula);

            if (!$usuario) {
                return response()->json(['message' => 'Usuario no encontrado'], 404);
            }

            $usuario->delete();

            return response()->json(['message' => 'Usuario eliminado']);
        }

        private function storeRules(): array
        {
            return [
                'cedula_usuario' => 'required|string|size:10',
                'nombre_usuario' => 'required|string|max:100',
                'email_usuario' => 'nullable|email|max:100',
                'contrasena' => 'required|string|min:6',
                'sexo' => 'nullable|in:M,F,O',
                'numero_telefono_usuario' => 'nullable|string|max:20',
                'estado' => 'nullable|in:activo,inactivo'
            ];
        }

        private function updateRules(): array
        {
            return [
                'nombre_usuario' => 'sometimes|required|string|max:100',
                'email_usuario' => 'sometimes|nullable|email|max:100',
                'contrasena' => 'sometimes|required|string|min:6',
                'sexo' => 'sometimes|nullable|in:M,F,O',
                'numero_telefono_usuario' => 'sometimes|nullable|string|max:20',
                'estado' => 'sometimes|nullable|in:activo,inactivo'
            ];
        }
}
