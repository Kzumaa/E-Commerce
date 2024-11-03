<?php

namespace App\Livewire;

use App\Models\Category;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Categories")]

class CategoriesPage extends Component
{
    public function render(): View|Factory|Application
    {
        $categories = Category::query()->where('is_active', '=', 1)->get();
        return view('livewire.categories-page',[
            'categories' => $categories
        ]);
    }
}
