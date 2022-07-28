<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreTabloidRequest extends FormRequest
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
     * Store author_id in database based on user login.
     *
     * 
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => auth()->user()->id,
            'slug' => Str::slug($this->input('title')),
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
            'user_id' => 'exists:App\Models\User,id',
            'title' => 'required|min:5|max:255',
            'slug' => 'min:5|max:255',
            'type' => 'required|in:Kambungu,Bonebol Sepekan',
            'thumbnail' => 'required|image|max:2048',
            'file' => 'required|mimetypes:application/pdf|max:20000',
        ];
    }
}
