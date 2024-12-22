<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Mail\OrderPlaced;
use App\Models\Address;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Title;
use Livewire\Component;
use Stripe\Checkout\Session;
use Stripe\Stripe;


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

    public function mount()
    {
        $cartItems = CartManagement::getCartItemsFromCookie();
        if (count($cartItems) === 0) {
            $this->redirect('/products');
        }
    }

    public function placeOrder()
    {
        $this->validate([
            "firstName" => "required",
            "lastName" => "required",
            "phone" => "required",
            "address" => "required",
            "city" => "required",
            "state" => "required",
            "zipCode" => "required",
            "paymentMethod" => "required",
        ]);

        $cartItems = CartManagement::getCartItemsFromCookie();
        $lineItems = [];
        $cart = [];

        foreach ($cartItems as $cartItem) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => "USD",
                    'unit_amount' => $cartItem["price"] * 100,
                    'product_data' => [
                        'name' => $cartItem["name"],
                    ]
                ],
                'quantity' => $cartItem["quantity"],
            ];
            $cart[] = [
                'product_id' => $cartItem['productId'],
                'unit_amount' => $cartItem['price'],
                'quantity' => $cartItem['quantity'],
                'total_amount' => $cartItem['totalAmount'],
            ];
        }

        $order = new Order();
        $order->user_id = auth()->id();
        $order->total_price = CartManagement::calculateTotalPrice($cartItems);
        $order->payment_method  = $this->paymentMethod;
        $order->payment_status = 'pending';
        $order->status = 'new';
        $order->currency = 'USD';
        $order->shipping_method = 'none';
        $order->shipping_amount = 0;
        $order->notes = 'Order place by ' . auth()->user()->name ;

        $address = new Address();
        $address->first_name = $this->firstName;
        $address->last_name = $this->lastName;
        $address->phone = $this->phone;
        $address->state = $this->state;
        $address->address = $this->address;
        $address->city = $this->city;
        $address->zip_code = $this->zipCode;

        $redirectUrl = '';

        if ($this->paymentMethod === 'stripe') {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $sessionCheckout = Session::create([
                'payment_method_types' => ['card'],
                'customer_email' => auth()->user()->email,
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.cancel'),
            ]);
            $redirectUrl = $sessionCheckout->url;
        } else {
            $redirectUrl = route('checkout.success');
        }

        try {
            DB::beginTransaction();
            $order->save();
            $address->order_id = $order->id;
            $address->save();
            $order->items()->createMany($cart);
            DB::commit();

            CartManagement::clearCart();
            Mail::to(request()->user())->send(new OrderPlaced($order));
            return redirect($redirectUrl);

        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect($redirectUrl);
        }


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
