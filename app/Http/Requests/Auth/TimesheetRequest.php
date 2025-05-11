<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class TimesheetRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'staff' => ['nullable', 'numeric', 'exists:staff,id'],
            'month' => ['nullable', 'string', 'max:10'],
            'year' => ['nullable', 'numeric'],
        ];
    }
}
