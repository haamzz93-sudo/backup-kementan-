<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SertifikasiBenih;
use Illuminate\Auth\Access\HandlesAuthorization;

class SertifikasiBenihPolicy
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
        return $user->can('view_any_sertifikasi::benih');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SertifikasiBenih  $sertifikasiBenih
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, SertifikasiBenih $sertifikasiBenih)
    {
        return $user->can('view_sertifikasi::benih');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create_sertifikasi::benih');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SertifikasiBenih  $sertifikasiBenih
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, SertifikasiBenih $sertifikasiBenih)
    {
        return $user->can('update_sertifikasi::benih');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SertifikasiBenih  $sertifikasiBenih
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, SertifikasiBenih $sertifikasiBenih)
    {
        return $user->can('delete_sertifikasi::benih');
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteAny(User $user)
    {
        return $user->can('delete_any_sertifikasi::benih');
    }

    /**
     * Determine whether the user can permanently delete.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SertifikasiBenih  $sertifikasiBenih
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, SertifikasiBenih $sertifikasiBenih)
    {
        return $user->can('force_delete_sertifikasi::benih');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDeleteAny(User $user)
    {
        return $user->can('force_delete_any_sertifikasi::benih');
    }

    /**
     * Determine whether the user can restore.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SertifikasiBenih  $sertifikasiBenih
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, SertifikasiBenih $sertifikasiBenih)
    {
        return $user->can('restore_sertifikasi::benih');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restoreAny(User $user)
    {
        return $user->can('restore_any_sertifikasi::benih');
    }

    /**
     * Determine whether the user can replicate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SertifikasiBenih  $sertifikasiBenih
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function replicate(User $user, SertifikasiBenih $sertifikasiBenih)
    {
        return $user->can('replicate_sertifikasi::benih');
    }

    /**
     * Determine whether the user can reorder.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function reorder(User $user)
    {
        return $user->can('reorder_sertifikasi::benih');
    }

}
