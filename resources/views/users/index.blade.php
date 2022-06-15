<script xmlns:x-on="http://www.w3.org/1999/xhtml">
</script>

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" bg-white overflow-hidden  shadow-sm sm:rounded-lg ">

                <div class="flex ml-10 mt-3 p-2">

                    <x-elements.button onclick="Livewire.emit('openModal', 'users.create')">Create User
                    </x-elements.button>
                </div>

                <livewire:users.index/>
            </div>
        </div>
    </div>
</x-app-layout>
