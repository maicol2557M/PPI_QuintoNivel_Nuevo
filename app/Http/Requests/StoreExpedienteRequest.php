<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreExpedienteRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a realizar esta petición.
     */
    public function authorize(): bool
    {
        // Debes cambiar esto a 'true' si usas autenticación o a una lógica de roles.
        // Por ahora, lo dejamos en true para probar.
        return true;
    }

    /**
     * Obtiene las reglas de validación que se aplican a la petición.
     */
    public function rules(): array
    {
        return [
            // =========================================================
            // A. VALIDACIÓN DEL EXPEDIENTE PRINCIPAL (Tabla expedientes)
            // =========================================================
            'num_expediente_interno' => ['required', 'string', 'max:50', 'unique:expedientes,num_expediente_interno'],
            'num_judicial' => ['nullable', 'string', 'max:50'],
            'juzgado_tribunal' => ['required', 'string', 'max:100'],
            'materia' => ['required', 'string', 'max:50'],
            'tipo_procedimiento' => ['required', 'string', 'max:50'],
            'fecha_inicio' => ['required', 'date'],
            'estado_flujo' => ['required', Rule::in(['Abierto', 'En Litigio', 'Suspendido', 'Cerrado', 'Archivado'])],
            'cuantia' => ['nullable', 'numeric', 'between:0,9999999999999.99'], // Ajusta el rango si es necesario
            'resumen_asunto' => ['nullable', 'string'],
            'fecha_ultima_actuacion' => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
            'ubicacion_archivo' => ['nullable', 'string', 'max:100'],
            'observaciones_internas' => ['nullable', 'string'],

            // =========================================================
            // B. VALIDACIÓN DE PARTES INVOLUCRADAS (Arrays M:N)
            // =========================================================
            'partes' => 'required|array|min:1',
        'partes.*.nombre_razonsocial' => 'required|string|max:255',
        'partes.*.ruc_cc' => 'required|string|max:20',
        'partes.*.rol_en_caso' => 'required|string|max:100',
        'partes.*.posicion_procesal' => 'required|string|max:100',
        'partes.*.tipo_persona' => 'sometimes|in:Física,Jurídica',
        'partes.*.telefono' => 'nullable|string|max:20',
        'partes.*.email' => 'nullable|email|max:100',
        'partes.*.domicilio_completo' => 'nullable|string|max:255',

            // =========================================================
            // C. VALIDACIÓN DE PLAZOS Y ACTUACIONES (Arrays 1:M)
            // =========================================================
            'plazos' => ['nullable', 'array'],
            'plazos.*.descripcion_actuacion' => ['required', 'string', 'max:255'],
            'plazos.*.fecha_limite' => ['required', 'date', 'after:today'], // Debe ser en el futuro
            'plazos.*.responsable' => ['required', 'string', 'max:100'],
            'plazos.*.estado' => ['required', Rule::in(['Pendiente', 'Completado', 'Vencido'])],
            'plazos.*.notas' => ['nullable', 'string'],

            // =========================================================
            // D. VALIDACIÓN DE DOCUMENTOS DIGITALES
            // =========================================================
            'documentos' => ['nullable', 'array', 'max:5'], // Máximo 5 archivos por carga
            'documentos.*' => ['file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:10240'], // 10MB máximo por archivo
            'descripcion_documentos' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Personaliza los mensajes de error.
     */
    public function messages()
    {
        return [
            'partes.required' => 'Debe ingresar al menos una parte (Cliente/Demandado) para el expediente.',
            'num_expediente_interno.unique' => 'Este número de expediente interno ya ha sido registrado.',
            'partes.*.ruc_cc.required' => 'El campo RUC/Cédula es obligatorio para cada parte.',
            'plazos.*.fecha_limite.after' => 'La fecha límite de la actuación debe ser una fecha futura.'
            // Puedes agregar más mensajes personalizados aquí
        ];
    }
}
