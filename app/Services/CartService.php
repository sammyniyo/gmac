<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartService
{
    public const SESSION_KEY = 'shop_cart';

    /**
     * @return array<int, array{product_id:int, slug:string, name:string, price:float|null, qty:int}>
     */
    public function items(): array
    {
        return Session::get(self::SESSION_KEY, []);
    }

    public function count(): int
    {
        return (int) collect($this->items())->sum('qty');
    }

    public function add(Product $product, int $qty = 1): void
    {
        abort_unless($product->is_active, 404);
        $qty = max(1, min(500, $qty));

        $cart = $this->items();
        $key = (string) $product->id;

        if (isset($cart[$key])) {
            $cart[$key]['qty'] = min(500, (int) $cart[$key]['qty'] + $qty);
        } else {
            $cart[$key] = [
                'product_id' => $product->id,
                'slug' => $product->slug,
                'name' => $product->name,
                'price' => $product->price !== null ? (float) $product->price : null,
                'qty' => $qty,
            ];
        }

        Session::put(self::SESSION_KEY, $cart);
    }

    public function update(int $productId, int $qty): void
    {
        $cart = $this->items();
        $key = (string) $productId;

        if (! isset($cart[$key])) {
            return;
        }

        if ($qty < 1) {
            unset($cart[$key]);
        } else {
            $cart[$key]['qty'] = min(500, $qty);
        }

        Session::put(self::SESSION_KEY, $cart);
    }

    public function remove(int $productId): void
    {
        $cart = $this->items();
        unset($cart[(string) $productId]);
        Session::put(self::SESSION_KEY, $cart);
    }

    public function clear(): void
    {
        Session::forget(self::SESSION_KEY);
    }

    public function subtotal(): float
    {
        $sum = 0.0;
        foreach ($this->items() as $row) {
            if ($row['price'] === null) {
                continue;
            }
            $sum += (float) $row['price'] * (int) $row['qty'];
        }

        return round($sum, 2);
    }

    /**
     * @return list<array{product_id:int, slug:string, name:string, price:float|null, qty:int, line:float|null}>
     */
    public function linesForOrder(): array
    {
        $lines = [];
        foreach ($this->items() as $row) {
            $line = $row['price'] !== null ? round((float) $row['price'] * (int) $row['qty'], 2) : null;
            $lines[] = [
                'product_id' => (int) $row['product_id'],
                'slug' => $row['slug'],
                'name' => $row['name'],
                'price' => $row['price'],
                'qty' => (int) $row['qty'],
                'line' => $line,
            ];
        }

        return $lines;
    }
}
