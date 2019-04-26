<?php

namespace App\Policies;

use App\User;
use App\Post;
use App\Comment;

use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function create(User $user, Comment $comment)
    {
        // User can only create comments in posts they own
        return $user->id == $comment->post->userID;
    }

    public function update(User $user, Comment $comment)
    {
        // User can only update comments in posts they own
        return $user->id == $comment->post->userID;
    }

    public function delete(User $user, Comment $comment)
    {
        // User can only delete comments in posts they own
        return $user->id == $comment->post->userID;
    }
}