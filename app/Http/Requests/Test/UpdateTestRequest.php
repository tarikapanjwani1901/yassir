<?php

namespace App\Http\Requests\Test;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Test\Test;

class UpdateTestRequest extends FormRequest
{

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
        return Test::$rules;
    }
}
