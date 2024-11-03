<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Checkout")]
class CheckoutPage extends Component
{


//'order_id',
//'first_name',
//'last_name',
//'phone',
//'address',
//'city',
//'state',
//'zip_code',
    public $firstName;
    public $lastName;
    public $phone;
    public $address;
    public $city;
    public $state;
    public $zipCode;
    public $paymentMethod = 'cod';

    public function placeOrder()
    {
        $this->validate([
            "firstName" => "required",
            "lastName" => "required",
            "phone" => "required|numeric",
            "address" => "required",
            "city" => "required",
            "state" => "required",
            "zipCode" => "required",
            "paymentMethod" => "required",
        ]);
    }

    public function render()
    {
        $cartItems = CartManagement::getCartItemsFromCookie();
        return view('livewire.checkout-page', [
            'cartItems' => $cartItems,
            'totalPrice' => CartManagement::calculateTotalPrice($cartItems)
        ]);
    }
}
