@props(['active' => false , 'type' => 'a'])

{{--@if ($type === 'a')--}}
{{--<a {{ $attributes }} class="{{ $active ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}--}}
{{-- rounded-md  px-3 py-2 text-sm font-medium " aria-current="{{ request()->is('/') ? 'page' : 'false' }}"> {{ $slot }}</a>--}}
{{--@else--}}
{{--<button {{ $attributes }} class="{{ $active ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}--}}
{{-- rounded-md  px-3 py-2 text-sm font-medium " aria-current="{{ request()->is('/') ? 'page' : 'false' }}"> {{ $slot }}</button>--}}
{{--@endif--}}
@if ($type === 'a')
<div class="{{ $active ? 'border-b-2 border-slate-400' : ' ' }} w-24 flex justify-center">
    <a {{ $attributes }} class="
 text-l font-semibold leading-6 text-gray-900 " aria-current="{{ request()->is('/') ? 'page' : 'false' }}"> {{ $slot }}</a>

</div>
@else
<button {{ $attributes }} class="{{ $active ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}
 text-sm font-semibold leading-6 text-gray-900 " aria-current="{{ request()->is('/') ? 'page' : 'false' }}"> {{ $slot }}</button>
@endif
