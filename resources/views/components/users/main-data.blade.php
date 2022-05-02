@props(['user'])

<?php

    use App\Models\User;
    /** @var User $user */

?>


<div class="pt-2">
    <p>Name</p>
    <label for="name">
        <input class="rounded-md " name="name" type="text" id="name"  value="{{$user->name}}" required/>
    </label>
</div>

<div class="pt-2">
    <p>Email</p>
    <label for="email">
        <input class="rounded-md" type="email" id="email" name="email" value="{{$user->email}}" required/>
    </label>
</div>


<div class="pt-2">
    <p>Password</p>
    <label for="password">
        <input class="rounded-md " type="password" id="password" name="password"/>
    </label>
</div>

<div class="pt-2">
    <p>Role</p>
    <label>
        <select id="role" name="role" required>

            @foreach(\App\Enums\Role::get_roles_cases_values() as $role)
            <option value="{{$role}}" @selected($user->roles->first->name)>
                {{ucfirst($role)}}
            </option>
            @endforeach
        </select>
    </label>
</div>
