<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTimeEntryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'selectedDate' => ['required', 'string'],
            'clocked_in' => ['required', 'string'],
            'clocked_out' => ['required', 'string', 'after:clocked_in'],
            'staff_id' => ['numeric', 'required' ,'exists:staff,id']
        ];
    }

    public function messages(): array
    {
        return [
            'clocked_out.after' => 'The clocked out time must be later than the clocked in time.'
        ];
    }
}
