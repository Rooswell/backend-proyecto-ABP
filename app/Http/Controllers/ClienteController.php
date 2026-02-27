<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        // opcional: búsqueda por ?search=
        $search = trim((string) $request->query('search', ''));

        $q = Cliente::query();

        if ($search !== '') {
            $q->where('cedula_cliente', 'ilike', "%{$search}%")
                ->orWhere('nombre_cliente', 'ilike', "%{$search}%")
                ->orWhere('email_cliente', 'ilike', "%{$search}%");
        }

        // puedes devolver todo (simple) o paginado
        return response()->json([
            'data' => $q->orderBy('nombre_cliente')->get()
        ]);
    }

    public function show(string $cedula)
    {
        $cliente = Cliente::find($cedula);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        return response()->json(['data' => $cliente]);
    }

    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'cedula_cliente'          => ['required', 'string', 'size:10'],
            'nombre_cliente'          => ['required', 'string', 'max:100'],
            'email_cliente'           => ['nullable', 'email', 'max:100'],
            'sexo_cliente'            => ['nullable', 'in:M,F,O'],
            'direccion_cliente'       => ['nullable', 'string', 'max:150'],
            'numero_telefono_cliente' => ['nullable', 'string', 'max:20'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'message' => 'Datos inválidos',
                'errors' => $v->errors(),
            ], 422);
        }

        // PK duplicada
        if (Cliente::find($request->cedula_cliente)) {
            return response()->json(['message' => 'Ya existe un cliente con esa cédula'], 409);
        }

        $cliente = Cliente::create($v->validated());

        return response()->json([
            'message' => 'Cliente creado',
            'data' => $cliente,
        ], 201);
    }

    public function update(Request $request, string $cedula)
    {
        $cliente = Cliente::find($cedula);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        $v = Validator::make($request->all(), [
            // cedula_cliente NO se actualiza (es PK)
            'nombre_cliente'          => ['sometimes', 'required', 'string', 'max:100'],
            'email_cliente'           => ['sometimes', 'nullable', 'email', 'max:100'],
            'sexo_cliente'            => ['sometimes', 'nullable', 'in:M,F,O'],
            'direccion_cliente'       => ['sometimes', 'nullable', 'string', 'max:150'],
            'numero_telefono_cliente' => ['sometimes', 'nullable', 'string', 'max:20'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'message' => 'Datos inválidos',
                'errors' => $v->errors(),
            ], 422);
        }

        $cliente->fill($v->validated());
        $cliente->save();

        return response()->json([
            'message' => 'Cliente actualizado',
            'data' => $cliente,
        ]);
    }

    public function destroy(string $cedula)
    {
        $cliente = Cliente::find($cedula);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        $cliente->delete();

        return response()->json(['message' => 'Cliente eliminado']);
    }
}
