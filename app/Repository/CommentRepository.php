<?php

namespace App\Repository;

use App\Models\Comment;
use Carbon\Carbon;

class CommentRepository
{

    public function edit(array $data)
    {
        $comment = Comment::whereId($data['comment_edit_id']);
        $comment->description = $data['edit_comment_description'];
        $comment->save();
    }

    public function store(array $data)
    {
        $comment = new Comment();
        $comment->description = $data['comment_description'];
        $comment->recipe_id = $data['comment_recipe_id'];
        if (is_null($comment->user_id)) {
            $comment->start_reply = Carbon::now();
        }
        $comment->user_id = $data['comment_user_id'];

        $comment->save();

    }
}
