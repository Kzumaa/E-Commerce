<div>
    <div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">
            Checkout
        </h1>
        <form wire:submit.prevent="placeOrder">
            <div class="grid grid-cols-12 gap-4">
                    <div class="md:col-span-12 lg:col-span-8 col-span-12">
                        <!-- Card -->
                            <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                                <!-- Shipping Address -->
                                <div class="mb-6">
                                    <h2 class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                                        Shipping Address
                                    </h2>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-gray-700 dark:text-white mb-1" for="first_name">
                                                First Name
                                            </label>
                                            <input wire:model="firstName" class="w-full
                                            @error('firstName')
                                            border-red-500
                                            @enderror

                                            rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none" id="first_name" type="text">
                                            @error('firstName')
                                                <div class="text-red-500 text-sm">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-gray-700 dark:text-white mb-1" for="last_name">
                                                Last Name
                                            </label>
                                            <input wire:model="lastName" class="w-full rounded-lg
                                            @error('lastName')
                                            border-red-500
                                            @enderror
                                            border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none" id="last_name" type="text">
                                            @error('lastName')
                                            <div class="text-red-500 text-sm">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <label wire:model="phone" class="block text-gray-700 dark:text-white mb-1" for="phone">
                                            Phone
                                        </label>
                                        <input class="w-full rounded-lg border py-2 px-3
                                        @error('phone')
                                            border-red-500
                                            @enderror

                                        dark:bg-gray-700 dark:text-white dark:border-none" id="phone" type="text">
                                        @error('phone')
                                        <div class="text-red-500 text-sm">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mt-4">
                                        <label wire:model="address" class="block text-gray-700 dark:text-white mb-1" for="address">
                                            Address
                                        </label>
                                        <input class="w-full rounded-lg border py-2 px-3
                                         @error('address')
                                            border-red-500
                                         @enderror

                                         dark:bg-gray-700 dark:text-white dark:border-none" id="address" type="text">
                                        @error('address')
                                        <div class="text-red-500 text-sm">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mt-4">
                                        <label wire:model="city" class="block text-gray-700 dark:text-white mb-1" for="city">
                                            City
                                        </label>
                                        <input class="w-full rounded-lg border py-2 px-3
                                        @error('city')
                                            border-red-500
                                            @enderror
                                        dark:bg-gray-700 dark:text-white dark:border-none" id="city" type="text">
                                        @error('city')
                                        <div class="text-red-500 text-sm">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="grid grid-cols-2 gap-4 mt-4">
                                        <div>
                                            <label class="block text-gray-700 dark:text-white mb-1" for="state">
                                                State
                                            </label>
                                            <input wire:model="state" class="w-full rounded-lg
                                            @error('state')
                                            border-red-500
                                            @enderror border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none" id="state" type="text">
                                            @error('state')
                                            <div class="text-red-500 text-sm">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-gray-700 dark:text-white mb-1" for="zip">
                                                ZIP Code
                                            </label>
                                            <input wire:model="zipCode" class="w-full rounded-lg border py-2
                                            @error('zipCode')
                                            border-red-500
                                            @enderror
                                            px-3 dark:bg-gray-700 dark:text-white dark:border-none" id="zip" type="text">
                                            @error('zipCode')
                                            <div class="text-red-500 text-sm">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="text-lg font-semibold mb-4">
                                    Select Payment Method
                                </div>
                                <ul class="grid w-full gap-6 md:grid-cols-2">
                                    <li>
                                        <input wire:model="paymentMethod" class="hidden peer" id="hosting-small" required="" type="radio" value="cod" />
                                        <label class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700" for="hosting-small">
                                            <div class="block">
                                                <div class="w-full text-lg font-semibold">
                                                    Cash on Delivery
                                                </div>
                                            </div>
                                            <svg aria-hidden="true" class="w-5 h-5 ms-3 rtl:rotate-180" fill="none" viewbox="0 0 14 10" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                </path>
                                            </svg>
                                        </label>
                                    </li>
                                    <li>
                                        <input wire:model="paymentMethod" class="hidden peer" id="hosting-big" type="radio" value="stripe">
                                        <label class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700" for="hosting-big">
                                            <div class="block">
                                                <div class="w-full text-lg font-semibold">
                                                    Stripe
                                                </div>
                                            </div>
                                            <svg aria-hidden="true" class="w-5 h-5 ms-3 rtl:rotate-180" fill="none" viewbox="0 0 14 10" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                </path>
                                            </svg>
                                        </label>
                                    </li>
                                </ul>
                            </div>

                        <!-- End Card -->
                    </div>
                    <div class="md:col-span-12 lg:col-span-4 col-span-12">
                    <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                        <div class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                            ORDER SUMMARY
                        </div>
                        <div class="flex justify-between mb-2 font-bold">
                        <span>
                            Subtotal
                        </span>
                            <span>
                            {{ \Illuminate\Support\Number::currency($totalPrice, "USD") }}
                        </span>
                        </div>
                        <div class="flex justify-between mb-2 font-bold">
                        <span>
                            Taxes
                        </span>
                            <span>
                            {{ \Illuminate\Support\Number::currency(0, "USD") }}
                        </span>
                        </div>
                        <div class="flex justify-between mb-2 font-bold">
                        <span>
                            Shipping Cost
                        </span>
                            <span>
                            {{ \Illuminate\Support\Number::currency(0, "USD") }}
                        </span>
                        </div>
                        <hr class="bg-slate-400 my-4 h-1 rounded">
                        <div class="flex justify-between mb-2 font-bold">
                        <span>
                            Grand Total
                        </span>
                            <span>
                            {{ \Illuminate\Support\Number::currency($totalPrice, "USD") }}
                        </span>
                        </div>
                        </hr>
                    </div>
                    <button type="submit" onFor class="bg-green-500 mt-4 w-full p-3 rounded-lg text-lg text-white hover:bg-green-600">
                        Place Order
                    </button>
                    <div class="bg-white mt-4 rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                        <div class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                            BASKET SUMMARY
                        </div>
                        <ul class="divide-y divide-gray-200 dark:divide-gray-700" role="list">

                            @foreach($cartItems as $item)

                                <li class="py-3 sm:py-4" wire:key="{{ $item['productId'] }}">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <img alt="{{  $item['name'] }}" class="w-12 h-12 rounded-full" src="{{  url('storage', $item['image']) }}">

                                        </div>
                                        <div class="flex-1 min-w-0 ms-4">
                                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                {{  $item['name'] }}
                                            </p>
                                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                Quantity: {{ $item['quantity']  }}
                                            </p>
                                        </div>
                                        <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                            {{ \Illuminate\Support\Number::currency($item['totalAmount'], "USD") }}
                                        </div>
                                    </div>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
