<x-app-layout>

    <div class="max-w-7xl mx-auto sm:px-6 mt-2 lg:px-8 py-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

            <x-elements.validation-errors :errors="$errors"/>

            <div class=" ml-20 mt-10 bg-white  text-xl">
                New User
            </div>
            <div class="m-10 ">

                <livewire:users.create/>
            </div>
        </div>

    </div>
</x-app-layout>
