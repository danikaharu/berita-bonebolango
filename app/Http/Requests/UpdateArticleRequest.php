<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateArticleRequest extends FormRequest
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
            'category_id' => 'required|exists:App\Models\Category,id',
            'title' => 'required|min:5|max:255',
            'slug' => 'min:5',
            'body' => 'required',
            'tags' => 'required',
            'thumbnail' => 'nullable|image|max:2048',
            'caption' => 'required|min:5|max:255',
            'status' => 'required|in:Draft,Published',
            'published_at' => 'required',
        ];
    }
}
