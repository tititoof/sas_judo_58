<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseFormRequest extends FormRequest
{
    const REQUIRED = 'required';

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
        $course    = (null !== $this->route('course')) ? $this->route('course') : null;
        $rules = [
            'name'          => 'required|max:255',
            'season_id'     => self::REQUIRED,
            'day'           => self::REQUIRED,
            'start_at'      => self::REQUIRED,
            'end_at'        => self::REQUIRED,
            'teacher_id'    => self::REQUIRED,
            'color'         => self::REQUIRED,
        ];
        if (null !== $course) {
            $rules = array_merge($rules, ['name' => 'required|max:255|unique:courses,id,'.$course['attributes']['id'],]);
        }
        return $rules;
    }
}
