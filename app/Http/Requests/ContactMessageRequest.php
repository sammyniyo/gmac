<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ContactMessageRequest extends FormRequest
{
    public const TOPICS = [
        'Wholesale inquiry',
        'Sample request',
        'Export / shipping',
        'Visit the station',
        'Retail bags',
        'Other',
    ];

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => $this->cleanLine($this->input('name')),
            'email' => Str::lower(trim((string) $this->input('email'))),
            'subject' => $this->cleanLine($this->input('subject')),
            'message' => $this->cleanBody($this->input('message')),
            'product' => $this->cleanLine($this->input('product')),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:80'],
            'email' => ['required', 'string', 'email:rfc', 'max:120'],
            'subject' => ['required', 'string', 'in:'.implode(',', self::TOPICS)],
            'message' => ['required', 'string', 'min:12', 'max:2000'],
            'product' => ['nullable', 'string', 'max:80'],
            'form_started' => ['required', 'integer'],
            'website' => ['nullable', 'string', 'max:200'],
        ];
    }

    public function messages(): array
    {
        return [
            'form_started.required' => __('messages.contact_try_again'),
            'subject.in' => __('messages.contact_pick_topic'),
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator): void {
            if ($this->shouldDrop()) {
                return;
            }

            $started = (int) $this->input('form_started');
            $elapsed = time() - $started;
            if ($started < 1 || $elapsed > 14400) {
                $validator->errors()->add('form_started', __('messages.contact_try_again'));
            }

            $message = (string) $this->input('message');
            if (preg_match_all('/https?:\/\/|www\./i', $message) > 2) {
                $validator->errors()->add('message', __('messages.contact_too_many_links'));
            }
        });
    }

    public function shouldDrop(): bool
    {
        if (filled($this->input('website'))) {
            return true;
        }

        $started = (int) $this->input('form_started');
        $elapsed = time() - $started;

        return $started > 0 && $elapsed >= 0 && $elapsed < 3;
    }

    /**
     * @return array{name:string,email:string,subject:string,message:string}
     */
    public function safePayload(): array
    {
        $message = (string) $this->validated('message');
        $product = $this->cleanLine($this->input('product'));
        if ($product !== '' && ! preg_match('/https?:\/\/|www\./i', $product)) {
            $message = 'Product: '.$product."\n\n".$message;
        }

        return [
            'name' => (string) $this->validated('name'),
            'email' => (string) $this->validated('email'),
            'subject' => (string) $this->validated('subject'),
            'message' => $message,
        ];
    }

    private function cleanLine(mixed $value): string
    {
        $text = html_entity_decode(strip_tags((string) $value), ENT_QUOTES, 'UTF-8');
        $text = str_replace(["\r", "\n", "\t"], ' ', $text);

        return trim(preg_replace('/\s+/', ' ', $text) ?? '');
    }

    private function cleanBody(mixed $value): string
    {
        $text = html_entity_decode(strip_tags((string) $value), ENT_QUOTES, 'UTF-8');
        $text = str_replace("\r\n", "\n", $text);
        $text = preg_replace("/[ \t]+/", ' ', $text) ?? '';

        return trim($text);
    }
}
