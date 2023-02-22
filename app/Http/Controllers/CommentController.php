<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
    //
    }

    public function create()
    {
    //
    }

    /**
     * Summary of store
     *
     * @param  StoreCommentRequest  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreCommentRequest $request)
    {
        $comment = new Comment;
        $comment->post_id = $request->post_id;
        $comment->user_id = $request->user_id;
        $comment->comment = $request->comment;
        $comment->save();

        return redirect(route('posts.index'));
    }

    public function show(Comment $comment)
    {
    //
    }

    public function edit(Comment $comment)
    {
    //
    }

    public function update(Request $request, Comment $comment)
    {
    //
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect(route('posts.index'))->with('message', '¡Comentario eliminado!');
    }
}
