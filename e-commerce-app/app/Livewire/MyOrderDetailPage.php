<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\OrderItem;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Order Detail')]
class MyOrderDetailPage extends Component
{
    public $order;

    public function mount(Order $order)
    {
        $this->order = $order;
    }
    public function render()
    {
        $orderItems = OrderItem::with('product')->where('order_id', $this->order->id)->get();
        return view('livewire.my-order-detail-page', [
            'order' => $this->order,
            'orderItems' => $orderItems]);
    }
}
