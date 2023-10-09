<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        return isset($user)
            && $user->tokenCan('blog:update')
            && $user->id === $this->route('blog')->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->method() == 'PUT') {
            return [
                'title' => ['required'],
                'body' => ['required'],
                'categoryId' => ['required', 'exists:categories,id'],
            ];
        } else if ($this->method() == 'PATCH') {
            return [
                'title' => ['sometimes'],
                'body' => ['sometimes'],
                'categoryId' => ['sometimes', 'exists:categories,id'],
            ];
        }
    }

    protected function prepareForValidation(): void
    {
        if ($this->categoryId) {
            $this->merge([
                'category_id' => $this->categoryId,
            ]);
        }
    }
}
