<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255|unique:projects,title',
            'description' => 'nullable|max:65000',
            'link' => 'nullable|url|max:255',
            'preview_image' => 'nullable|url|max:255',
            'type_id' => 'nullable|exists:types,id',
            'technology_id' => 'exists:technologies,id'
        ];

    }
    public function messages()
    {
        return[
            'title.required' => 'Titolo richiesto',
            'title.max' => 'Lunghezza massima titolo di 100 caratteri',
            'title.unique' => 'Il titolo da te inserito esiste gia.',

            'description.max' => 'Lunghezza massima descrizione di 65000 caratteri',

            'link.url' => 'L\'URL inserito non è valido',
            'link.max' => 'Lunghezza massima link di 255 caratteri',

            'preview_image.url' => 'L\'URL inserito non è valido',
            'preview_image.max' => 'Lunghezza massima preview image link di 255 caratteri',

            'type_id.exists' => 'Il valore inserito non è accettabile',

            'technologies_id.exists' => 'Il valore(tecnologia) inserito non è accettabile'

        ];
    }
}
