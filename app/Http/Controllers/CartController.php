<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private CartService $cart) {}

    public function index()
    {
        return view('frontend.cart', [
            'items' => $this->cart->items(),
            'subtotal' => $this->cart->subtotal(),
            'count' => $this->cart->count(),
        ]);
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'qty' => 'nullable|integer|min:1|max:500',
        ]);

        $this->cart->add($product, (int) ($request->input('qty') ?? 1));

        if ($request->wantsJson()) {
            return response()->json([
                'ok' => true,
                'count' => $this->cart->count(),
            ]);
        }

        return back()->with('cart_success', __('messages.cart_added'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'qty' => 'required|integer|min:0|max:500',
        ]);

        $this->cart->update($product->id, (int) $request->input('qty'));

        return back()->with('cart_success', __('messages.cart_updated'));
    }

    public function remove(Product $product)
    {
        $this->cart->remove($product->id);

        return back()->with('cart_success', __('messages.cart_removed'));
    }
}
