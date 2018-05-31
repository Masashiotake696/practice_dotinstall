<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;
use App\Http\Requests\CommentRequest;

class CommentsController extends Controller
{

  public function store(CommentRequest $request, Post $post) {
    $comment = new Comment(['body' => $request->body]);
    $post->comments()->save($comment);

    return redirect()->action('PostsController@show', $post);
  }

  public function destroy(Post $post, Comment $comment) {
    $comment->delete();
    
    return redirect()->back();
  }
}
