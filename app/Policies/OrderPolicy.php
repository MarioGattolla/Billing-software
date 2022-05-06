<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        if ($user->can('show order')){
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function view(User $user, Order $order)
    {
        {
            if ($user->can('show order')){
                return true;
            }
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function createOrder(User $user)
    {
        {
            if ($user->can('create order')){
                return true;
            }
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function editOrder(User $user, Order $order)
    {
        {
            if ($user->can('edit order')){
                return true;
            }
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function deleteOrder(User $user, Order $order)
    {
        {
            if ($user->can('delete order')){
                return true;
            }
        }
    }

}
