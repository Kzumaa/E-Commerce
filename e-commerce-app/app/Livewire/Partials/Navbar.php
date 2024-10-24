<?php

namespace App\Livewire\Partials;

use App\Helpers\CartManagement;
use Livewire\Attributes\On;
use Livewire\Component;

class Navbar extends Component
{

    public $totalCount = 0;

    public function mount(): void
    {
        $this->totalCount = count(CartManagement::getCartItemsFromCookie());
    }

    #[On('updateCartCount')]
    public function updateCartCount($totalCount): void
    {
        $this->totalCount = $totalCount;
    }
    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('livewire.partials.navbar');
    }
}
