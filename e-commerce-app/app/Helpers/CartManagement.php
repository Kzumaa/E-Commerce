<?php

namespace App\Helpers;

use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

class CartManagement
{
    public static function addItemToCart($productId): int
    {
        $cartItems = self::getCartItemsFromCookie();

        $existingItem = null;

        foreach ($cartItems as $key => $item) {
            if ($item['productId'] === $productId) {
                $existingItem = $key;
                break;
            }
        }

        if ($existingItem !== null) {
            $cartItems[$existingItem]['quantity'] += 1;
            $cartItems[$existingItem]['totalAmount'] = $cartItems[$existingItem]['quantity'] * $cartItems[$existingItem]['unitAmount'];
        } else {
            $product = Product::query()->where('id', $productId)->first(['id', 'name', 'price', 'images']);
            if ($product) {
                $cartItems[] = [
                    'productId' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image' => $product->images[0],
                    'quantity' => 1,
                    'totalAmount' => $product->price,
                ];
            }
        }

        self::addCartItemsToCookie($cartItems);
        return count($cartItems);
    }

    public static function removeCartItem($productId): array
    {
        $cartItems = self::getCartItemsFromCookie();

        foreach ($cartItems as $key => $item) {
            if ($item['productId'] === $productId) {
                unset($cartItems[$key]);
            }
        }

        self::addCartItemsToCookie($cartItems);
        return $cartItems;
    }

    public static function addCartItemsToCookie($cartItems): void
    {
        Cookie::queue('cartItems', json_encode($cartItems), 60 * 24 * 30);
    }

    public static function clearCart(): void
    {
        Cookie::queue(Cookie::forget('cartItems'));
    }

    public static function getCartItemsFromCookie() : array
    {
        $cartItems = json_decode(Cookie::get('cartItems'), true);

        if (!$cartItems) {
            $cartItems = [];
        }

        return $cartItems;
    }

    public static function incrementQuantityToCartItem($productId): array
    {
        $cartItems = self::getCartItemsFromCookie();

        foreach ($cartItems as $key => $item) {
            if ($item['productId'] === $productId) {
                $cartItems[$key]['quantity'] += 1;
                $cartItems[$key]['totalAmount'] = $cartItems[$key]['quantity'] * $cartItems[$key]['unitAmount'];
            }
        }

        self::addCartItemsToCookie($cartItems);

        return $cartItems;
    }

    public static function decrementQuantityToCartItem($productId): array
    {
        $cartItems = self::getCartItemsFromCookie();

        foreach ($cartItems as $key => $item) {
            if ($item['productId'] === $productId) {
                if ($item['quantity'] > 1) {
                    $cartItems[$key]['quantity'] -= 1;
                    $cartItems[$key]['totalAmount'] = $cartItems[$key]['quantity'] * $cartItems[$key]['unitAmount'];
                } else {
                    self::removeCartItem($productId);
                }

            }
        }

        self::addCartItemsToCookie($cartItems);
        return $cartItems;
    }

    public static function calculateTotalPrice(array $items): float|int
    {
        return array_sum(array_column($items, 'totalAmount'));
    }
}
