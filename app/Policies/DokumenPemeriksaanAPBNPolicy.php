<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DokumenPemeriksaanAPBN;
use Illuminate\Auth\Access\HandlesAuthorization;

class DokumenPemeriksaanAPBNPolicy
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
        return $user->can('view_any_dokumen::pemeriksaan::a::p::b::n');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DokumenPemeriksaanAPBN  $dokumenPemeriksaanAPBN
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, DokumenPemeriksaanAPBN $dokumenPemeriksaanAPBN)
    {
        return $user->can('view_dokumen::pemeriksaan::a::p::b::n');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create_dokumen::pemeriksaan::a::p::b::n');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DokumenPemeriksaanAPBN  $dokumenPemeriksaanAPBN
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, DokumenPemeriksaanAPBN $dokumenPemeriksaanAPBN)
    {
        return $user->can('update_dokumen::pemeriksaan::a::p::b::n');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DokumenPemeriksaanAPBN  $dokumenPemeriksaanAPBN
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, DokumenPemeriksaanAPBN $dokumenPemeriksaanAPBN)
    {
        return $user->can('delete_dokumen::pemeriksaan::a::p::b::n');
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteAny(User $user)
    {
        return $user->can('delete_any_dokumen::pemeriksaan::a::p::b::n');
    }

    /**
     * Determine whether the user can permanently delete.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DokumenPemeriksaanAPBN  $dokumenPemeriksaanAPBN
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, DokumenPemeriksaanAPBN $dokumenPemeriksaanAPBN)
    {
        return $user->can('force_delete_dokumen::pemeriksaan::a::p::b::n');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDeleteAny(User $user)
    {
        return $user->can('force_delete_any_dokumen::pemeriksaan::a::p::b::n');
    }

    /**
     * Determine whether the user can restore.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DokumenPemeriksaanAPBN  $dokumenPemeriksaanAPBN
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, DokumenPemeriksaanAPBN $dokumenPemeriksaanAPBN)
    {
        return $user->can('restore_dokumen::pemeriksaan::a::p::b::n');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restoreAny(User $user)
    {
        return $user->can('restore_any_dokumen::pemeriksaan::a::p::b::n');
    }

    /**
     * Determine whether the user can replicate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DokumenPemeriksaanAPBN  $dokumenPemeriksaanAPBN
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function replicate(User $user, DokumenPemeriksaanAPBN $dokumenPemeriksaanAPBN)
    {
        return $user->can('replicate_dokumen::pemeriksaan::a::p::b::n');
    }

    /**
     * Determine whether the user can reorder.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function reorder(User $user)
    {
        return $user->can('reorder_dokumen::pemeriksaan::a::p::b::n');
    }

}
