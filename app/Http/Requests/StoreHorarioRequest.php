<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHorarioRequest extends FormRequest
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
            'dia_semana'  => ['required','string','in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo'],
            'hora_inicio' => ['required','date_format:H:i'],
            'hora_fin'    => ['required','date_format:H:i'],
            'estado'      => ['nullable','string','in:Disponible,Ocupado'],

            'usuario_id'  => ['nullable','string','exists:usuarios,cedula_usuario'],
            'fecha'       => ['nullable','date'],
        ];
    }
}
