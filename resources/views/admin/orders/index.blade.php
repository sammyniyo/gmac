<x-app-layout>
    <x-slot name="header">
        <div class="shadcn-page-head">
            <div>
                <p class="shadcn-kicker">GMAC Admin</p>
                <h2 class="shadcn-title">Orders</h2>
                <p class="shadcn-desc">Wholesale requests submitted from the shop (no payment on site).</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="shadcn-card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="shadcn-table w-full">
                        <thead>
                            <tr>
                                <th>Reference</th>
                                <th>Customer</th>
                                <th>Email</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td class="font-mono text-sm font-medium">{{ $order->reference }}</td>
                                    <td>{{ $order->customer_name }}</td>
                                    <td class="text-muted-foreground text-sm">{{ $order->email }}</td>
                                    <td>${{ number_format($order->total, 2) }}</td>
                                    <td>
                                        <span class="shadcn-badge shadcn-badge--{{ $order->status }}">{{ $order->status }}</span>
                                    </td>
                                    <td class="text-muted-foreground text-sm whitespace-nowrap">{{ $order->created_at->format('M j, Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order) }}" class="shadcn-link">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-10 text-center text-muted-foreground">No orders yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($orders->hasPages())
                    <div class="border-t border-border px-4 py-3">{{ $orders->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
