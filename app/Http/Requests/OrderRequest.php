<?php

namespace App\Http\Requests;

use App\Models\Order;
use App\Support\Countries;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class OrderRequest extends FormRequest
{
    /** @var list<string> */
    private const DISPOSABLE = [
        'mailinator.com', 'guerrillamail.com', 'tempmail.com', 'temp-mail.org',
        '10minutemail.com', 'trashmail.com', 'yopmail.com', 'getnada.com',
        'sharklasers.com', 'discard.email', 'fakeinbox.com', 'mailnesia.com',
    ];

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'customer_name' => $this->cleanLine($this->input('customer_name')),
            'email' => Str::lower(trim((string) $this->input('email'))),
            'phone' => trim((string) $this->input('phone')),
            'company' => $this->cleanLine($this->input('company')),
            'country_code' => strtoupper(trim((string) $this->input('country_code'))),
            'city' => $this->cleanLine($this->input('city')),
            'address' => $this->cleanBody($this->input('address')),
            'notes' => $this->cleanBody($this->input('notes')),
        ]);
    }

    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'min:2', 'max:80'],
            'email' => ['required', 'string', 'email:rfc', 'max:120'],
            'phone' => ['required', 'string', 'min:7', 'max:24'],
            'company' => ['nullable', 'string', 'max:120'],
            'country_code' => ['required', 'string', 'size:2', 'in:'.implode(',', array_keys(Countries::all()))],
            'city' => ['required', 'string', 'min:2', 'max:80'],
            'address' => ['required', 'string', 'min:8', 'max:240'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'form_started' => ['required', 'integer'],
            'website' => ['nullable', 'string', 'max:200'],
        ];
    }

    public function messages(): array
    {
        return [
            'form_started.required' => __('messages.order_try_again'),
            'country_code.required' => __('messages.order_pick_country'),
            'country_code.in' => __('messages.order_pick_country'),
            'email.email' => __('messages.order_email_invalid'),
            'city.required' => __('messages.order_city_required'),
            'address.required' => __('messages.order_address_required'),
            'address.min' => __('messages.order_address_short'),
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
                $validator->errors()->add('form_started', __('messages.order_try_again'));
            }

            $name = (string) $this->input('customer_name');
            if (! preg_match('/\p{L}.*\p{L}/u', $name) || preg_match('/https?:\/\/|www\.|@/i', $name)) {
                $validator->errors()->add('customer_name', __('messages.order_name_invalid'));
            } elseif (preg_match('/^(test|asdf|qwerty|admin|user|fake|spam|aaa|xxx)$/iu', $name)) {
                $validator->errors()->add('customer_name', __('messages.order_name_invalid'));
            }

            $email = (string) $this->input('email');
            $domain = Str::after($email, '@');
            if ($domain !== '' && in_array($domain, self::DISPOSABLE, true)) {
                $validator->errors()->add('email', __('messages.order_email_disposable'));
            }

            $code = (string) $this->input('country_code');
            $e164 = Countries::e164($code, (string) $this->input('phone'));
            if ($e164 === null) {
                $validator->errors()->add('phone', __('messages.order_phone_invalid'));
            }

            $city = (string) $this->input('city');
            if (! preg_match('/\p{L}/u', $city) || preg_match('/https?:\/\/|www\.|@/i', $city)) {
                $validator->errors()->add('city', __('messages.order_city_invalid'));
            }

            $address = (string) $this->input('address');
            if (! preg_match('/\p{L}/u', $address)) {
                $validator->errors()->add('address', __('messages.order_address_invalid'));
            }
            if (! preg_match('/\d/u', $address) && ! preg_match('/\b(st|street|rd|road|ave|avenue|blvd|kg|kk|sector|district|rue|way|lane|close|house|po|box)\b/iu', $address)) {
                $validator->errors()->add('address', __('messages.order_address_invalid'));
            }
            if (preg_match_all('/https?:\/\/|www\./i', $address.' '.(string) $this->input('notes')) > 1) {
                $validator->errors()->add('notes', __('messages.contact_too_many_links'));
            }

            if ($e164 && $email !== '' && ! $validator->errors()->any()) {
                $recent = Order::query()
                    ->where('email', $email)
                    ->where('phone', $e164)
                    ->where('created_at', '>', now()->subMinutes(20))
                    ->exists();
                if ($recent) {
                    $validator->errors()->add('email', __('messages.order_duplicate'));
                }
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
     * @return array{
     *     customer_name:string,email:string,phone:string,company:?string,
     *     country:string,city:string,address:string,notes:?string
     * }
     */
    public function safePayload(): array
    {
        $code = (string) $this->validated('country_code');

        return [
            'customer_name' => (string) $this->validated('customer_name'),
            'email' => (string) $this->validated('email'),
            'phone' => Countries::e164($code, (string) $this->validated('phone')) ?? (string) $this->validated('phone'),
            'company' => $this->validated('company') ?: null,
            'country' => Countries::name($code) ?? $code,
            'city' => (string) $this->validated('city'),
            'address' => (string) $this->validated('address'),
            'notes' => $this->validated('notes') ?: null,
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
