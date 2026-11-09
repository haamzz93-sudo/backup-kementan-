<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ExportSebaranVarietas;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExportSebaranVarietasPolicy
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
        return $user->can('view_any_export::sebaran::varietas');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ExportSebaranVarietas  $exportSebaranVarietas
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ExportSebaranVarietas $exportSebaranVarietas)
    {
        return $user->can('view_export::sebaran::varietas');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create_export::sebaran::varietas');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ExportSebaranVarietas  $exportSebaranVarietas
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ExportSebaranVarietas $exportSebaranVarietas)
    {
        return $user->can('update_export::sebaran::varietas');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ExportSebaranVarietas  $exportSebaranVarietas
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ExportSebaranVarietas $exportSebaranVarietas)
    {
        return $user->can('delete_export::sebaran::varietas');
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteAny(User $user)
    {
        return $user->can('delete_any_export::sebaran::varietas');
    }

    /**
     * Determine whether the user can permanently delete.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ExportSebaranVarietas  $exportSebaranVarietas
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ExportSebaranVarietas $exportSebaranVarietas)
    {
        return $user->can('force_delete_export::sebaran::varietas');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDeleteAny(User $user)
    {
        return $user->can('force_delete_any_export::sebaran::varietas');
    }

    /**
     * Determine whether the user can restore.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ExportSebaranVarietas  $exportSebaranVarietas
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ExportSebaranVarietas $exportSebaranVarietas)
    {
        return $user->can('restore_export::sebaran::varietas');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restoreAny(User $user)
    {
        return $user->can('restore_any_export::sebaran::varietas');
    }

    /**
     * Determine whether the user can replicate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ExportSebaranVarietas  $exportSebaranVarietas
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function replicate(User $user, ExportSebaranVarietas $exportSebaranVarietas)
    {
        return $user->can('replicate_export::sebaran::varietas');
    }

    /**
     * Determine whether the user can reorder.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function reorder(User $user)
    {
        return $user->can('reorder_export::sebaran::varietas');
    }

}
