<?php

namespace App\Http\Requests\Nhtsa;

use Illuminate\Foundation\Http\FormRequest;

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
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'modelYear' => 'required',
            'manufacturer' => 'required',
            'model' => 'required',
        ];
    }
}