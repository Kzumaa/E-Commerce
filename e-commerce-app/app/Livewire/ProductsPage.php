<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;


#[Title('Products - KZTech')]
class ProductsPage extends Component
{
    use WithPagination;
    use LivewireAlert;

    #[Url]
    public $selectedCategories = [];

    #[Url]
    public $selectedBrands = [];
    #[Url]
    public $featured;
    #[Url]
    public $onSale;

    #[Url]
    public $priceRange = 0;

    #[Url]
    public $sort = 'latest';

    public function addToCart(int $productId): void
    {
        $totalCount = CartManagement::addItemToCart($productId);

        $this->dispatch('updateCartCount',totalCount: $totalCount)->to(Navbar::class);

        $this->alert('success', 'Product added to cart successfully!', [
            'position' =>  'bottom-end',
            'timer' =>  3000,
            'toast' =>  true,
        ]);
    }


    public function render(): Application|Factory|View|\Illuminate\View\View
    {
        $products = Product::query()->where('is_active', '=', 1);

        if (!empty($this->selectedCategories)) {
            $products->whereIn('category_id', $this->selectedCategories);
        }

        if (!empty($this->selected_brands)) {
            $products->whereIn('brand_id', $this->selectedBrands);
        }

        if (!empty($this->featured)) {
            $products->where('is_featured', '=', 1);
        }
        if (!empty($this->onSale)) {
            $products->where('on_sale', '=', 1);
        }

        if ($this->priceRange) {
            $products->whereBetween('price', [0, $this->priceRange]);
        }

        if ($this->sort === 'latest') {
            $products->orderBy('created_at', 'desc');
        } elseif ($this->sort === 'oldest') {
            $products->orderBy('price', 'asc');
        }

        return view('livewire.products-page', [
            'products' => $products->paginate(9),
            'brands' => Brand::query()->where('is_active', '=', 1)->get(['id', 'name', 'slug']),
            'categories' => Category::query()->where('is_active', '=', 1)->get(['id', 'name', 'slug']),
        ]);
    }
}
