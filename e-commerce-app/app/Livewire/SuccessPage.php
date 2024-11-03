<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;

#[Title("Success")]
class SuccessPage extends Component
{
    #[Url]
    public $session_id;

    /**
     * @throws ApiErrorException
     */
    public function render()
    {
        $order = Order::with('address')->where('user_id', auth()->user()->id)->latest()->first();

        if ($this->session_id) {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $session_info = Session::retrieve($this->session_id);

            if ($session_info->payment_status != 'paid') {
                $order->payment_status = 'failed';
                $order->save();
                return redirect()->route('/cancel');
            } else if ($session_info->payment_status == 'paid') {
                $order->payment_status = 'paid';
                $order->save();
            }
        }

        return view('livewire.success-page',
        ['order' => $order]);
    }
}
