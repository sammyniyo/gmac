<x-app-layout>
    <x-slot name="header">
        <div class="shadcn-page-head">
            <div>
                <p class="shadcn-kicker">Order</p>
                <h2 class="shadcn-title font-mono">{{ $order->reference }}</h2>
                <p class="shadcn-desc">Placed {{ $order->created_at->format('F d, Y \a\t H:i') }} · Locale: {{ $order->locale ?? '—' }}</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="shadcn-btn-secondary">Back to list</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
            @endif

            <div class="grid gap-6 lg:grid-cols-3">
                <div class="lg:col-span-2 space-y-6">
                    <div class="shadcn-card p-6">
                        <h3 class="mb-4 text-sm font-semibold uppercase tracking-wider text-muted-foreground">Customer</h3>
                        <dl class="grid gap-3 text-sm sm:grid-cols-2">
                            <div><dt class="text-muted-foreground">Name</dt><dd class="font-medium">{{ $order->customer_name }}</dd></div>
                            <div><dt class="text-muted-foreground">Email</dt><dd><a href="mailto:{{ $order->email }}" class="shadcn-link">{{ $order->email }}</a></dd></div>
                            <div><dt class="text-muted-foreground">Phone</dt><dd><a href="tel:{{ preg_replace('/[^\d+]/', '', $order->phone) }}" class="shadcn-link">{{ $order->phone }}</a></dd></div>
                            @if($order->company)<div><dt class="text-muted-foreground">Company</dt><dd>{{ $order->company }}</dd></div>@endif
                            @if($order->city || $order->country)<div><dt class="text-muted-foreground">Location</dt><dd>{{ trim(implode(', ', array_filter([$order->city, $order->country]))) }}</dd></div>@endif
                        </dl>
                        @if($order->address)
                            <div class="mt-4 text-sm">
                                <dt class="text-muted-foreground mb-1">Address</dt>
                                <dd class="whitespace-pre-wrap">{{ $order->address }}</dd>
                            </div>
                        @endif
                        @if($order->notes)
                            <div class="mt-4 rounded-md border border-border bg-muted/40 p-3 text-sm">
                                <strong class="text-foreground">Notes</strong>
                                <p class="mt-1 text-muted-foreground whitespace-pre-wrap">{{ $order->notes }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="shadcn-card p-6">
                        <h3 class="mb-4 text-sm font-semibold uppercase tracking-wider text-muted-foreground">Line items</h3>
                        <table class="shadcn-table w-full">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Unit</th>
                                    <th>Line</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>{{ $item['name'] ?? '—' }}</td>
                                        <td>{{ $item['qty'] ?? 0 }}</td>
                                        <td>
                                            @if(isset($item['price']) && $item['price'] !== null)
                                                ${{ number_format((float) $item['price'], 2) }}
                                            @else
                                                <span class="text-muted-foreground">On request</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($item['line']) && $item['line'] !== null)
                                                ${{ number_format((float) $item['line'], 2) }}
                                            @else
                                                —
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4 flex justify-end gap-8 border-t border-border pt-4 text-sm">
                            <span class="text-muted-foreground">Subtotal</span>
                            <strong>${{ number_format($order->subtotal, 2) }}</strong>
                        </div>
                        <div class="mt-1 flex justify-end gap-8 text-base font-semibold">
                            <span>Total</span>
                            <strong>${{ number_format($order->total, 2) }}</strong>
                        </div>
                    </div>
                </div>

                <div class="shadcn-card h-fit p-6">
                    <h3 class="mb-4 text-sm font-semibold uppercase tracking-wider text-muted-foreground">Status</h3>
                    <form action="{{ route('admin.orders.update', $order) }}" method="post" class="space-y-4">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="shadcn-select w-full">
                            @foreach(\App\Models\Order::statuses() as $st)
                                <option value="{{ $st }}" @selected($order->status === $st)>{{ ucfirst($st) }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="shadcn-btn w-full">Update status</button>
                    </form>
                    @if($order->notified_at)
                        <p class="mt-4 text-xs text-muted-foreground">Staff notified by email at {{ $order->notified_at->format('M j, Y H:i') }}.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
