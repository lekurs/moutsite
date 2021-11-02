<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EditCommentRequest;
use App\Http\Requests\StoreComment;
use App\Models\Comment;
use App\Repository\CommentRepository;

class CommentController
{

    public function __construct(private CommentRepository $commentRepository)
    { }

    public function store(StoreComment $storeComment)
    {
        $data = $storeComment->validated();

        $this->commentRepository->store($data);

        return back();

    }

    public function edit(EditCommentRequest $editCommentRequest)
    {
        $data = $editCommentRequest->validated();

        $this->commentRepository->edit($data);
    }
}
