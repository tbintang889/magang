<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class StudentExportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // $user = auth()->user();
        $user = auth()->user();
        Log::info('Authorize check', ['user' => $user]);

    // return $user && $user->role === 'admin';

        // dd($user->role);
        if (!$user) {
            Log::warning('Authorization failed: no authenticated user.');
            return false;
        }

        $isAuthorized = $user?->hasRole('admin');

        if (!$isAuthorized) {
            Log::info("Authorization denied for user {$user->id} with role '{$user->role}'");
        }

        return $isAuthorized;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
   public function rules(): array
{
    return [
        'school_id' => ['nullable', 'integer', 'exists:schools,id'],
        'class'     => ['nullable', 'string', 'max:10'],
        'status'    => ['nullable', 'in:active,inactive,graduated'],
    ];
}
}
