<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ExportVarietasMasaSanggah;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExportVarietasMasaSanggahPolicy
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
        return $user->can('view_any_export::varietas::masa::sanggah');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ExportVarietasMasaSanggah  $exportVarietasMasaSanggah
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ExportVarietasMasaSanggah $exportVarietasMasaSanggah)
    {
        return $user->can('view_export::varietas::masa::sanggah');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create_export::varietas::masa::sanggah');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ExportVarietasMasaSanggah  $exportVarietasMasaSanggah
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ExportVarietasMasaSanggah $exportVarietasMasaSanggah)
    {
        return $user->can('update_export::varietas::masa::sanggah');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ExportVarietasMasaSanggah  $exportVarietasMasaSanggah
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ExportVarietasMasaSanggah $exportVarietasMasaSanggah)
    {
        return $user->can('delete_export::varietas::masa::sanggah');
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteAny(User $user)
    {
        return $user->can('delete_any_export::varietas::masa::sanggah');
    }

    /**
     * Determine whether the user can permanently delete.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ExportVarietasMasaSanggah  $exportVarietasMasaSanggah
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ExportVarietasMasaSanggah $exportVarietasMasaSanggah)
    {
        return $user->can('force_delete_export::varietas::masa::sanggah');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDeleteAny(User $user)
    {
        return $user->can('force_delete_any_export::varietas::masa::sanggah');
    }

    /**
     * Determine whether the user can restore.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ExportVarietasMasaSanggah  $exportVarietasMasaSanggah
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ExportVarietasMasaSanggah $exportVarietasMasaSanggah)
    {
        return $user->can('restore_export::varietas::masa::sanggah');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restoreAny(User $user)
    {
        return $user->can('restore_any_export::varietas::masa::sanggah');
    }

    /**
     * Determine whether the user can replicate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ExportVarietasMasaSanggah  $exportVarietasMasaSanggah
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function replicate(User $user, ExportVarietasMasaSanggah $exportVarietasMasaSanggah)
    {
        return $user->can('replicate_export::varietas::masa::sanggah');
    }

    /**
     * Determine whether the user can reorder.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function reorder(User $user)
    {
        return $user->can('reorder_export::varietas::masa::sanggah');
    }

}
