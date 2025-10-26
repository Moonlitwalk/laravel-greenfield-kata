<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentforTicketRequest extends FormRequest
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
            'body' => ['required', 'string','min:1'],
            'id' => ['sometimes', 'integer','exists:comment,id'],
            'user_id' =>['nullable','exists:users,id'], // nullable cause no real users atm
            'ticket_id' => ['required', 'integer', 'exists:tickets,id'] 
        ];
    }
}
