<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;


#[Title('Product Detail')]
class ProductDetailPage extends Component
{
    use LivewireAlert;
    public $slug;

    public $quantity = 1;

    public function increaseQuantity(): void
    {
        $this->quantity++;
    }

    public function decreaseQuantity(): void
    {
        if ($this->quantity > 1) {
            $this->quantity--;

        }
    }

    public function addToCart(int $productId): void
    {
        $totalCount = CartManagement::addItemsToCart($productId, $this->quantity);

        $this->dispatch('updateCartCount',totalCount: $totalCount)->to(Navbar::class);

        $this->alert('success', 'Product added to cart successfully!', [
            'position' =>  'bottom-end',
            'timer' =>  3000,
            'toast' =>  true,
        ]);
    }

    public function mount($slug): void
    {
        $this->slug = $slug;
    }

    public function render(): Application|Factory|View|\Illuminate\View\View
    {


        return view('livewire.product-detail-page', [
            'product' => Product::query()->where('slug', $this->slug)->firstOrFail(),
        ]);
    }
}
