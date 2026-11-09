<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Provinces;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProvincesPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->can('view_any_provinces');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Provinces  $provinces
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Provinces $provinces)
    {
        return $user->can('view_provinces');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create_provinces');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Provinces  $provinces
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Provinces $provinces)
    {
        return $user->can('update_provinces');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Provinces  $provinces
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Provinces $provinces)
    {
        return $user->can('delete_provinces');
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteAny(User $user)
    {
        return $user->can('delete_any_provinces');
    }

    /**
     * Determine whether the user can permanently delete.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Provinces  $provinces
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Provinces $provinces)
    {
        return $user->can('force_delete_provinces');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDeleteAny(User $user)
    {
        return $user->can('force_delete_any_provinces');
    }

    /**
     * Determine whether the user can restore.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Provinces  $provinces
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Provinces $provinces)
    {
        return $user->can('restore_provinces');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restoreAny(User $user)
    {
        return $user->can('restore_any_provinces');
    }

    /**
     * Determine whether the user can replicate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Provinces  $provinces
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function replicate(User $user, Provinces $provinces)
    {
        return $user->can('replicate_provinces');
    }

    /**
     * Determine whether the user can reorder.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function reorder(User $user)
    {
        return $user->can('reorder_provinces');
    }

}
