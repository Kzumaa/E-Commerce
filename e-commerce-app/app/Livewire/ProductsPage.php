<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Title;
use Livewire\Component;


#[Title('Products - KZTech')]
class ProductsPage extends Component
{
    public function render(): Application|Factory|View|\Illuminate\View\View
    {
        $products = Product::query()->where('is_active', '=', 1);

        return view('livewire.products-page', [
            'products' => $products->paginate(10),
            'brands' => Brand::query()->where('is_active', '=', 1)->get(['id', 'name', 'slug']),
            'categories' => Category::query()->where('is_active', '=', 1)->get(['id', 'name', 'slug']),
        ]);
    }
}
