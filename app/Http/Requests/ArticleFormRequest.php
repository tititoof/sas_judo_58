<?php

namespace App\Http\Requests;

use App\Providers\AuthServiceProvider;
use Illuminate\Auth\Access\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ArticleFormRequest extends FormRequest
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
        $rules = [
            'name'          => 'required|max:255',
            'content'       => 'required',
            'categories'    => 'required|array',
            'albums'        => 'array'
        ];
        return $rules;
    }
}
