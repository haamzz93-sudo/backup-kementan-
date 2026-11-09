<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Regulasi;
use Illuminate\Auth\Access\HandlesAuthorization;

class RegulasiPolicy
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
        return $user->can('view_any_regulasi');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Regulasi  $regulasi
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Regulasi $regulasi)
    {
        return $user->can('view_regulasi');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create_regulasi');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Regulasi  $regulasi
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Regulasi $regulasi)
    {
        return $user->can('update_regulasi');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Regulasi  $regulasi
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Regulasi $regulasi)
    {
        return $user->can('delete_regulasi');
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteAny(User $user)
    {
        return $user->can('delete_any_regulasi');
    }

    /**
     * Determine whether the user can permanently delete.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Regulasi  $regulasi
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Regulasi $regulasi)
    {
        return $user->can('force_delete_regulasi');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDeleteAny(User $user)
    {
        return $user->can('force_delete_any_regulasi');
    }

    /**
     * Determine whether the user can restore.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Regulasi  $regulasi
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Regulasi $regulasi)
    {
        return $user->can('restore_regulasi');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restoreAny(User $user)
    {
        return $user->can('restore_any_regulasi');
    }

    /**
     * Determine whether the user can replicate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Regulasi  $regulasi
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function replicate(User $user, Regulasi $regulasi)
    {
        return $user->can('replicate_regulasi');
    }

    /**
     * Determine whether the user can reorder.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function reorder(User $user)
    {
        return $user->can('reorder_regulasi');
    }

}
