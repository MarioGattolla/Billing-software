@if (session()->has('success'))
    <div x-data="{ show: true }"
         x-init="setTimeout(() => show = false, 5000)"
         x-show="show"
         class="max-w-7xl mx-auto sm:px-7 lg:px-8 mt-5 p-6 bg-blue-100 text-black-50  rounded-xl  text-md text-center"
    >
        <div class="ml-12">{{ session('success') }}</div>
    </div>
@endif
