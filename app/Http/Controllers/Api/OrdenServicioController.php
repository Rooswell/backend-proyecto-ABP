<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrdenServicioRequest;
use App\Http\Requests\UpdateOrdenServicioRequest;
use App\Models\OrdenServicio;
use Illuminate\Http\Request;

class OrdenServicioController extends Controller
{
    public function index(Request $request)
    {
        $q = OrdenServicio::query()
            ->with(['cliente', 'usuario'])
            ->orderByDesc('id');

        if ($request->filled('estado')) {
            $q->where('estado', $request->string('estado'));
        }

        if ($request->filled('cliente_id')) {
            $q->where('cliente_id', (int) $request->input('cliente_id'));
        }

        return response()->json($q->paginate(10));
    }

    public function store(StoreOrdenServicioRequest $request)
    {
        $data = $request->validated();

        $data['estado'] = $data['estado'] ?? 'Pendiente';

        $next = ((int) (OrdenServicio::max('id') ?? 0)) + 1;
        $data['codigo'] = 'SRV-' . str_pad((string) $next, 3, '0', STR_PAD_LEFT);

        $orden = OrdenServicio::create($data);

        return response()->json(
            $orden->load(['cliente', 'usuario']),
            201
        );
    }

    public function show(int $id)
    {
        $orden = OrdenServicio::with(['cliente', 'usuario'])
            ->findOrFail($id);

        return response()->json($orden);
    }

    public function update(UpdateOrdenServicioRequest $request, int $id)
    {
        $orden = OrdenServicio::findOrFail($id);
        $orden->update($request->validated());

        return response()->json(
            $orden->fresh()->load(['cliente', 'usuario'])
        );
    }

    public function destroy(int $id)
    {
        OrdenServicio::findOrFail($id)->delete();
        return response()->json(['message' => 'OK']);
    }
}