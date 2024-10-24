<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Title;
use Livewire\Component;



#[Title("Cart")]
class CartPage extends Component
{

    public $cartItems = [];
    public $totalPrice = 0;

    public function mount(): void
    {
        $this->cartItems = CartManagement::getCartItemsFromCookie();
        $this->totalPrice = CartManagement::calculateTotalPrice($this->cartItems);
    }

    public function removeItem(int $productId): void
    {
        $this->cartItems = CartManagement::removeCartItem($productId);
        $this->totalPrice = CartManagement::calculateTotalPrice($this->cartItems);

        $this->dispatch('updateCartCount',totalCount: count($this->cartItems))->to(Navbar::class);

//        $this->alert('success', 'Product added to cart successfully!', [
//            'position' =>  'bottom-end',
//            'timer' =>  3000,
//            'toast' =>  true,
//        ]);
    }

    public function increaseQuantity(int $productId): void
    {
        $this->cartItems = CartManagement::incrementQuantityToCartItem($productId);
        $this->totalPrice = CartManagement::calculateTotalPrice($this->cartItems);
    }

    public function decreaseQuantity(int $productId): void
    {
        $this->cartItems = CartManagement::decrementQuantityToCartItem($productId);
        $this->totalPrice = CartManagement::calculateTotalPrice($this->cartItems);
    }

    public function render(): Application|Factory|View|\Illuminate\View\View
    {
        return view('livewire.cart-page');
    }
}
