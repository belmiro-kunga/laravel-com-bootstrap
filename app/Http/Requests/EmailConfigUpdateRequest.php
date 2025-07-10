<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailConfigUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasPermission('system-config.menu');
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'MAIL_MAILER' => 'required|in:smtp,sendmail,mailgun,ses,postmark,log,array',
            'MAIL_FROM_ADDRESS' => 'required|email',
            'MAIL_FROM_NAME' => 'required|string|max:255',
        ];

        // Regras específicas para SMTP
        if ($this->input('MAIL_MAILER') === 'smtp') {
            $rules = array_merge($rules, [
                'MAIL_HOST' => 'required|string|max:255',
                'MAIL_PORT' => 'required|integer|min:1|max:65535',
                'MAIL_USERNAME' => 'required|string|max:255',
                'MAIL_PASSWORD' => 'sometimes|string|max:255',
                'MAIL_ENCRYPTION' => 'required|in:tls,ssl,null',
            ]);
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'MAIL_MAILER.required' => 'O driver de email é obrigatório.',
            'MAIL_MAILER.in' => 'O driver de email deve ser um dos tipos válidos.',
            
            'MAIL_FROM_ADDRESS.required' => 'O email remetente é obrigatório.',
            'MAIL_FROM_ADDRESS.email' => 'O email remetente deve ser um email válido.',
            
            'MAIL_FROM_NAME.required' => 'O nome remetente é obrigatório.',
            'MAIL_FROM_NAME.max' => 'O nome remetente não pode ter mais de 255 caracteres.',
            
            'MAIL_HOST.required' => 'O host SMTP é obrigatório quando usando SMTP.',
            'MAIL_HOST.max' => 'O host SMTP não pode ter mais de 255 caracteres.',
            
            'MAIL_PORT.required' => 'A porta SMTP é obrigatória quando usando SMTP.',
            'MAIL_PORT.integer' => 'A porta SMTP deve ser um número inteiro.',
            'MAIL_PORT.min' => 'A porta SMTP deve ser maior que 0.',
            'MAIL_PORT.max' => 'A porta SMTP deve ser menor que 65536.',
            
            'MAIL_USERNAME.required' => 'O usuário SMTP é obrigatório quando usando SMTP.',
            'MAIL_USERNAME.max' => 'O usuário SMTP não pode ter mais de 255 caracteres.',
            
            'MAIL_PASSWORD.max' => 'A senha SMTP não pode ter mais de 255 caracteres.',
            
            'MAIL_ENCRYPTION.required' => 'A criptografia SMTP é obrigatória quando usando SMTP.',
            'MAIL_ENCRYPTION.in' => 'A criptografia deve ser TLS, SSL ou nenhuma.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'MAIL_MAILER' => 'driver de email',
            'MAIL_HOST' => 'host SMTP',
            'MAIL_PORT' => 'porta SMTP',
            'MAIL_USERNAME' => 'usuário SMTP',
            'MAIL_PASSWORD' => 'senha SMTP',
            'MAIL_ENCRYPTION' => 'criptografia SMTP',
            'MAIL_FROM_ADDRESS' => 'email remetente',
            'MAIL_FROM_NAME' => 'nome remetente',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Filtrar dados vazios
        $data = $this->all();
        
        // Só sobrescrever a senha se o campo for preenchido
        if (empty($data['MAIL_PASSWORD'])) {
            unset($data['MAIL_PASSWORD']);
        }
        
        $this->replace($data);
    }
}
