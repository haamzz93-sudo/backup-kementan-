<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ProduksiBenihAPBD;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProduksiBenihAPBDPolicy
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
        return $user->can('view_any_produksi::benih::a::p::b::d');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProduksiBenihAPBD  $produksiBenihAPBD
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ProduksiBenihAPBD $produksiBenihAPBD)
    {
        return $user->can('view_produksi::benih::a::p::b::d');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create_produksi::benih::a::p::b::d');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProduksiBenihAPBD  $produksiBenihAPBD
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ProduksiBenihAPBD $produksiBenihAPBD)
    {
        return $user->can('update_produksi::benih::a::p::b::d');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProduksiBenihAPBD  $produksiBenihAPBD
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ProduksiBenihAPBD $produksiBenihAPBD)
    {
        return $user->can('delete_produksi::benih::a::p::b::d');
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteAny(User $user)
    {
        return $user->can('delete_any_produksi::benih::a::p::b::d');
    }

    /**
     * Determine whether the user can permanently delete.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProduksiBenihAPBD  $produksiBenihAPBD
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ProduksiBenihAPBD $produksiBenihAPBD)
    {
        return $user->can('force_delete_produksi::benih::a::p::b::d');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDeleteAny(User $user)
    {
        return $user->can('force_delete_any_produksi::benih::a::p::b::d');
    }

    /**
     * Determine whether the user can restore.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProduksiBenihAPBD  $produksiBenihAPBD
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ProduksiBenihAPBD $produksiBenihAPBD)
    {
        return $user->can('restore_produksi::benih::a::p::b::d');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restoreAny(User $user)
    {
        return $user->can('restore_any_produksi::benih::a::p::b::d');
    }

    /**
     * Determine whether the user can replicate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProduksiBenihAPBD  $produksiBenihAPBD
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function replicate(User $user, ProduksiBenihAPBD $produksiBenihAPBD)
    {
        return $user->can('replicate_produksi::benih::a::p::b::d');
    }

    /**
     * Determine whether the user can reorder.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function reorder(User $user)
    {
        return $user->can('reorder_produksi::benih::a::p::b::d');
    }

}
