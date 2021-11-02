<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class RegisterRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'terms' => 'required|accepted',
            'privacy' => 'required|accepted',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => trans('laravel-auth::laravel-auth.register.fields.name'),
            'email' => trans('laravel-auth::laravel-auth.register.fields.email'),
            'password' => trans('laravel-auth::laravel-auth.register.fields.password'),
            'terms' => trans('laravel-auth::laravel-auth.register.fields.terms'),
            'privacy' => trans('laravel-auth::laravel-auth.register.fields.privacy'),
        ];
    }
}
