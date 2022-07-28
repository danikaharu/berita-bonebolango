<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreCategoryRequest extends FormRequest
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
     * Store slug in database based on input title.
     *
     * 
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => Str::slug($this->input('title'))
        ]);
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:5|max:255',
            'slug' => 'min:5|max:255',
            'description' => 'required',
        ];
    }
}
