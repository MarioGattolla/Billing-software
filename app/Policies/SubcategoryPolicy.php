<?php

namespace App\Policies;

use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubcategoryPolicy
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
        if ($user->can('show subcategory')){
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Subcategory $subcategory
     * @return mixed
     */
    public function view(User $user, Subcategory $subcategory)
    {
        if ($user->can('show subcategory')){
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function createSubcategory(User $user)
    {
        if ($user->can('create subcategory')){
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Subcategory $subcategory
     * @return mixed
     */
    public function editSubcategory(User $user, Subcategory $subcategory)
    {
        if ($user->can('edit subcategory')){
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Subcategory $subcategory
     * @return mixed
     */
    public function deleteSubcategory(User $user, Subcategory $subcategory)
    {
        if ($user->can('delete subcategory')){
            return true;
        }
    }


}
