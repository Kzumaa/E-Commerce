<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Home Page - KZTech")]


class HomePage extends Component
{
    public function render(): View|Factory|Application
    {
        $brands = Brand::query()->where('is_active', 1)->get();
        $categories = Category::query()->where('is_active', 1)->get();
        return view('livewire.home-page', [
            'brands' => $brands,
            'categories' => $categories
        ]);
    }

}
