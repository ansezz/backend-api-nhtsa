<?php

namespace App\Http\Requests\Nhtsa;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;

/**
 * @property mixed modelYear
 * @property mixed manufacturer
 * @property mixed model
 */
class VehiclesPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'modelYear' => 'required',
            'manufacturer' => 'required',
            'model' => 'required',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function failedValidation(Validator $validator): JsonResponse
    {
        return response()->json(
            [
                'Count' => 0,
                'Results' => []
            ]
        );
    }
}
