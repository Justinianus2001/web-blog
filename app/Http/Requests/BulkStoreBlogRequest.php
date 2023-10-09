<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulkStoreBlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        return isset($user) && $user->tokenCan('blog:store');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            '*.title' => ['required'],
            '*.body' => ['required'],
            '*.categoryId' => ['required', 'exists:categories,id'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $data = [];

        foreach ($this->toArray() as $obj) {
            $obj['user_id'] = $this->user()->id;
            $obj['category_id'] = $obj['categoryId'] ?? '';
            $data[] = $obj;
        }

        $this->merge($data);
    }
}
