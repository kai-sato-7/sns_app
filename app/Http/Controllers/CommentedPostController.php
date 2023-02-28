<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentReaction;
use App\Models\Post;
use App\Models\PostReaction;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommentedPostController extends Controller
{
    public function edit(Request $request, $id): View
    {
        $post = Post::findOrFail($id);
        $comments = $this->depth_first_search($post);
        foreach ($comments as $comment) {
            $comment->username = $comment->user->username;
            $comment->like = CommentReaction::where('comment_id', $comment->id)->where('user_id', $request->user()->id)->value('like');
            $comment->total_likes = 0;
            $comment->total_dislikes = 0;
            $comment_likes = CommentReaction::where('comment_id', $comment->id)->pluck('like')->toArray();
            foreach ($comment_likes as $like) {
                $comment->total_likes += $like;
                $comment->total_dislikes += 1 - $like;
            }
            $comment = $comment->only(['id', 'username', 'content', 'like', 'total_likes', 'total_dislikes', 'level']);
        }

        $post->username = $post->user->username;
        $post->like = PostReaction::where('post_id', $post->id)->where('user_id', $request->user()->id)->value('like');
        $post->total_likes = 0;
        $post->total_dislikes = 0;
        $post_likes = PostReaction::where('post_id', $post->id)->pluck('like')->toArray();
        foreach ($post_likes as $like) {
            $post->total_likes += $like;
            $post->total_dislikes += 1 - $like;
        }
        $post = $post->only(['id', 'username', 'title', 'content', 'file_name', 'like', 'total_likes', 'total_dislikes', 'created_at']);

        return view('commented_post', ['post' => $post, 'comments' => $comments]);
    }

    public function depth_first_search($post)
    {
        $ret = [];
        $stack = [];
        $comments = $post->comments;

        for ($i = $comments->count() - 1; $i >= 0; $i--) {
            array_push($stack, $comments[$i]);
        }
        while (count($stack) > 0) {
            $top = array_pop($stack);
            array_push($ret, $top);
            $comments = $top->comments;
            for ($i = $comments->count() - 1; $i >= 0; $i--) {
                array_push($stack, $comments[$i]);
            }
        }

        return $ret;
    }
}
