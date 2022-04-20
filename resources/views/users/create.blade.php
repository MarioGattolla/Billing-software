<?php

use App\Models\User;

/** @var User $user */
$user = Auth::user();

?>

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="pb-10 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" ml-20 mt-10 bg-white  text-xl">
                    Here you can create a new User
                </div>
                <div class="m-10 bg-gray-100 p-10 border rounded-md">
                    <form method="POST" action="{{route('users.store')}}" name="company_create_form">
                        @csrf

                        <div class="pt-2">
                            <p>User Name and Surname</p>
                            <label for="name">
                                <input class="rounded-md " name="name" type="text" id="name" required/>
                            </label>
                        </div>

                        <div class="pt-2">
                            <p>User Email</p>
                                <label for="email">
                                <input class="rounded-md" type="email" id="email" name="email" required/>
                            </label>
                        </div>


                        <div class="pt-2">
                            <p>User Password</p>
                            <label for="password">
                                <input class="rounded-md " type="password" id="password" name="password" required/>
                            </label>
                        </div>

                        <div class="pt-2">
                            <p>Role</p>
                            <label>
                                <select id="role" name="role">
                                    @if($user->hasRole('Super Admin'))
                                        <option>Super Admin</option>
                                        <option>Admin</option>
                                        <option>Operator</option>
                                    @else
                                        <option>Admin</option>
                                        <option>Operator</option>
                                    @endif
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
