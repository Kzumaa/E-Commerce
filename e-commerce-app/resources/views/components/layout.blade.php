<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<header class="bg-white ">
    <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8 " aria-label="Global">
        <div class="flex lg:flex-1">
            <a href="#" class="-m-1.5 p-1.5">
                <span class="sr-only">Your Company</span>
                <img class="h-8 w-auto" src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=600" alt="">
            </a>
        </div>

        <div class="hidden lg:flex lg:gap-x-12">
            <x-nav-link href="/" :active="request()->is('/')" type="a">Home
            </x-nav-link>
            <x-nav-link href="/categories" :active="request()->is('categories')" type="a">Categories
            </x-nav-link>
            <x-nav-link href="/products" :active="request()->is('products')" type="a">Products
            </x-nav-link>

        </div>
        <div class="hidden lg:flex lg:flex-1 lg:justify-end lg:gap-x-12">
            <a href="/cart" class="text-sm font-semibold leading-6 text-gray-900">Cart</a>
            <a href="#" class="text-sm font-semibold leading-6 text-gray-900">Log in <span aria-hidden="true">&rarr;</span></a>
        </div>
    </nav>

</header>

{{ $slot }}
</body>
</html>
