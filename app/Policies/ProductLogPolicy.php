<?php

namespace App\Policies;

use App\Models\ProductLog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProductLogPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ProductLog $productLog): bool
    {
        return $productLog->creator->is($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProductLog $productLog): bool
    {
        return $productLog->creator->is($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProductLog $productLog): bool
    {
        return $productLog->creator->is($user);
    }
}
