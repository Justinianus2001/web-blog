<?php

namespace App\Http\Requests;

use App\Helpers\AppHelper;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // dd($this->all());
        $user = $this->user();

        return isset($user) && $user->id == $this->route('user')->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes'],
            'password' => ['nullable', 'min:6', 'max:20', 'confirmed'],
            'avatarFile' => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];
    }

    protected function prepareForValidation(): void
    {
        dd($this->all());
        if ($this->hasFile('avatarFile')) {
            $this->merge([
                'avatar' => AppHelper::uploadImage($this->file('avatarFile'), 'users'),
            ]);
        }
        foreach ($this->all() as $key => $value) {
            if (is_null($value) || $value == '') {
                unset($this[$key]);
            }
        }
    }
}
