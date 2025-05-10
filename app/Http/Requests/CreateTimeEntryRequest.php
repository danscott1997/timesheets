<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class CreateTimeEntryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'selectedDate' => ['required', 'string'],
            'clocked_in' => ['required', 'string'],
            'clocked_out' => ['required', 'string'],
            'staff_id' => ['numeric', 'required' ,'exists:staff,id']
        ];
    }
}
