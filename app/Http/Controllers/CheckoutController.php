<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Mail\OrderReceived;
use App\Models\Order;
use App\Services\CartService;
use App\Support\Countries;
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
            'items' => $this->cart->presented(),
            'subtotal' => $this->cart->subtotal(),
            'count' => $this->cart->count(),
            'countries' => Countries::all(),
        ]);
    }

    public function store(OrderRequest $request)
    {
        if ($this->cart->count() === 0) {
            return redirect()->route('shop')->with('cart_error', __('messages.cart_empty'));
        }

        if ($request->shouldDrop()) {
            return redirect()->route('home');
        }

        $validated = $request->safePayload();
        $lines = $this->cart->linesForOrder();
        $subtotal = $this->cart->subtotal();
        $reference = $this->uniqueReference();

        $order = Order::create([
            'reference' => $reference,
            'status' => Order::STATUS_PENDING,
            'customer_name' => $validated['customer_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'company' => $validated['company'],
            'country' => $validated['country'],
            'city' => $validated['city'],
            'address' => $validated['address'],
            'notes' => $validated['notes'],
            'locale' => app()->getLocale(),
            'items' => $lines,
            'subtotal' => $subtotal,
            'total' => $subtotal,
        ]);

        $this->cart->clear();

        $notify = \App\Models\Setting::where('key', 'contact_email')->value('value')
            ?: config('mail.from.address')
            ?: 'info@gmac.coffee';

        try {
            Mail::to($notify)->send(new OrderReceived($order));
            $order->update(['notified_at' => now()]);
        } catch (\Throwable $e) {
            Log::warning('Order mail failed: '.$e->getMessage());
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

    public function find()
    {
        return view('frontend.order-find');
    }

    public function lookup(Request $request)
    {
        $validated = $request->validate([
            'reference' => ['required', 'string', 'max:40'],
            'email' => ['required', 'email:rfc', 'max:120'],
        ]);

        $reference = strtoupper(trim($validated['reference']));
        $email = Str::lower(trim($validated['email']));

        $order = Order::query()
            ->where('reference', $reference)
            ->where('email', $email)
            ->first();

        if (! $order) {
            return back()
                ->withInput()
                ->withErrors(['reference' => __('messages.order_lookup_missing')]);
        }

        return view('frontend.order-find', compact('order'));
    }

    private function uniqueReference(): string
    {
        do {
            $ref = 'GMAC-'.strtoupper(Str::random(8));
        } while (Order::where('reference', $ref)->exists());

        return $ref;
    }
}
