<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Title;
use Livewire\Component;


#[Title('Product Detail - KZTech')]
class ProductDetailPage extends Component
{
    public $slug;

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
