<?php

namespace App\Http\Controllers;

use App\Mail\OrderReceived;
use App\Models\Order;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function __construct(private CartService $cart) {}

    public function create()
    {
        if ($this->cart->count() === 0) {
            return redirect()->route('shop')->with('cart_error', __('messages.cart_empty'));
        }

        return view('frontend.checkout', [
            'items' => $this->cart->items(),
            'subtotal' => $this->cart->subtotal(),
        ]);
    }

    public function store(Request $request)
    {
        if ($this->cart->count() === 0) {
            return redirect()->route('shop')->with('cart_error', __('messages.cart_empty'));
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'company' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:120',
            'city' => 'nullable|string|max:120',
            'address' => 'nullable|string|max:2000',
            'notes' => 'nullable|string|max:5000',
        ]);

        $lines = $this->cart->linesForOrder();
        $subtotal = $this->cart->subtotal();

        $reference = $this->uniqueReference();

        $order = Order::create([
            'reference' => $reference,
            'status' => Order::STATUS_PENDING,
            'customer_name' => $validated['customer_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'company' => $validated['company'] ?? null,
            'country' => $validated['country'] ?? null,
            'city' => $validated['city'] ?? null,
            'address' => $validated['address'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'locale' => app()->getLocale(),
            'items' => $lines,
            'subtotal' => $subtotal,
            'total' => $subtotal,
        ]);

        $this->cart->clear();

        $notify = \App\Models\Setting::where('key', 'contact_email')->value('value')
            ?: config('mail.from.address');

        if ($notify) {
            try {
                Mail::to($notify)->send(new OrderReceived($order));
                $order->update(['notified_at' => now()]);
            } catch (\Throwable $e) {
                Log::warning('Order mail failed: '.$e->getMessage());
            }
        }

        return redirect()
            ->route('order.thanks', ['reference' => $order->reference])
            ->with('order_success', true);
    }

    public function thanks(string $reference)
    {
        $order = Order::where('reference', $reference)->firstOrFail();

        return view('frontend.order-thanks', compact('order'));
    }

    private function uniqueReference(): string
    {
        do {
            $ref = 'GMAC-'.strtoupper(Str::random(8));
        } while (Order::where('reference', $ref)->exists());

        return $ref;
    }
}
