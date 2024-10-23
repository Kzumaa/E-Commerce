<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;


#[Title('Products - KZTech')]
class ProductsPage extends Component
{
    use WithPagination;


    #[Url]
    public $selected_categories = [];

    #[Url]
    public $selected_brands = [];
    #[Url]
    public $featured;
    #[Url]
    public $on_sale;

    #[Url]
    public $price_range = 0;


    public function render(): Application|Factory|View|\Illuminate\View\View
    {
        $products = Product::query()->where('is_active', '=', 1);

        if (!empty($this->selected_categories)) {
            $products->whereIn('category_id', $this->selected_categories);
        }

        if (!empty($this->selected_brands)) {
            $products->whereIn('brand_id', $this->selected_brands);
        }

        if (!empty($this->featured)) {
            $products->where('is_featured', '=', 1);
        }
        if (!empty($this->on_sale)) {
            $products->where('on_sale', '=', 1);
        }

        if ($this->price_range) {
            $products->whereBetween('price', [0, $this->price_range]);
        }

        return view('livewire.products-page', [
            'products' => $products->paginate(9),
            'brands' => Brand::query()->where('is_active', '=', 1)->get(['id', 'name', 'slug']),
            'categories' => Category::query()->where('is_active', '=', 1)->get(['id', 'name', 'slug']),
        ]);
    }
}
