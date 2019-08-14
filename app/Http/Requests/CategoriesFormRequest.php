<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriesFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $category    = (null !== $this->route('category')) ? $this->route('category') : null;
        $rules = [
            'name'      => 'required|max:255|unique:categories,name',
            'type'      => 'required',
        ];
        if (null !== $category) {
            $rules = array_merge($rules, ['name' => 'required|max:255|unique:categories,name,'.$category['attributes']['id'],]);
        }
        return $rules;
    }
}
