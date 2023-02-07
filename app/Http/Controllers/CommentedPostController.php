<?php

namespace App\Http\Controllers;

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
        $comments = $post->comments->sort(function ($a, $b) {
            $comparand_a = explode('/', substr($a->path.$a->id, 1));
            $comparand_b = explode('/', substr($b->path.$b->id, 1));
            $ret = 0;
            for ($i = 0; $i < min(count($comparand_a), count($comparand_b)); $i++) {
                if ($comparand_a[$i] > $comparand_b[$i]) {
                    $ret = 1;
                    break;
                } elseif ($comparand_a[$i] < $comparand_b[$i]) {
                    $ret = -1;
                    break;
                }
            }
            if ($ret === 0) {
                $ret = count($comparand_a) - count($comparand_b);
            }
            return $ret;
        });

        $post->username = $post->user->username;
        $post->like = PostReaction::where('post_id', $post->id)->where('user_id', $request->user()->id)->value('like');
        $post->total_likes = 0;
        $post->total_dislikes = 0;
        $post_likes = PostReaction::where('post_id', $post->id)->pluck('like')->toArray();
        foreach ($post_likes as $like) {
            $post->total_likes += $like;
            $post->total_dislikes += 1 - $like;
        }
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
            $comment->indentation = substr_count($comment->path, '/') - 1;
            $comment = $comment->only(['id', 'username', 'content', 'like', 'total_likes', 'total_dislikes', 'indentation']);
        }
        $post = $post->only(['id', 'username', 'title', 'content', 'file_name', 'like', 'total_likes', 'total_dislikes']);
        return view('commented_post', ['post' => $post, 'comments' => $comments]);
    }
}
