<x-mail::message>
# New message from the website

**Topic:** {{ $payload['subject'] }}

## From

- **Name:** {{ $payload['name'] }}
- **Email:** {{ $payload['email'] }}

## Message

{{ $payload['message'] }}

Reply to this email to write them directly.

{{ config('app.name') }}
</x-mail::message>
