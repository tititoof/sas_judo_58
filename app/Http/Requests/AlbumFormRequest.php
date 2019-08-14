<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlbumFormRequest extends FormRequest
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
        $album    = (null !== $this->route('album')) ? $this->route('album') : null;
        $rules = [
            'name'       => 'required|max:255|unique:albums,name',
            'pictures'   => 'required',
        ];
        if (null !== $album) {
            $rules = array_merge($rules, ['name' => 'required|max:255|unique:articles,name,'.$album['attributes']['id'],]);
        }
        return $rules;
    }
}
