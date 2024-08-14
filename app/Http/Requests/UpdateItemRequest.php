<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int    $id
 * @property string $name
 * @property int    $stock
 * @property string $sku
 * @property float  $retail_price
 * @property int    $user_id
 * @property int    $reorder_level
 */
class UpdateItemRequest extends FormRequest
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
        if($this->method() == 'PUT'){
            return [
                'userId' => 'required|numeric',
                'name' => 'required|string|max:60',
                'stock' => 'required|numeric',
                'sku' => 'unique:items,sku|string|max:45',
                'reorderLevel' => 'required|numeric',
            ];

        }else{
            return [
                'userId' => 'sometimes|numeric',
                'name' => 'sometimes|string|max:60',
                'stock' => 'sometimes|numeric',
                'sku' => 'sometimes|unique:items,sku|string|max:45',
                'reorderLevel' => 'sometimes|numeric',
            ];
        }
    }

    /**
     * @return void
     */
    public function prepareForValidation(): void
    {
        if($this->reorderLevel){
            $this->merge([
               'reorder_level' => $this->reorderLevel
            ]);
        }
        if($this->userId){
            $this->merge([
               'user_id' => $this->userId
            ]);
        }


    }
}
