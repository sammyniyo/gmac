<x-mail::message>
# New order request (no payment)

**Reference:** {{ $order->reference }}

This is a request from the website, not an online purchase. Reply to the buyer using the details below.

## Buyer

- **Name:** {{ $order->customer_name }}
- **Email:** {{ $order->email }}
- **Phone:** {{ $order->phone }}
@if($order->company)
- **Company:** {{ $order->company }}
@endif
@if($order->address || $order->city || $order->country)
- **Address:** {{ trim(collect([$order->address, $order->city, $order->country])->filter()->implode(', ')) }}
@endif

## Lots requested

@foreach($order->items as $item)
@php
    $qty = (int) ($item['qty'] ?? 0);
    $price = $item['price'] ?? null;
    $line = $price !== null ? (float) $price * $qty : null;
@endphp
- **{{ $item['name'] ?? 'Product' }}** × {{ $qty }}
  @if(!empty($item['barcode']))
  · barcode {{ $item['barcode'] }}
  @endif
  @if($price !== null)
  {{ \App\Models\Product::rwf((float) $price) }} each
  @if($line !== null)
  · line {{ \App\Models\Product::rwf($line) }}
  @endif
  @else
  (price on request)
  @endif
@endforeach

**Indicative subtotal:** {{ \App\Models\Product::rwf((float) $order->subtotal) }}

@if($order->notes)
## Notes from the buyer

{{ $order->notes }}
@endif

<x-mail::button :url="route('admin.orders.show', $order, true)">
Open in admin
</x-mail::button>

Reply to this email to write the buyer directly.

{{ config('app.name') }}
</x-mail::message>
