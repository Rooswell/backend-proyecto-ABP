<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $query = Servicio::query();

        if ($search !== '') {
            $query->where('nombre_servicio', 'ilike', "%{$search}%")
                ->orWhere('tipo', 'ilike', "%{$search}%")
                ->orWhere('descripcion', 'ilike', "%{$search}%");
        }

        return response()->json([
            'data' => $query->orderBy('nombre_servicio')->get(),
        ]);
    }

    public function show(int $id_servicio)
    {
        $servicio = Servicio::find($id_servicio);

        if (!$servicio) {
            return response()->json(['message' => 'Servicio no encontrado'], 404);
        }

        return response()->json(['data' => $servicio]);
    }

    public function store(Request $request)
    {
        if (empty($request->all())) {
            return response()->json([
                'message' => 'El cuerpo de la solicitud no puede estar vacío',
            ], 422);
        }

        $validated = $request->validate($this->storeRules());

        $servicio = Servicio::create($validated);

        return response()->json(['message' => 'Servicio creado', 'data' => $servicio], 201);
    }

    public function update(Request $request, int $id_servicio)
    {
        $servicio = Servicio::find($id_servicio);

        if (!$servicio) {
            return response()->json(['message' => 'Servicio no encontrado'], 404);
        }

        $validated = $request->validate($this->updateRules());

        $servicio->update($validated);

        return response()->json(['message' => 'Servicio actualizado', 'data' => $servicio]);
    }

    public function destroy(int $id_servicio)
    {
        $servicio = Servicio::find($id_servicio);

        if (!$servicio) {
            return response()->json(['message' => 'Servicio no encontrado'], 404);
        }

        $servicio->delete();

        return response()->json(['message' => 'Servicio eliminado']);
    }

    private function storeRules(): array
    {
        return [
            'nombre_servicio' => 'required|string|max:100',
            'tipo' => 'nullable|string|max:50',
            'costo' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
        ];
    }

    private function updateRules(): array
    {
        return [
            'nombre_servicio' => 'sometimes|required|string|max:100',
            'tipo' => 'sometimes|nullable|string|max:50',
            'costo' => 'sometimes|required|numeric|min:0',
            'descripcion' => 'sometimes|nullable|string',
        ];
    }
}
