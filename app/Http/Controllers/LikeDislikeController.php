<?php

namespace App\Http\Controllers;

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

        $dislike = Dislike::where('confession_id', $confession_id)->where('user_id', $user_id)->first();

        if($dislike)
        {
            $dislike->delete();

            $like = new Like();
            $like->confession_id = $confession_id;
            $like->user_id = $user_id;
            $like->save();

            return response()->json(['success' => true, 'action' => 'like']);
        }

        $like = Like::where('confession_id', $confession_id)->where('user_id', $user_id)->first();

        if($like)
        {
            $like->delete();

            return response()->json(['success' => true, 'action' => 'unlike']);
        }

        $like = new Like();
        $like->confession_id = $confession_id;
        $like->user_id = $user_id;
        $like->save();

        return response()->json(['success' => true, 'action' => 'like']);

    }

    public function dislike(Request $request)
    {
        $confession_id = $request->input('confession_id');
        $user_id = Auth::id();

        $like = Like::where('confession_id', $confession_id)->where('user_id', $user_id)->first();

        if ($like) {
            $like->delete();

            $dislike = new Dislike();
            $dislike->confession_id = $confession_id;
            $dislike->user_id = $user_id;
            $dislike->save();

            return response()->json(['success' => true, 'action' => 'dislike']);

        }

        $dislike = Dislike::where('confession_id', $confession_id)->where('user_id', $user_id)->first();

        if ($dislike) {
            $dislike->delete();

            return response()->json(['success' => true, 'action' => 'undislike']);
        }

        $dislike = new Dislike();
        $dislike->confession_id = $confession_id;
        $dislike->user_id = $user_id;
        $dislike->save();

        return response()->json(['success' => true, 'action' => 'dislike']);
    }

}
