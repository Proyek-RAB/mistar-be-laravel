<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInfrastructureRequest extends FormRequest
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
            'name' => 'string|required',
            'type' => 'string|required|in:Titik,Garis,Bidang',
            'sub_type' => 'string|required|in:Air Bersih,Air Kotor (Jamban),Persampahan,Jalan & Drainase,Lahan Parkir',
            'detail' => 'required',
        ];
    }
}
