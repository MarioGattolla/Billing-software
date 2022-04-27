<?php

$logged_user = Auth::user();

?>
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="pb-10 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" ml-20 mt-10 bg-white  text-xl ">
                    Edit User : {{$user->name }}
                </div>
                <div class="m-10 bg-gray-100 p-10 border rounded-md">
                    <form method="POST" action="/users/{{$user->id}}" name="users_update_form">
                        @csrf
                        @method('PUT')

                        <div class="pt-2">
                            <p>User Name and Surname</p>
                            <label for="name">
                                <input class="rounded-md " value="{{$user->name}}"  name="name" type="text" id="name"/>
                            </label>
                        </div>

                        <div class="pt-2">
                            <p>User Email</p>
                            <label for="email">
                                <input class="rounded-md" value="{{$user->email}}" type="email" id="email"
                                       name="email"/>
                            </label>
                        </div>


                        <div class="pt-2">
                            <p>New Password</p>
                            <label for="password">
                                <input class="rounded-md " type="password" value="{{$user->password}}" id="password" name="password"/>
                            </label>
                        </div>

                        <div class="pt-2">
                            <p>Role</p>
                            <label>
                                <select id="role" name="role">
                                        <option value="{{null}}">--Select--</option>
                                        <option>Operator</option>
                                        <option>Admin</option>
                                        <option>Super Admin</option>
                                </select>
                            </label>
                        </div>

                        <button
                            class="w-1/5 bg-green-200 mt-3 h-10 rounded-md border border-green-400 hover:bg-green-400 type="
                            type="submit">
                            Submit
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
