<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\DislikeComment;
use App\Models\LikeComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeDislikeCommentController extends Controller
{
    public function like(Request $request)
    {
        $comment_id = $request->input('comment_id');
        $user_id = Auth::id();
        $comment = Comment::findOrFail($comment_id);

        $dislike = DislikeComment::where('comment_id', $comment_id)->where('user_id', $user_id)->first();

        if($dislike)
        {
            $dislike->delete();

            $like = new LikeComment();
            $like->comment_id = $comment_id;
            $like->user_id = $user_id;
            $like->save();

            $likesCommentCount = $comment->likes()->count();
            $dislikesCommentCount = $comment->dislikes()->count();

            return response()->json([
                'success' => true,
                'action' => 'like-dislike-remove',
                'likesCommentCount' => $likesCommentCount,
                'dislikesCommentCount' => $dislikesCommentCount
            ]);

        }

        $like = LikeComment::where('comment_id', $comment_id)->where('user_id', $user_id)->first();

        if($like)
        {
            $like->delete();

            $likesCommentCount = $comment->likes()->count();
            $dislikesCommentCount = $comment->dislikes()->count();

            return response()->json([
                'success' => true,
                'action' => 'unlike',
                'likesCommentCount' => $likesCommentCount,
                'dislikesCommentCount' => $dislikesCommentCount
            ]);

        }

        $like = new LikeComment();
        $like->comment_id = $comment_id;
        $like->user_id = $user_id;
        $like->save();

        $likesCommentCount = $comment->likes()->count();
        $dislikesCommentCount = $comment->dislikes()->count();

        return response()->json([
            'success' => true,
            'action' => 'like',
            'likesCommentCount' => $likesCommentCount,
            'dislikesCommentCount' => $dislikesCommentCount
        ]);

    }

    public function dislike(Request $request)
    {
        $comment_id = $request->input('comment_id');
        $user_id = Auth::id();
        $comment = Comment::findOrFail($comment_id);

        $like = LikeComment::where('comment_id', $comment_id)->where('user_id', $user_id)->first();

        if($like)
        {
            $like->delete();

            $dislike = new DislikeComment();
            $dislike->comment_id = $comment_id;
            $dislike->user_id = $user_id;
            $dislike->save();

            $likesCommentCount = $comment->likes()->count();
            $dislikesCommentCount = $comment->dislikes()->count();

            return response()->json([
                'success' => true,
                'action' => 'dislike-like-remove',
                'likesCommentCount' => $likesCommentCount,
                'dislikesCommentCount' => $dislikesCommentCount
            ]);

        }

        $dislike = DislikeComment::where('comment_id', $comment_id)->where('user_id', $user_id)->first();

        if($dislike)
        {
            $dislike->delete();

            $likesCommentCount = $comment->likes()->count();
            $dislikesCommentCount = $comment->dislikes()->count();

            return response()->json([
                'success' => true,
                'action' => 'undislike',
                'likesCommentCount' => $likesCommentCount,
                'dislikesCommentCount' => $dislikesCommentCount
            ]);

        }

        $dislike = new DislikeComment();
        $dislike->comment_id = $comment_id;
        $dislike->user_id = $user_id;
        $dislike->save();

        $likesCommentCount = $comment->likes()->count();
        $dislikesCommentCount = $comment->dislikes()->count();

        return response()->json([
            'success' => true,
            'action' => 'dislike',
            'likesCommentCount' => $likesCommentCount,
            'dislikesCommentCount' => $dislikesCommentCount
        ]);

    }


}
