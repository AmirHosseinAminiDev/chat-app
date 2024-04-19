<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendMessageRequest extends FormRequest
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
            'sender_id' => 'required',
            'receiver_id' => 'required',
            'message' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'sender_id.required' => 'ای دی کاربر ارسال کننده را وارد کنید',
            'receiver.required' => 'ای دی کاربر دریافت کننده را وارد کنید',
            'message.required' => 'پیام خود را وارد کنید'
        ];
    }

    public function getSenderId()
    {
        return $this->get('sender_id');
    }

    public function getReceiverId()
    {
        return $this->get('receiver_id');
    }

    public function getMessage()
    {
        return $this->get('message');
    }
}
