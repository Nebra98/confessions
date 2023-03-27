<?php

namespace App\Http\Controllers;

use App\Models\Confession;
use App\Models\Dislike;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeDislikeController extends Controller
{
    public function like(Request $request)
    {
        $confession_id = $request->input('confession_id');
        $user_id = Auth::id();
        $confession = Confession::findOrFail($confession_id);


        $dislike = Dislike::where('confession_id', $confession_id)->where('user_id', $user_id)->first();

        if($dislike)
        {
            $dislike->delete();

            $like = new Like();
            $like->confession_id = $confession_id;
            $like->user_id = $user_id;
            $like->save();

            $likesCount = $confession->likes()->count();
            $dislikesCount = $confession->dislikes()->count();

            return response()->json([
                'success' => true,
                'action' => 'like',
                'likesCount' => $likesCount,
                'dislikesCount' => $dislikesCount
            ]);

        }

        $like = Like::where('confession_id', $confession_id)->where('user_id', $user_id)->first();

        if($like)
        {
            $like->delete();

            $likesCount = $confession->likes()->count();
            $dislikesCount = $confession->dislikes()->count();

            return response()->json([
                'success' => true,
                'action' => 'unlike',
                'likesCount' => $likesCount,
                'dislikesCount' => $dislikesCount
            ]);

        }

        $like = new Like();
        $like->confession_id = $confession_id;
        $like->user_id = $user_id;
        $like->save();

        $likesCount = $confession->likes()->count();
        $dislikesCount = $confession->dislikes()->count();

        return response()->json([
            'success' => true,
            'action' => 'like',
            'likesCount' => $likesCount,
            'dislikesCount' => $dislikesCount
        ]);

    }

    public function dislike(Request $request)
    {
        $confession_id = $request->input('confession_id');
        $user_id = Auth::id();
        $confession = Confession::findOrFail($confession_id);

        $like = Like::where('confession_id', $confession_id)->where('user_id', $user_id)->first();

        if ($like) {
            $like->delete();

            $dislike = new Dislike();
            $dislike->confession_id = $confession_id;
            $dislike->user_id = $user_id;
            $dislike->save();

            $likesCount = $confession->likes()->count();
            $dislikesCount = $confession->dislikes()->count();

            return response()->json([
                'success' => true,
                'action' => 'dislike',
                'likesCount' => $likesCount,
                'dislikesCount' => $dislikesCount
            ]);

        }

        $dislike = Dislike::where('confession_id', $confession_id)->where('user_id', $user_id)->first();

        if ($dislike) {
            $dislike->delete();

            $likesCount = $confession->likes()->count();
            $dislikesCount = $confession->dislikes()->count();

            return response()->json([
                'success' => true,
                'action' => 'undislike',
                'likesCount' => $likesCount,
                'dislikesCount' => $dislikesCount
            ]);

        }

        $dislike = new Dislike();
        $dislike->confession_id = $confession_id;
        $dislike->user_id = $user_id;
        $dislike->save();

        $likesCount = $confession->likes()->count();
        $dislikesCount = $confession->dislikes()->count();

        return response()->json([
            'success' => true,
            'action' => 'dislike',
            'likesCount' => $likesCount,
            'dislikesCount' => $dislikesCount
        ]);

    }

}
