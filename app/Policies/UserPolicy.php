<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        if ($user->can('show user')){
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param User $model
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        if ($user->can('show user')){
            return true;
        }
    }


    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function createUser(User $user)
    {
        if ($user->can('create user')){
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function createAdmin(User $user)
    {
        if ($user->can('create admin')){
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function createSuperAdmin(User $user)
    {
        if ($user->can('create super admin')){
            return true;
        }
    }


    /**
     * Determine whether the user can edit the model.
     *
     * @param User $user
     * @param User $model
     * @return mixed
     */
    public function editUser(User $user, User $model)
    {
        if ($user->can('edit user')){
            return true;
        }
    }

    /**
     * Determine whether the user can edit the model.
     *
     * @param User $user
     * @param User $model
     * @return mixed
     */
    public function editAdmin(User $user, User $model)
    {
        if ($user->can('edit admin')){
            return true;
        }
    }

    /**
     * Determine whether the user can edit the model.
     *
     * @param User $user
     * @param User $model
     * @return mixed
     */
    public function editSuperUser(User $user, User $model)
    {
        if ($user->can('edit super admin')){
            return true;
        }
    }


    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param User $model
     * @return mixed
     */
    public function deleteUser(User $user, User $model)
    {
        if ($user->can('delete user')){
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param User $model
     * @return mixed
     */
    public function deleteAdmin(User $user, User $model)
    {
        if ($user->can('delete admin')){
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param User $model
     * @return mixed
     */
    public function deleteSuperAdmin(User $user, User $model)
    {
        if ($user->can('delete super admin')){
            return true;
        }
    }

}
