<?php

namespace App\Http\Requests;

use App\Models\KitActivationCode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RedeemCodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => [
                'required',
                'string',
                'regex:/^[A-Z0-9]{6}$/',
                function ($attribute, $value, $fail) {
                    $kitCode = KitActivationCode::where('code', $value)->first();
                    
                    if (!$kitCode) {
                        $fail('The activation code is invalid.');
                        return;
                    }
                    
                    if ($kitCode->status === 'used') {
                        $fail('This activation code has already been used.');
                        return;
                    }
                    
                    if ($kitCode->status === 'blocked') {
                        $fail('This activation code has been blocked.');
                        return;
                    }
                    
                    // Check if user already has access to this module
                    if ($kitCode->module_id) {
                        $user = auth()->user();
                        if ($user->unlockedModules()->where('tinkering_modules.id', $kitCode->module_id)->exists()) {
                            $fail('You already have access to this module.');
                            return;
                        }
                    }

                    // Check if this specific code has already been used by this user
                    $user = auth()->user();
                    $codeAlreadyUsed = \App\Models\ModuleUser::where('user_id', $user->id)
                        ->where('activation_code_id', $kitCode->id)
                        ->first();

                    if ($codeAlreadyUsed) {
                        $fail('This code has already been used by you. Please try a different code.');
                        return;
                    }
                },
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'code.required' => 'Please enter an activation code.',
            'code.regex' => 'The activation code format is invalid. Expected format: 6 alphanumeric characters (e.g., C5LI2P).',
        ];
    }
}
