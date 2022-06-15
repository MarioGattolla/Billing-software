<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class=" ml-10 p-6 bg-white border-b border-gray-200 text-xl">
        User : {{$user->name}}
    </div>

    <div class="  p-3 ml-10 mr-10  mb-10" x-data="modal()">
        <div class="bg-gray-100 p-3 border rounded-md">
            <div class="bg-white p-3 m-3 rounded-md border-2">Name : {{ $user->name }}</div>
            <div class="bg-white p-3 m-3 rounded-md border-2">Email : {{ $user->email }}</div>
            <div class="bg-white p-3 m-3 rounded-md border-2 ">Role
                : {{ $user->roles->first()->name }}</div>
            <div class="bg-white p-3 m-3 rounded-md border-2 ">Permissions :
                @foreach($user->getPermissionsViaRoles() as $permission)
                    {{$permission->name}},
                @endforeach
            </div>

            <div>
                <button wire:click="$emit('openModal', 'users.edit', {{ json_encode([$user->id]) }})" class="p-3 border rounded-md border-green-400 hover:bg-green-400
                            bg-green-200 text-sm ml-3 mr-5 mt-2 mb-2">
                    Edit User
                </button>

                <button class="p-3 border rounded-md border-green-400 hover:bg-green-400
                            bg-green-200 text-sm ml-3 mr-5 mt-2 mb-2 modal"
                        wire:click="$emit('openModal', 'delete-model-confirm', {{ json_encode(['User']) }})">
                    Delete User
                </button>
            </div>


        </div>
    </div>
</div>
