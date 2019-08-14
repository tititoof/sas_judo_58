<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JudoEventRequest extends FormRequest
{
    CONST REQUIRED = 'required';

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
        $judoevent    = (null !== $this->route('judoevent')) ? $this->route('judoevent') : null;
        $rules = [
            'name'          => 'required|max:255|unique:judo_events,name',
            'type'          => self::REQUIRED,
            'start_at'      => self::REQUIRED,
            'end_at'        => self::REQUIRED,
            'end_time_at'   => self::REQUIRED,
            'start_time_at' => self::REQUIRED,
        ];
        if (null !== $judoevent) {
            $rules = array_merge($rules, ['name' => 'required|max:255|unique:judo_events,name,'.$judoevent['attributes']['id'],]);
        }
        return $rules;
    }
}
