<?php

namespace App\Http\Requests;

use App\Models\Student;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class StoreStudentRequest extends FormRequest
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
    protected function failedAuthorization()
    {
        throw new \Illuminate\Auth\Access\AuthorizationException('Akses ditolak: hanya admin yang boleh membuat student.');
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . ($this->student ?? ''),
            'school_id' => 'required|exists:schools,id',
        ];
    }
}
