<?php

namespace App\Http\Requests;

use App\Traits\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class WebhookRequest extends FormRequest
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
            'order_id'=>['required'],
            'status'=>['required','string'],
            'idempotency_key'=>['required']

        ];
    }
    public function messages(){
        return ['order_id.exists'=>'the order not exist'];
    }

      protected function failedValidation(Validator $validator)
    {
        $response = $this->validationError($validator->errors());
        throw new HttpResponseException($response);
    }
}
