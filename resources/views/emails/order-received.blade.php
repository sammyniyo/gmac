<x-mail::message>
# New order received

**Reference:** {{ $order->reference }}

**Customer:** {{ $order->customer_name }}  
**Email:** {{ $order->email }}  
**Phone:** {{ $order->phone }}  
@if($order->company)
**Company:** {{ $order->company }}  
@endif
@if($order->address)
**Address:** {{ $order->address }}@if($order->city), {{ $order->city }}@endif @if($order->country)({{ $order->country }})@endif  
@endif

**Subtotal:** ${{ number_format($order->subtotal, 2) }}  
**Total:** ${{ number_format($order->total, 2) }}

## Items

@foreach($order->items as $item)
- {{ $item['name'] ?? 'Product' }} × {{ $item['qty'] ?? 0 }}
  @if(isset($item['price']) && $item['price'] !== null)
    @ ${{ number_format((float) $item['price'], 2) }} each
  @else
    (price on request)
  @endif
@endforeach

@if($order->notes)
**Notes from customer:**  
{{ $order->notes }}
@endif

<x-mail::button :url="route('admin.orders.show', $order, true)">
View in admin
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
