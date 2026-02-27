<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Horario;
use App\Http\Requests\StoreHorarioRequest;
use App\Http\Requests\UpdateHorarioRequest;

class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
    {
        $q = Horario::query()->orderBy('codigo');

        if ($request->filled('estado')) {
            $q->where('estado', $request->string('estado'));
        }
        if ($request->filled('dia_semana')) {
            $q->where('dia_semana', $request->string('dia_semana'));
        }
        if ($request->filled('usuario_id')) {
            $q->where('usuario_id', (int)$request->input('usuario_id'));
        }
        if ($request->filled('fecha')) {
            $q->whereDate('fecha', $request->input('fecha'));
        }

        return response()->json($q->paginate(10));
    }

    public function store(StoreHorarioRequest $request)
    {
        $data = $request->validated();
        $data['estado'] = $data['estado'] ?? 'Disponible';

        // Generar código único: H-timestamp
        $data['codigo'] = 'H-' . time();

        $horario = Horario::create($data);

        return response()->json($horario, 201);
    }

    public function show(int $id)
    {
        return response()->json(Horario::findOrFail($id));
    }

    public function update(UpdateHorarioRequest $request, int $id)
    {
        $horario = Horario::findOrFail($id);
        $horario->update($request->validated());

        return response()->json($horario->fresh());
    }

    public function destroy(int $id)
    {
        Horario::findOrFail($id)->delete();
        return response()->json(['message' => 'OK']);
    }
}
