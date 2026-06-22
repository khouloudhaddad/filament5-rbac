<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Post');
    }

    public function view(AuthUser $authUser, Post $post): bool
    {
        // Authors are allowed to only view their posts
        if ($authUser->hasRole('author')) {
            return $authUser->can('View:Post') && $post->user_id === $authUser->id;
        }

        // Super admin  & editor can view all posts
        return $authUser->can('View:Post');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Post');
    }

    public function update(AuthUser $authUser, Post $post): bool
    {
        if ($authUser->hasRole ('author') && $authUser->id === $post->user_id) {
            return $authUser->can('Update:Post');
        }

        if ($authUser->hasRole('editor') || $authUser->hasRole('super_admin')){
            return $authUser->can('Update:Post');
        }

        return false;
    }

    public function delete(AuthUser $authUser, Post $post): bool
    {
         if ($authUser->hasRole('author')) {
            return $authUser->can('Delete:Post') && $authUser->id === $post->user_id;
        }
        return $authUser->can('Delete:Post');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Post');
    }

    public function restore(AuthUser $authUser, Post $post): bool
    {
        return $authUser->can('Restore:Post');
    }

    public function forceDelete(AuthUser $authUser, Post $post): bool
    {
        return $authUser->can('ForceDelete:Post');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Post');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Post');
    }

    public function replicate(AuthUser $authUser, Post $post): bool
    {
        return $authUser->can('Replicate:Post');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Post');
    }

    public function publish(AuthUser $authUser, Post $post): bool
    {
        return $authUser->can('Publish:Post');
    }
}
