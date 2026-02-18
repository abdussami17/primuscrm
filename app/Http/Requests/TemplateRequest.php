<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TemplateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'subject' => ['nullable', 'string', 'max:500'],
            'type' => ['required', 'in:email,text'],
            'body' => ['required', 'string'],
            'category_id' => ['nullable', 'exists:template_categories,id'],
            'is_active' => ['boolean'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'template name',
            'subject' => 'subject line',
            'type' => 'template type',
            'body' => 'template body',
            'category_id' => 'category',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please enter a template name',
            'type.required' => 'Please select a template type',
            'body.required' => 'Template body cannot be empty',
        ];
    }
}