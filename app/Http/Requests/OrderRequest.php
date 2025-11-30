<?php

namespace App\Http\Requests;

use App\Traits\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class OrderRequest extends FormRequest
{
    use ApiResponseTrait;
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
        'hold_id'=>['required','exists:holds,id,status,available']
        ];
    }
     public function messages(){
        return ['hold_id.exists'=>' the hold not exist'];
    }

      protected function failedValidation(Validator $validator)
    {
        $response = $this->validationError($validator->errors());
        throw new HttpResponseException($response);
    }
}
