<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Password;

class RegesterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name'=>'required|alpha:ascii',
            'last_name'=>'required|alpha:ascii',
            'location'=>'required',
            'phone_number'=>'required|unique:users|size:10',
            'password'=>'required|confirmed|min:8|max:30',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif'
            //
        ];
    }
}
