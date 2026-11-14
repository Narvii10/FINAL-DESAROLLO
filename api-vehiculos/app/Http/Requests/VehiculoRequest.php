<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class VehiculoRequest extends FormRequest
{
    public const ANIO_MINIMO = 1886; // año del primer automóvil

    /**
     * La API no usa autenticación: cualquiera puede enviar la petición.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación. En POST y PUT todos los campos son obligatorios;
     * en PATCH solo se validan los campos que se envíen.
     */
    public function rules(): array
    {
        $requerido = $this->isMethod('patch') ? 'sometimes' : 'required';

        return [
            'marca' => [$requerido, 'string', 'max:50'],
            'modelo' => [$requerido, 'string', 'max:50'],
            'anio' => [$requerido, 'bail', 'integer', 'min:'.self::ANIO_MINIMO, 'max:'.$this->anioMaximo()],
            'color' => [$requerido, 'string', 'max:30'],
        ];
    }

    /**
     * Mensajes de error en español.
     */
    public function messages(): array
    {
        $rango = 'El año debe estar entre '.self::ANIO_MINIMO.' y '.$this->anioMaximo().'.';

        return [
            'required' => 'El campo :attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser texto.',
            'max' => 'El campo :attribute no debe superar :max caracteres.',
            'anio.integer' => 'El campo año debe ser un número entero.',
            'anio.min' => $rango,
            'anio.max' => $rango,
        ];
    }

    public function attributes(): array
    {
        return ['anio' => 'año'];
    }

    /**
     * Si la validación falla, responde 422 con los errores en JSON.
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'mensaje' => 'Los datos enviados no son válidos.',
            'errores' => $validator->errors(),
        ], 422, [], JSON_UNESCAPED_UNICODE));
    }

    private function anioMaximo(): int
    {
        return (int) date('Y') + 1;
    }
}
