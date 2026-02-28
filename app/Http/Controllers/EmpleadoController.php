<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $query = Empleado::query();

        if ($search !== '') {
            $query->where('cedula_usuario', 'ilike', "%{$search}%");
        }

        return response()->json([
            'data' => $query->orderBy('cedula_usuario')->get(),
        ]);
    }

    public function show(string $cedula)
    {
        $empleado = Empleado::find($cedula);

        if (!$empleado) {
            return response()->json(['message' => 'Empleado no encontrado'], 404);
        }

        return response()->json(['data' => $empleado]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            $this->storeRules(),
            $this->storeMessages(),
            $this->validationAttributes()
        );

        $empleado = Empleado::create([
            'cedula_usuario' => $validated['cedula_usuario'],
            'rol' => 'EMPLEADO',
        ]);

        return response()->json(['message' => 'Empleado creado', 'data' => $empleado], 201);
    }

    public function update(Request $request, string $cedula)
    {
        $empleado = Empleado::find($cedula);

        if (!$empleado) {
            return response()->json(['message' => 'Empleado no encontrado'], 404);
        }

        $request->validate(
            $this->updateRules(),
            $this->updateMessages(),
            $this->validationAttributes()
        );

        $empleado->update(['rol' => 'EMPLEADO']);

        return response()->json(['message' => 'Empleado actualizado', 'data' => $empleado]);
    }

    public function destroy(string $cedula)
    {
        $empleado = Empleado::find($cedula);

        if (!$empleado) {
            return response()->json(['message' => 'Empleado no encontrado'], 404);
        }

        $empleado->delete();

        return response()->json(['message' => 'Empleado eliminado']);
    }

    private function storeRules(): array
    {
        return [
            'cedula_usuario' => 'required|string|size:10|unique:empleados,cedula_usuario',
            'rol' => 'prohibited',
        ];
    }

    private function storeMessages(): array
    {
        return [
            'cedula_usuario.unique' => 'La cédula ya está registrada.',
            'rol.prohibited' => 'El rol se asigna automáticamente como EMPLEADO.',
        ];
    }

    private function updateRules(): array
    {
        return [
            'cedula_usuario' => 'prohibited',
            'rol' => 'prohibited',
        ];
    }

    private function updateMessages(): array
    {
        return [
            'cedula_usuario.prohibited' => 'La cédula no se puede modificar.',
            'rol.prohibited' => 'El rol se mantiene fijo como EMPLEADO.',
        ];
    }

    private function validationAttributes(): array
    {
        return [
            'cedula_usuario' => 'cédula',
            'rol' => 'rol',
        ];
    }
}