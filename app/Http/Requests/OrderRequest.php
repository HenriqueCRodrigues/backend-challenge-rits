<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
{

    public function all($keys = null)
    {
        $data = parent::all();
        $data['customer_id'] = $this->route('customerId');

        return $data;
    }

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
            'status' => 'required',
            'customer_id' => 'required|exists:customers,id',
            'products' => 'required|array',
            'products.*.id' => 'exists:products,id'
        ];
    }
}
