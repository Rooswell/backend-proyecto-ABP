<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrdenServicioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cliente_id' => 'sometimes|integer',
            'servicio_id' => 'sometimes|integer',
            'horario_id' => 'sometimes|integer',
            'usuario_id' => 'sometimes|integer',
            'metodo_pago' => 'sometimes|string',
            'estado' => 'sometimes|string',
            'fecha_solicitud' => 'sometimes|date',
        ];
    }
}
