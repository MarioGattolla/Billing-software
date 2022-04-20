<?php


?>
<script>
    function modal() {
        return {
            modal: false,
        }
    }

</script>
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" ml-10 p-6 bg-white border-b border-gray-200 text-xl">
                    User : {{$user->name}}
                </div>

                <div class="  p-3 ml-10 mr-10  mb-10" x-data="modal()">
                    <div class="bg-gray-100 p-3 border rounded-md">

                        <div class="bg-white p-3 m-3 rounded-md border-2 w-1/3">Name : {{ $user->name }}</div>
                        <div class="bg-white p-3 m-3 rounded-md border-2 w-1/3">Email : {{ $user->email }}</div>
                        <div class="bg-white p-3 m-3 rounded-md border-2 w-1/3">Role
                            : {{ $user->roles->first()->name }}</div>
                        <div class="bg-white p-3 m-3 rounded-md border-2 w-1/3">Permissions :
                            @foreach($user->getPermissionsViaRoles() as $permission)
                                <li>{{$permission->name}}</li>
                            @endforeach
                        </div>

                        <div>
                            <a href="{{route('users.edit', $user)}}" class="p-3 border rounded-md border-green-400 hover:bg-green-400
                            bg-green-200 text-sm ml-3 mr-5 mt-2 mb-2">Edit
                                User
                            </a>

                            <button class="p-3 border rounded-md border-green-400 hover:bg-green-400
                            bg-green-200 text-sm ml-3 mr-5 mt-2 mb-2 modal" x-on:click="modal = true">Edit
                                User
                            </button>
                        </div>


                        <div x-show="modal == true"
                             class="fixed top-0 right-0 left-0  h-full w-full bg-gray-100 bg-opacity-75 ">
                            <div class="  relative  bg-white rounded-md border ">
                                <div>

                                </div>
                                <div><a href="{{route('users.edit', $user)}}" class="p-3 border rounded-md border-green-400 hover:bg-green-400
                            bg-green-200 text-sm ml-3 mr-5 mt-2 mb-2">Delete User
                                        User
                                    </a></div>
                                <button class="p-3 border rounded-md border-green-400 hover:bg-green-400
                            bg-green-200 text-sm ml-3 mr-5 mt-2 mb-2 modal" x-on:click="modal = false">
                                    Return Back
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
